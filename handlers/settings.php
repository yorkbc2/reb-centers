<?php 
	require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
	if (empty($_POST)) return wp_redirect("/profile-settings");
	$user = UserController::get_current();
	if (!function_exists("prepare_sex"))
	{
		function prepare_sex($symbol="0") {
			switch ($symbol)
			{
				case "W":
					return "Женщина";
				case "M":
					return "Мужчина";
				case "U":
					return "Инопланетянин";
				default:
					return "Не выбран";
			}
		}
	}

	$able_fields = array(
		"user_meta" => array(
			"_about"   => array("_about", FILTER_SANITIZE_STRING),
			"_sex"     => array("_sex", FILTER_SANITIZE_STRING, "prepare_sex"),
			"_address" => array("_address", FILTER_SANITIZE_STRING),
			"_problem" => array("_problem", FILTER_SANITIZE_STRING),
			"_date_born" => array("_date_born", FILTER_SANITIZE_STRING)
		)
	);


	foreach ($able_fields as $group_name => $group)
	{
		foreach ($group as $key => $item)
		{
			$value = null;
			if (isset($_POST[$key]))
			{
				$value = filter_var($_POST[$key], $item[1]);
				if (isset($item[2])) 
				{
					$value = call_user_func($item[2], $value);
				} 
			}
			if (!empty($value))
			{
				if ($group_name === "user_meta") {
					update_user_meta($user->id, $item[0], $value);
				}
			}
		}
	}

	UserController::calculate_reputation();

	return wp_redirect("/me");

