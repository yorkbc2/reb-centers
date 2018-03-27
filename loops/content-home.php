<?php
/**
 * The Home Page Loop
 * =============
 */
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

    <?php the_content() ?>
    <?php wp_link_pages(); ?>

<?php endwhile; else: ?>
    <?php get_template_part('loops/content', 'none'); ?>
<?php endif; ?>
