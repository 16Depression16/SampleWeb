<?php
	@session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/db.php'; // подключаемся к базе данных
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/json.php'; // работа с json для вывода сообщений через js
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/utils.php'; // вспомогательные функции для работы скриптов
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/user.php'; // вспомогательные функции для с авторизированным пользователем

	$data = $_POST; // Тут у нас будут храниться все значения с полей для обработки.
	$database = connect(); // call datbase

	// Обработка запроса создания категории
	if ($data['method'] == 'create_category') {
		// Проверка авторизации
		if (!isAuth()) {
			exit(toJson(['error' => true, 'message' => 'Вы не авторизированы']));
		}

		if (!isAdmin()) {
			exit(toJson(['error' => true, 'message' => 'Недостаточно прав']));
		}

		// Проверяем на пустые поля
		foreach ($data as $key => $value) {
			if (empty($value)) {
				exit(toJson(['error' => true, 'message' => 'Поле ' . $key . ' не заполнено.']));
			}
		}

		$find = selectOne($database, 'SELECT * FROM category WHERE name = "'.$data['title'].'"');
		if ($find != null) {
			exit(toJson(['error' => true, 'message' => 'Категория с таким названием создана ранее.']));
		}

		sql_request($database, 'INSERT INTO category SET name = "'.$data['title'].'"');
		exit(toJson(['category_created' => true, 'message' => 'Категория была создана.']));
	}

	// Отклонение проблемы
	if ($data['method'] == 'decline_problem') {
		// Проверка авторизации
		if (!isAuth()) {
			exit(toJson(['error' => true, 'message' => 'Вы не авторизированы']));
		}

		if (!isAdmin()) {
			exit(toJson(['error' => true, 'message' => 'Недостаточно прав']));
		}

		// Проверяем на пустые поля
		foreach ($data as $key => $value) {
			if (empty($value)) {
				exit(toJson(['error' => true, 'message' => 'Поле ' . $key . ' не заполнено.']));
			}
		}

		$find = selectOne($database, 'SELECT * FROM problems WHERE id = "'.$data['id'].'"');
		if ($find == null) {
			exit(toJson(['error' => true, 'message' => 'Заявка не найдена.']));
		}

		$findState = ($data['state'] == 'declined') ? 'Отклонена' : 'Решена';

		sql_request($database, 'UPDATE problems SET state = "'.$findState.'", reason_decline = "'.$data['reason'].'" WHERE id = "'.$data['id'].'"');
		exit(toJson(['success' => true, 'save' => true, 'message' => 'Заявка обновлена']));
	}

	// Проблема решена + фото
	if ($data['method'] == 'solved_problem') {
		// Проверка авторизации
		if (!isAuth()) {
			exit(toJson(['error' => true, 'message' => 'Вы не авторизированы']));
		}

		if (!isAdmin()) {
			exit(toJson(['error' => true, 'message' => 'Недостаточно прав']));
		}

		// Проверяем на пустые поля
		foreach ($data as $key => $value) {
			if (empty($value)) {
				exit(toJson(['error' => true, 'message' => 'Поле ' . $key . ' не заполнено.']));
			}
		}

		$find = selectOne($database, 'SELECT * FROM problems WHERE id = "'.$data['id'].'"');
		if ($find == null) {
			exit(toJson(['error' => true, 'message' => 'Заявка не найдена.']));
		}

		$files = $_FILES;
		$file = $files['file'];

		if (!isCorrectFormatFile($file)) {
			exit(toJson(['error' => true, 'message' => 'Файл не соответствует типу. Файл должен быть с типом: (png, jpeg, jpg)']));
		}

		$type = explode('.', $file['name'])[1];
		$fileid = md5(uniqid(rand(), true));

		$upload = move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/uploads/solved_'.$_SESSION['user']['id'].'_'.$fileid.'.'.$type);
		if (!$upload) {
			exit(toJson(['error' => true, 'message' => 'Ошибка загрузки файла.']));
		}

		$image = 'solved_'.$_SESSION['user']['id'].'_'.$fileid.'.'.$type;
		$findState = ($data['state'] == 'declined') ? 'Отклонена' : 'Решена';

		sql_request($database, 'UPDATE problems SET state = "'.$findState.'", image_to = "'.$image.'" WHERE id = "'.$data['id'].'"');
		exit(toJson(['success' => true, 'save' => true, 'message' => 'Заявка обновлена']));
	}

?>