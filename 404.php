<?php get_header(); ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
          <h1><?php _e('Error', 'brainworks'); ?> 404</h1>
          <p><?php _e('The page you were looking for does not exist.', 'brainworks'); ?></p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><button class="button-medium"><?php _e('Back to the homepage', 'brainworks'); ?></button></a>
        <h2><?php _e('Or use search', 'brainworks'); ?></h2>
        <div class="col-sm-4"><?php get_search_form(); ?></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
       <?php get_sidebar(); ?>
    </div>
  </div><!-- /.row -->
</div><!-- /.container -->

<?php get_footer(); ?>