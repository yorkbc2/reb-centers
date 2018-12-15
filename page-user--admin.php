<?php 
    get_header();
?>

<div class="container-fluid">
    <?php if ($user): ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-content">
                    <img src="<?php echo UserController::get_image($user_id); ?>" />
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>
                        <?php echo $user->name; ?>  
                    </h2>
                </div>
                <div class="card-content">
                    <div class="user-info">
                        <div class="user-info-element">
                            <div class="user-info-element-icon-container"><i class="fal fa-envelope"></i></div>
                            <p class="labeled medium-size">
                                <label>Email:</label>
                                <a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
                            </p>
                        </div>
                        <!-- <div class="user-info-element">
                            <div class="user-info-element-icon-container"><i class="fal fa-heart"></i></div>
                            <p class="labeled medium-size">
                                <label>Карма:</label>
                                <?php echo $user->likes; ?>
                            </p>
                        </div> -->
                    </div>
                    <div class="sp-md-2"></div>
                    <div class="text-center">
                        <button class="button-medium">
                            Написать сообщение
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-content">
                    <p>К сожалению, такого пользователя нету...</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>