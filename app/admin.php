<?php
	@session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/db.php'; // подключаемся к базе данных
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/json.php'; // работа с json для вывода сообщений через js
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/utils.php'; // вспомогательные функции для работы скриптов
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/user.php'; // вспомогательные функции для с авторизированным пользователем

	$data = $_POST; // Тут у нас будут храниться все значения с полей для обработки.
	$database = connect(); // call datbase

?>