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

?>