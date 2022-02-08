<?php

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/db.php'; // подключаемся к базе данных
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/json.php'; // работа с json для вывода сообщений через js
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/utils.php'; // вспомогательные функции для работы скриптов

	$data = $_GET; // Тут у нас будут храниться все значения с полей для обработки.
	$database = connect(); // call datbase

	// Обработка запроса регистрации
	if ($data['method'] == 'solved') {
		$count = selectOne($database, 'SELECT COUNT(*) FROM problems WHERE state = "Решена"');
		exit(toJson(['success' => true, 'count' => array_shift($count)]));
	}

?>