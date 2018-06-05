<?php
/**
 * The Search Loop
 * ===============
 */
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post_<?php the_ID() ?>" <?php post_class() ?>>
        <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
        <header>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h4>
        </header>
        <div class="sp-xs-1 sp-sm-1 sp-md-1 sp-lg-1 sp-xl-1"></div>
        <p><?php the_excerpt(); ?></p>
        <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
    </article>
<?php endwhile; else: ?>
    <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
    <div class="alert alert-warning">
        <i class="fa fa-exclamation-triangle"></i> <?php _e('Sorry, your search yielded no results.', 'brainworks'); ?>
    </div>
<?php endif; ?>
