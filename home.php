<?php get_header(); ?>

<div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
<h1 class="page-name"><?php single_post_title(); ?></h1>
<div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>

<?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>
<?php get_template_part('loops/content-2', get_post_format()); ?>

<?php get_footer(); ?>
