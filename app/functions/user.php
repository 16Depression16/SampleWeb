<?php
	
	// Проверка авторизирован ли пользователь
	function isAuth () {
		return $_SESSION['user'] != null;
	}

	// Проверка на админа
	function isAdmin () {
		return $_SESSION['user'] != null && $_SESSION['user']['isAdmin'] == 'Да';
	}

?>