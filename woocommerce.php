<?php get_header(); ?>

<div class="row">
    <?php if (!is_single()) : ?>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <?php get_sidebar(); ?>
        </div>
    <?php endif; ?>
    <div class="col-xs-12 <?php echo !is_single() ? 'col-sm-12 col-md-9 col-lg-9 col-xl-9' : ''; ?>">
        <?php woocommerce_content(); ?>
    </div>
</div><!-- /.row -->

<?php get_footer(); ?>
