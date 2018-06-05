<?php get_header(); ?>

<div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
            <h1><?php _e('Search Results for', 'brainworks'); ?> &ldquo;<?php the_search_query(); ?>&rdquo;</h1>
            <div class="sp-xs-1 sp-sm-1 sp-md-1 sp-lg-1 sp-xl-1"></div>
            <hr/>
            <?php get_template_part('loops/content', 'search'); ?>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php get_sidebar(); ?>
        </div>

    </div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer(); ?>
