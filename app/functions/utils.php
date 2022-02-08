<?php

	// Для проверки текстовых значений "true", "false"
	function isTrue ($value = '') {
		$bool = filter_var($value, FILTER_VALIDATE_BOOLEAN);
		return $bool;
	}

	function isCorrectFormatFile ($file) {
        if ($file['type']) {
            if (in_array($file['type'], ['image/png', 'image/jpeg', 'image/jpg']))
                return true;
            else
                return false;
        } else {
            return false;
        }
    }

?>