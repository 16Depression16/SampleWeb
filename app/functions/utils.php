<?php

	// Для проверки текстовых значений "true", "false"
	function isTrue ($value = '') {
		$bool = filter_var($value, FILTER_VALIDATE_BOOLEAN);
		return $bool;
	}

?>