<?php 
	require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

	UserController::logout();
	wp_redirect(home_url("/auth"));