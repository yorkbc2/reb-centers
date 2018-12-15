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
                    <div>
                        <br />
                        <button class="button-medium">
                            Написать сообщение
                        </button>
                    </div>
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Отзывы пользователя</h2>
                </div>
                <div class="card-content">
                    <div data-bind="foreach: reviews" class="card-content" id="reviews_list" 
                        data-id="0" 
                        data-user="<?php echo $user->id; ?>"
                        data-type="rehab_review">
                        <div class="r-review-item">
                            <div class="review-thumbnail-container">
                                <img data-bind="attr: {src: user_image}" width="100px" />
                            </div>
                            <div class="review-content-container">
                                <div class="review-item-header">
                                    <span data-bind="text: user_name"></span>
                                    <small class="review-item-date" data-bind="text: post_date"></small>
                                </div>
                                <rating params="count: rating()"></rating>
                                <div class="review-item-content" data-bind="text: post_content"></div>
                                <div class="review-item-footer">
                                    <div style="display: inline-block;">
                                        <span class="clickable">	
                                            <i class="fa fa-thumbs-up"></i>
                                            &nbsp;
                                            <span data-bind="text: likes"></span>
                                        </span>
                                        <font color="#ccc">|</font>
                                        <span class="clickable">	
                                            <i class="fa fa-thumbs-down"></i>
                                            &nbsp;
                                            <span data-bind="text: dislikes"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
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