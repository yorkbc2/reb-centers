<?php get_header(); ?>

<div class="container-fluid page-404">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="sp-xs-3 sp-sm-3 sp-md-3 sp-lg-3 sp-xl-3"></div>
            <h1 class="text-center"><?php _e('Error', 'brainworks'); ?> 404</h1>
            <p class="text-center"><?php _e('The page you were looking for does not exist.', 'brainworks'); ?></p>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="sp-xs-3 sp-sm-3 sp-md-4 sp-lg-4 sp-xl-3"></div>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <button class="button-medium center-block"><?php _e('Back to the homepage', 'brainworks'); ?></button>
            </a>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4">
            <div class="sp-xs-5 sp-sm-5 sp-md-3 sp-lg-3 sp-xl-3"></div>
            <h4 class="text-center"><?php _e('Or use search', 'brainworks'); ?></h4>
            <?php get_search_form(); ?>
        </div>
    </div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer(); ?>
