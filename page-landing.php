<?php
/**
*Template Name: Landing
**/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
    
	<title><?php wp_title(' | ', true, 'right'); bloginfo('name'); ?></title>
	<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/favicon.ico" type="image/x-icon" />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body <?php body_class(); ?>>

<?php get_template_part('loops/content', 'page'); ?>

<?php wp_footer(); ?>
</body>
</html>