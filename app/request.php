<?php
	@session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/db.php'; // подключаемся к базе данных
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/json.php'; // работа с json для вывода сообщений через js
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/utils.php'; // вспомогательные функции для работы скриптов
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/user.php'; // вспомогательные функции для с авторизированным пользователем

	$data = $_POST; // Тут у нас будут храниться все значения с полей для обработки.
	$database = connect(); // call datbase

	// Обработка запроса регистрации
	if ($data['method'] == 'register') {
		// Проверка авторизации
		if (isAuth()) {
			exit(toJson(['error' => true, 'message' => 'Вы уже авторизированы ранее.']));
		}

		// Проверяем галочку
		if (!isTrue($data['has_accept'])) {
			exit(toJson(['error' => true, 'message' => 'Согласие на обработку данных и политику конфиденциальности не было дано.']));
		}

		// Проверяем на пустые поля
		foreach ($data as $key => $value) {
			if (empty($value)) {
				exit(toJson(['error' => true, 'message' => 'Поле ' . $key . ' не заполнено.']));
			}
		}

		// Оформляем локальные переменные для регистрации
		$email = $data['email'];
		$login = $data['login'];

		// Проверка занят ли логин и почта так-же валидируем поля повтора пароля
		$CheckLogin = selectOne($database, 'SELECT * FROM `users` WHERE login = "'.$login.'"');
		if ($CheckLogin != null) {
			exit(toJson(['error' => true, 'message' => 'Данный пользователь с таким логином уже зарегистрирован']));
		}

		$checkEmail = selectOne($database, 'SELECT * FROM `users` WHERE email = "'.$email.'"');
		if ($checkEmail != null) {
			exit(toJson(['error' => true, 'message' => 'Данный пользователь с такой почтой уже зарегистрирован']));
		}

		if ($data['password'] != $data['password_repeat']) {
			exit(toJson(['error' => true, 'message' => 'Пароли не совпадают в поле "Пароль", "Повторите пароль"']));
		}

		// Включаем шифрование пароля (защитная мера)
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

		// Добавляем
		sql_request($database, 'INSERT INTO users SET name = "'.$data['fio'].'", login = "'.$data['login'].'", email = "'.$data['email'].'", `password` = "'.$data['password'].'"');
		exit(toJson(['success' => true, 'register' => true, 'message' => 'Вы успешно зарегистрировались.']));
	}

	// Авторизация в личный кабинет
	if ($data['method'] == 'login') {
		// Проверка авторизации
		if (isAuth()) {
			exit(toJson(['error' => true, 'message' => 'Вы уже авторизированы ранее.']));
		}

		// Проверяем на пустые поля
		foreach ($data as $key => $value) {
			if (empty($value)) {
				exit(toJson(['error' => true, 'message' => 'Поле ' . $key . ' не заполнено.']));
			}
		}

		// Оформляем локальные переменные для регистрации
		$login = $data['login'];
		$password = $data['password'];

		// Проверяем данные
		$CheckLogin = selectOne($database, 'SELECT * FROM `users` WHERE login = "'.$login.'"');
		if ($CheckLogin == null) {
			exit(toJson(['error' => true, 'message' => 'Некорректный логин или пароль.']));
		}

		if (!password_verify($password, $CheckLogin['password'])) {
			exit(toJson(['error' => true, 'message' => 'Некорректный логин или пароль.']));
		}

		// Удаляем пароль из выбранных данных, чтобы его не кешировать
		unset($CheckLogin['password']);

		// Добавляем данные в сессию.
		$_SESSION['user'] = $CheckLogin;

		// Сообщаем пользователю 
		exit(toJson(['success' => true, 'login' => true, 'message' => 'Вы успешно авторизировались.']));
	}

	// Create request - создание заявки в личном кабинете (обработчик)
	if ($data['method'] == 'create_thread') {
		if (!isAuth()) {
			exit(toJson(['error' => true, 'message' => 'Вы не авторизировались в личный кабинет.']));
		}

		// Проверяем на пустые поля
		foreach ($data as $key => $value) {
			if (empty($value)) {
				exit(toJson(['error' => true, 'message' => 'Поле ' . $key . ' не заполнено.']));
			}
		}

		// Проверяем существует ли категория
		$category = selectOne($database, 'SELECT * FROM category WHERE name = "'.$data['category'].'"');
		if ($category == null) {
			exit(toJson(['error' => true, 'message' => 'Выберите категорию заявки']));
		}

		// Проверяем существование заявки с таким названием
		$title = $data['title'];
		$requestCheck = selectOne($database, 'SELECT * FROM problems WHERE user_id = "'.$_SESSION['user']['id'].'" AND title = "'.$title.'"');
		if ($requestCheck != null) {
			exit(toJson(['error' => true, 'message' => 'Заявка с таким названием уже зарегистрирована']));
		}

		// Валидируем загружаемый файл и загружаем его на сервер (проблему нашу)
		$files = $_FILES;
		$file = $files['problem'];

		if (!isCorrectFormatFile($file)) {
			exit(toJson(['error' => true, 'message' => 'Файл не соответствует типу. Файл должен быть с типом: (png, jpeg, jpg)']));
		}

		$type = explode('.', $file['name'])[1];
		$fileid = md5(uniqid(rand(), true));

		$upload = move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/uploads/'.$_SESSION['user']['id'].'_'.$fileid.'.'.$type);
		if (!$upload) {
			exit(toJson(['error' => true, 'message' => 'Ошибка загрузки файла.']));
		}

		// Добавляем запись в базу данных
		$image = $_SESSION['user']['id'].'_'.$fileid.'.'.$type;
		$date = date('d.m.Y');

		sql_request($database, 'INSERT INTO problems SET user_id = "'.$_SESSION['user']['id'].'", date = "'.$date.'", title = "'.$title.'", description = "'.$data['description'].'", category_id = "'.$category['id'].'", image_from = "'.$image.'", state = "Новая"');

		exit(toJson(['success' => true, 'message' => 'Заявка создана и добавлена в ваш личный кабинет ожидайте рассмотрения.']));
	}

?>