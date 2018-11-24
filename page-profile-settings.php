<?php 
	/**
	 * Template Name: Profile Settings
	 */
	get_header();
	if (!UserController::check()) return wp_redirect("/auth");
	$user = UserController::get_current();
	$sex_variations = array(
		"0" => "Не выбран",
		"M" => "Мужчина",
		"W" => "Женщина",
		"U" => "Инопланетянин"
	);

	$problem_variations = array(
		"Зависимость",
		"Созависимость",
		"Наблюдатель"
	);	
?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-sm-12">
				<div class="card">
					<div class="card-header">
						<h2>Настройки профиля</h2>
					</div>
					<div class="card-content">
						<form action="<?php echo get_template_directory_uri(); ?>/handlers/settings.php" method="POST" class="default-form">
							<div>
								<p class="labeled">
									<label for="name">Имя:</label>
									<input type="text" id="name" placeholder="Имя" readonly disabled value="<?php echo $user->name; ?>">
								</p>
							</div>
							<div>
								<p class="labeled">
									<label for="address">Адрес:</label>
									<input type="text" name="_address" id="address" placeholder="Адрес" value="<?php echo $user->address; ?>">
								</p>
							</div>
							<div>
								<p class="labeled">
									<label for="sex">Пол:</label>
									<select name="_sex" id="sex">
										<?php foreach ($sex_variations as $key => $genre): ?>
											<option value="<?php echo $key; ?>"
												<?php if (!$user->sex) echo "selected"; ?>
												<?php if ($user->sex === $genre) echo "selected"; ?>
												>
												<?php echo $genre; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
							</div>
							<div>
								<p class="labeled">
									<label for="problem">Проблема:</label>
									<select name="_problem" id="problem">
										<?php foreach ($problem_variations as $problem): ?>
											<option value="<?php echo $problem; ?>"
												<?php if (!$user->problem) echo "selected"; ?>
												<?php if ($user->problem === $problem) echo "selected"; ?>
												>
												<?php echo $problem; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</p>
							</div>
							<div>
								<p class="labeled">
									<label for="date_born">Дата рождения:</label>
									<input type="date" name="_date_born" id="date_born" value="<?php echo date("Y-m-d", strtotime($user->date_born)); ?>">
								</p>
							</div>
							<div>
								<p class="labeled">
									<label for="_about">Обо мне:</label>
									<textarea name="_about" id="_about"><?php echo $user->about; ?></textarea>
								</p>
							</div>
							<div>
								<button type="submit" class="button-alt">Принять</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>