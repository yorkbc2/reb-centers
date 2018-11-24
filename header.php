<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
    <link rel="shortcut icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.ico'); ?>"
          type="image/x-icon">
    <link rel="icon" href="<?php echo esc_url(get_template_directory_uri() . '/assets/img/favicon.ico'); ?>"
          type="image/x-icon">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">

<?php wp_body(); ?>

<div class="wrapper">
 
    <div class="pre-header">
        <div class="container">
            <div class="pre-header-container">
                <div class="pre-header-logo">
                    <?php echo get_default_logo_link(); ?>
                </div>
                <div class="pre-header-buttons">
                    <a href="#" class="search-trigger">
                        <i class="fa fa-search"></i>
                        <div class="search-form">
                            <form action="<?php echo esc_url(home_url()); ?>" method="get">    
                                <input type="search" name="s" placeholder="<?php _e("Поиск", "brainworks"); ?>">
                            </form>
                        </div>
                    </a>
                    <?php if (!UserController::check()): ?>
                    <a href="/auth">
                        <span>
                            <i class="fa fa-sign-in"></i>&nbsp;
                        <?php _e("Войти", 'brainworks'); ?>
                        </span>
                    </a>
                    <?php else: ?>
                    <a href="<?php echo get_template_directory_uri(); ?>/logout.php">
                        <span>
                            <i class="fa fa-sign-out"></i>&nbsp;
                        <?php _e("Выйти", 'brainworks'); ?>
                        </span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



    <?php if (has_nav_menu('main-nav')) { ?>
        <nav class="nav js-menu">
            <button type="button" tabindex="0" class="menu-item-close menu-close js-menu-close"></button>
            <?php wp_nav_menu(array(
                'theme_location' => 'main-nav',
                'container' => false,
                'menu_class' => 'menu-container',
                'menu_id' => '',
                'fallback_cb' => 'wp_page_menu',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 3
            )); ?>
        </nav>
    <?php } ?>

    <div class="container js-container">

        <div class="nav-mobile-header">
            <button class="hamburger js-hamburger" type="button" tabindex="0">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
            </button>
            <div class="logo"><?php get_default_logo_link(); ?></div>
        </div>