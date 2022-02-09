<?php

	@session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/db.php'; // подключаемся к базе данных
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/json.php'; // работа с json для вывода сообщений через js
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/utils.php'; // вспомогательные функции для работы скриптов
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/user.php'; // вспомогательные функции для с авторизированным пользователем

	$data = $_GET; // Тут у нас будут храниться все значения с полей для обработки.
	$database = connect(); // call datbase

	// Обработка запроса регистрации
	if ($data['method'] == 'solved') {
		$count = selectOne($database, 'SELECT COUNT(*) FROM problems WHERE state = "Решена"');
		exit(toJson(['success' => true, 'count' => array_shift($count)]));
	}

	if ($data['method'] == 'problems_requests') {
		// Проверяем авторизирован ли пользователь
		if (isAuth()) {
			// Выборка из таблицы
			$select = selectAll($database, 'SELECT * FROM problems WHERE user_id = "'.$_SESSION['user']['id'].'"');

			// Вывод данных и проверки
			if ($select == null) {
				exit(toJson(['error' => true, 'table' => null]));
			}

			if (@count($select) == 0) {
				exit(toJson(['error' => true, 'table' => null]));
			}

			foreach ($select as $key => $value) {
				$select[$key]['category_id'] = selectOne($database, 'SELECT * FROM category WHERE id = "'.$value['category_id'].'"')['name'];
			}

			exit(toJson(['success' => true, 'table' => $select]));
		}
	}

?>