<?php
/**
 * The Default Loop (used by index.php and category.php)
 * =====================================================
 *
 * If you require only post excerpts to be shown in index and category pages, then use the [---more---] line within blog posts.
 *
 * If you require different templates for different post types, then simply duplicate this template, save the copy as, e.g. "content-aside.php", and modify it the way you like it. (The function-call "get_post_format()" within index.php, category.php and single.php will redirect WordPress to use your custom content template.)
 *
 * Alternatively, notice that index.php, category.php and single.php have a post_class() function-call that inserts different classes for different post types into the section tag (e.g. <section id="" class="format-aside">). Therefore you can simply use e.g. .format-aside {your styles} in css/brainworks.css style the different formats in different ways.
 */
?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post_<?php the_ID() ?>">
        <header>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
            <div class="sp-xs-1 sp-sm-1 sp-md-1 sp-lg-1 sp-xl-1"></div>
            <?php /*
            <h5>
              <em>
                <span class="text-muted author"><?php _e('By', 'brainworks'); echo " "; the_author() ?>,</span>
                <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php echo get_option( 'date_format' ) ?></time>
              </em>
            </h5>
            */ ?>
        </header>
        <section>
            <?php the_post_thumbnail('full'); ?>
            <div class="sp-xs-1 sp-sm-1 sp-md-1 sp-lg-1 sp-xl-1"></div>
            <?php the_excerpt(__('&hellip; ' . __('Continue reading', 'brainworks') . ' <i class="glyphicon glyphicon-arrow-right"></i>', 'brainworks')); ?>
        </section>
        
        <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
        <hr>
        <div class="sp-xs-2 sp-sm-2 sp-md-2 sp-lg-2 sp-xl-2"></div>
        
        <?php /*
        <footer>
            <p class="text-muted" style="margin-bottom: 20px;">
                <i class="fa fa-folder-open-o"></i>&nbsp; <?php _e('Category', 'brainworks'); ?>: <?php the_category(', ') ?><br/>
                <i class="fa fa-comment-o"></i>&nbsp; <?php _e('Comments', 'brainworks'); ?>: <?php comments_popup_link(__('None', 'brainworks'), '1', '%'); ?>
            </p>
        </footer>
        */ ?>
    </article>
<?php endwhile; ?>

    <?php if (function_exists('bw_pagination')) {
        bw_pagination();
    } else if (is_paged()) { ?>
        <ul class="pagination">
            <li class="older"><?php next_posts_link('<i class="fa fa-arrow-left"></i> ' . __('Previous', 'brainworks')) ?></li>
            <li class="newer"><?php previous_posts_link(__('Next', 'brainworks') . ' <i class="fa fa-arrow-right"></i>') ?></li>
        </ul>
    <?php } ?>

<?php else : ?>
    <?php get_template_part('loops/content', 'none'); ?>
<?php endif; ?>
