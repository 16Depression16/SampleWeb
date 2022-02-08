<?php
	@session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/db.php'; // подключаемся к базе данных
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/json.php'; // работа с json для вывода сообщений через js
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/utils.php'; // вспомогательные функции для работы скриптов

	$data = $_POST; // Тут у нас будут храниться все значения с полей для обработки.
	$database = connect(); // call datbase

	// Обработка запроса регистрации
	if ($data['method'] == 'register') {
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

	// Create request - создание заявки в личном кабинете (обработчик)
	if ($data['method'] == 'login') {
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

	if ($data['method'] == 'login') {
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

?>