<div class="tiny-space"></div>
 <div class="container-fluid">
  <div class="row">
   <?php if(have_posts()): while(have_posts()): the_post();?>
   <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
    <article role="article" id="post_<?php the_ID()?>">
        <header>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
            <h6>
                <span class="text-muted author"><?php _e('By', 'brainworks'); echo " "; the_author() ?>,</span>
                <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php get_option( 'date_format' ) ?></time>
            </h6>
        </header>
        <section>
            <?php the_post_thumbnail('large'); ?>
            <?php the_excerpt(); ?>
        </section>
        <hr>
        <footer>
            <p class="text-muted" style="margin-bottom: 20px;">
                <i class="fa fa-folder-open-o"></i>&nbsp; <?php _e('Category', 'brainworks'); ?>: <?php the_category(', ') ?><br/>
                <i class="fa fa-comment-o"></i>&nbsp; <?php _e('Comments', 'brainworks'); ?>: <?php comments_popup_link(__('None', 'brainworks'), '1', '%'); ?>
            </p>
        </footer>
    </article>
    </div>
<?php endwhile; ?>
  </div><!-- /.row -->
</div><!-- /.container -->

<?php if ( function_exists('brainworks_pagination') ) { brainworks_pagination(); } else if ( is_paged() ) { ?>
  <ul class="pagination">
    <li class="older"><?php next_posts_link('<i class="fa fa-arrow-left"></i> ' . __('Previous', 'brainworks')) ?></li>
    <li class="newer"><?php previous_posts_link(__('Next', 'brainworks') . ' <i class="fa fa-arrow-right"></i>') ?></li>
  </ul>
<?php } ?>

<?php else : ?>
	<?php get_template_part( 'loops/content', 'none' ); ?>
<?php endif; ?>