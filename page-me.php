<?php
	/**
	 * Template Name: Profile page
	 */
	$user = UserController::get_current();
	if (!$user)
	{
		return wp_redirect("/profile-settings");
	}
	get_header();
?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-content text-center">
						<div class="avatar-container">
							<?php $image = UserController::get_image($user->id); $placeholder = "https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png"; ?>
							<img src="<?php echo $image ? $image : $placeholder; ?>" width="100%" height="auto" class="profile-image" />
							<div class="avatar-mask modal-trigger" data-modal="#update-avatar-modal">
								<div class="touchable-opacity touchable-opacity--trasnform-centered">
									<i class="fa fa-cogs"></i>
								</div>
							</div>
						</div>
						<br/> 
						<div>
							<a href="/profile-settings" class="button-alt">
								Настройки
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<h2><?php echo $user->name; ?></h2>
					</div>
					<div class="card-content">
						<div class="user-info">
							<div class="user-info-element">
								<div class="user-info-element-icon-container"><i class="fal fa-venus-mars"></i></div>
								<p class="labeled medium-size">
									<label>Пол:</label>
									<?php echo $user->sex; ?>
								</p>
							</div>
							<div class="user-info-element">
								<p class="labeled medium-size">
									<label>Город:</label>
									<?php echo $user->address; ?>
								</p>
							</div>
							<div class="user-info-element">
								<div class="user-info-element-icon-container"><i class="fal fa-address-card"></i></div>
								<p class="labeled medium-size">
									<label>Возраст:</label>
									<?php echo $user->get_age(); ?>
								</p>
							</div>
							<div class="user-info-element">
								<div class="user-info-element-icon-container"><i class="fal fa-trophy"></i></div>
								<p class="labeled medium-size">
									<label>Репутация:</label>
									<?php echo $user->reputation; ?>
								</p>
							</div>
							<div class="user-info-element">
								<div class="user-info-element-icon-container"><i class="fal fa-heart"></i></div>
								<p class="labeled medium-size">
									<label>Карма:</label>
									<?php echo $user->likes; ?>
								</p>
							</div>
						</div>
						<div>
							<h4 class="bordered-header">
								<i class="fal fa-align-left"></i>
								&nbsp;
								Обо мне
							</h4>
							<div>
								<?php echo esc_html($user->about) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-window" id="update-avatar-modal">
		<div class="modal-background"></div>
		<div class="modal-content">
			<div class="card text-center">
				<div class="card-header">
					<h3>Загрузка картинки пользователя</h3>
				</div>
				<div class="card-content">
					<form action="/wp-json/brainworks/user/avatar" method="POST" enctype="multipart/form-data" class="upload-image">
						<?php wp_nonce_field( 'user_file_upload', 'fileup_nonce' ); ?>
						<input type="hidden" name="user_id" value="<?php echo UserController::get_current_id(); ?>">
						<input type="hidden" name="user_pass" value="<?php echo UserController::get_current()->password; ?>">
						<div>
							<img class="preview" width="200px" height="auto">
						</div>
						<label for="upload-image" class="button-alt trigger">
							Загрузить картинку
						</label>
						<input type="file" id="upload-image" name="image" class="input" style="display: none;">
						<div class="sp-md-2"></div>
						<div class="text-right">
							<button class="button-link">
								Сохранить
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div> 

<?php get_footer(); ?>