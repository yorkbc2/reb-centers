<?php 
	$error_messages = array(
		"register" => array(
			__("Все поля должны быть заполнены", "brainworks"),
			__("Все обязательные поля должны быть заполнены", "brainworks"),
			__("Пользователь с таким логином уже существует", "brainworks"),
			__("Вы должны принять правила регистрации", "brainworks"),
			__("Пароли должны совпадать", "brainworks"),
			__("Вы превысили максимальное кол-во символов: ", "brainworks") . HANDLER_MAXIMUM_LETTERS
		)
	);

	if (!function_exists('get_error')) {
		function get_error ($type, $code) {
			global $error_messages;
			if (isset($error_messages[$type])) 
			{
				if (isset($error_messages[$type][$code]))
				{
					return $error_messages[$type][$code];
				}
				return "";
			}
			return "";
		}
	}

	if (!function_exists('get_alert')) {
		function get_alert ($type, $code) {
			$error = get_error($type, $code);
			echo sprintf('<div class="alert-error">%s</div>', $error);
		}
	}