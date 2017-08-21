<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
    
	<title><?php wp_title(' | ', true, 'right'); bloginfo('name'); ?></title>
	<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/img/favicon.ico" type="image/x-icon" />

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">
<div class="wrapper">
<?php /*
<div class="pre-header">
	<div class="inner-wrapper">
		<div class="container-fluid">
		    <div class="row">
		        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
	<nav class="second-menu">
    <?php
        wp_nav_menu( array(
            'theme_location'  => 'second-menu',
	        'menu'            => '',
	        'container'       => false,
	        'menu_class'      => 'menu-container',
	        'echo'            => true,
	        'fallback_cb'     => 'wp_page_menu',
	        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	        'depth'           => 2
        ) );
    ?>
    </nav>		    	
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
                    Some info here
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
		            Some info here
		        </div>
		    </div>
		</div>
	</div>
</div>
*/ ?>
<header class="page-header">
   <div class="inner-wrapper">
		<div class="container-fluid">
		    <div class="row">
		        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
    
		        </div>
		        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php get_search_form(); ?>
		        </div>
		    </div>
		</div>
</div>
</header>
    <nav class="main-nav container">
    <?php
        wp_nav_menu( array(
            'theme_location'  => 'main-nav',
	        'menu'            => '',
	        'container'       => false,
	        'menu_class'      => 'menu-container',
	        'echo'            => true,
	        'fallback_cb'     => 'wp_page_menu',
	        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	        'depth'           => 2
        ) );
    ?>
    </nav>

<div class="page-wrapper">

<?php if(has_custom_logo()) {
  the_custom_logo();
} else { ?>
  <a class="logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
    <img class="logo-img" src="<?php echo esc_url( get_template_directory_uri() ); ?>/img/logo.png" alt="logo">
  </a>
<?php } ?>

<h1><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h1>
<h3><?php bloginfo( 'description' ); ?></h3>
<h3><?php bloginfo('admin_email'); ?></h3>

