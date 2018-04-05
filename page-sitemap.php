<?php
/**
 * Template Name: Sitemap Page
 * Template Post Type: page
 **/
?>

<?php get_header(); ?>

<div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>

<div class="row">
    <div class="col-xs-12 col-md-12">
        <?php if (!is_front_page() && function_exists('kama_breadcrumbs')) kama_breadcrumbs(' » '); ?>

        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <article id="post_<?php the_ID() ?>" <?php post_class() ?>>
                <h1 class="page-name"><?php the_title(); ?></h1>
                <?php the_content() ?>
            </article>
        <?php endwhile; ?>

        <?php else : ?>
            <article id="post_<?php the_ID() ?>" <?php post_class() ?>>
                <h1 class="page-name"><?php the_title(); ?></h1>
                <?php echo do_shortcode('[bw-html-sitemap]'); ?>
            </article>
        <?php endif; ?>
    </div>
</div><!-- /.row -->

<?php get_footer(); ?>
