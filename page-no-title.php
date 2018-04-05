<?php
/**
 * Template Name: Page Without Title
 **/

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

        if (function_exists('kama_breadcrumbs')) {
            kama_breadcrumbs(' » ');
        }

        the_content();
        wp_link_pages();

    endwhile;
else:
    get_template_part('loops/content', 'none');
endif;

get_footer();
