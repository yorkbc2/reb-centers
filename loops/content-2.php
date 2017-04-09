<?php if(have_posts()): while(have_posts()): the_post();?>
<div class="container-fluid">
  <div class="row">
    <article role="article" id="post_<?php the_ID()?>">
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <section>
            <?php the_post_thumbnail('large'); ?>
        </section>
      </div>
      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6">
        <header>
           <h2><a href="<?php the_permalink(); ?>"><?php the_title()?></a></h2>
            <?php the_excerpt(); ?>
            <h5>
              <em>
                <span class="text-muted author"><?php _e('By', 'brainworks'); echo " "; the_author() ?>,</span>
                <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php get_option( 'date_format' ) ?></time>
              </em>
            </h5>
        </header>
        <footer>
            <p class="text-muted" style="margin-bottom: 20px;">
                <i class="fa fa-folder-open-o"></i>&nbsp; <?php _e('Category', 'brainworks'); ?>: <?php the_category(', ') ?><br/>
                <i class="fa fa-comment-o"></i>&nbsp; <?php _e('Comments', 'brainworks'); ?>: <?php comments_popup_link(__('None', 'brainworks'), '1', '%'); ?>
            </p>
        </footer>
            <a class="button-small" href="<?php echo get_permalink(); ?>"><?php _e( 'Continue reading', 'brainworks' ) ?> <i class="glyphicon glyphicon-arrow-right"></i></a>
      </div>
    </article>
  </div>
</div>
   <br>
    <hr>
    <br>
<?php endwhile; ?>

<?php if ( function_exists('brainworks_pagination') ) { brainworks_pagination(); } else if ( is_paged() ) { ?>
  <ul class="pagination">
    <li class="older"><?php next_posts_link('<i class="fa fa-arrow-left"></i> ' . __('Previous', 'brainworks')) ?></li>
    <li class="newer"><?php previous_posts_link(__('Next', 'brainworks') . ' <i class="fa fa-arrow-right"></i>') ?></li>
  </ul>
<?php } ?>

<?php else : ?>
	<?php get_template_part( 'loops/content', 'none' ); ?>
<?php endif; ?>
