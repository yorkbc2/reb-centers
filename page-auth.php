<?php 
	/**
	 * Template Name: Auth page
	 */
	if (UserController::check()) return wp_redirect("/me");
	get_header();
?>

	<h1 class="archive-header">
		<?php _e("Вход и регистрация на сайте", "brainworks"); ?>
	</h1>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="card">
					<div class="card-header">
						Логин
					</div>
					<div class="card-content">
						<form action="<?php echo get_template_directory_uri(); ?>/handlers/login.php" method="POST" class="default-form">
							<p class="labeled">
								<label for="login">Логин:</label>
								<input type="text" name="login" id="login" placeholder="Введите Ваш логин:" class="default-form-input">
							</p>
							<br/>
							<p class="labeled">
								<label for="login">Пароль:</label>
								<input type="password" name="password" id="password" placeholder="Введите Ваш пароль:" class="default-form-input">
							</p>
							<br>
							<div>
								<button class="button-medium" type="submit">Войти</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="card">
					<div class="card-header">
						Регистрация
					</div>
					<div class="card-content">
						<?php 
							if (isset($_GET["error_message"]) && isset($_GET["type"]) && $_GET["type"] === "register")
							{
								get_alert("register", $_GET["error_message"]);
							}
						?>
						<form action="<?php echo get_template_directory_uri(); ?>/handlers/register.php" method="POST" class="default-form">
							<p class="labeled">
								<label for="rlogin">Логин:</label>
								<input type="text" name="login" id="rlogin" placeholder="Введите Ваш логин:" class="default-form-input">
							</p>
							<br/>
							<p class="labeled">
								<label for="name">Имя и Фамилия:</label>
								<input type="text" name="name" id="name" placeholder="Введите Ваше Имя и Фамилию:" class="default-form-input">
							</p>
							<br/>
							<p class="labeled">
								<label for="born_date">Дата рождения:</label>
								<input type="date" name="born_date" id="born_date">
							</p>
							<br/>
							<p class="labeled">
								<label for="city">Город:</label>
								<input type="text" name="address" id="city" placeholder="Введите Ваше место проживания:" class="default-form-input">
							</p>
							<br/>
							<p class="labeled">
								<label for="login">Выберите Вашу проблему:</label>
								<select name="problem" id="problem">
									<option value="Зависимость">Зависимость</option>
									<option value="Созависимость">Созависимость</option>
									<option value="Наблюдатель">Наблюдатель</option>
								</select>
							</p>
							<br/>
							<p class="labeled">
								<label for="rpassword">Пароль:</label>
								<input type="password" name="password" id="rpassword" placeholder="Введите Ваш пароль:" class="default-form-input">
							</p>
							<br/>
							<p class="labeled">
								<label for="r_password">Повторите пароль:</label>
								<input type="password" name="r_password" id="r_password" placeholder="Повторите Ваш пароль:" class="default-form-input">
							</p>
							<br/>
							<p class="medium-size">
								Пожалуйста, подтвердите Ваше соглашение на <a href="#">Обработку Ваших данных</a> <input type="checkbox" name="accept" value="Y">	
							</p>
							<br>
							<div>
								<button class="button-medium" type="submit">Войти</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
	get_footer();
?>