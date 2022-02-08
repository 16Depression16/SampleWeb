<?php
	
	function isAuth () {
		return $_SESSION['user'] != null;
	}

	function isAdmin () {
		return $_SESSION['user'] != null && $_SESSION['user']['isAdmin'] == 'Да';
	}

?>