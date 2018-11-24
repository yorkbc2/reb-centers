<?php
	/**
	 * Template Name: Profile page
	 */
	get_header();
	$user = UserController::get_current();
?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="card">
					<div class="card-content text-center">
						<div>
							<img src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png" width="100%" height="auto" />
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

<?php get_footer(); ?>