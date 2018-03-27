<?php
/**
 * The Page Loop
 * =============
 */
?>

<?php if ((!is_page_template(array('page-landing.php')) && is_front_page()) || (!is_page_template(array('page-landing.php')) && !is_front_page())) {

    if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » ');

} ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

    <?php if ((!is_page_template(array('page-landing.php')) && is_front_page()) || (!is_page_template(array('page-landing.php')) && !is_front_page())) : ?>
        <h1 class="page-name"><?php the_title() ?></h1>
    <?php endif; ?>

    <?php the_content() ?>
    <?php wp_link_pages(); ?>

<?php endwhile; else: ?>
    <?php get_template_part('loops/content', 'none'); ?>
<?php endif; ?>
