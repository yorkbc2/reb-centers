<?php
/**
 * Template Name: Page Without Breadcrumbs
 **/
?>

<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

    <h1 class="page-name"><?php the_title() ?></h1>

    <?php the_content() ?>
    <?php wp_link_pages(); ?>

<?php endwhile;
else: ?>
    <?php get_template_part('loops/content', 'none'); ?>
<?php endif; ?>

<?php get_footer(); ?>
