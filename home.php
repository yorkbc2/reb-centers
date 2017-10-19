<?php get_header(); ?>

<div class="tiny-space"></div>
<h1 class="page-name"><?php single_post_title(); ?></h1>   
<div class="tiny-space"></div>

<?php get_template_part('loops/content-2', get_post_format()); ?>

<?php get_footer(); ?>


