<?php
/*
The Single Posts Loop
=====================
*/
?> 

<?php if(have_posts()): while(have_posts()): the_post(); ?>
    <article role="article" id="post_<?php the_ID()?>" <?php post_class()?>>
        <header>
            <h2><?php the_title()?></h2>
            <h5>
                <span class="text-muted author"><?php _e('By', 'brainworks'); echo " "; the_author() ?></span>
                <time  class="text-muted" datetime="<?php the_time('d-m-Y')?>"><?php get_option( 'date_format' ) ?></time>
            </h5>
            <p class="text-muted" style="margin-bottom: 30px;">
                <i class="fa fa-folder-open-o"></i>&nbsp; <?php _e('Filed under', 'brainworks'); ?>: <?php the_category(', ') ?><br/>
                <i class="fa fa-comment-o"></i>&nbsp; <?php _e('Comments', 'brainworks'); ?>: <?php comments_popup_link(__('None', 'brainworks'), '1', '%'); ?>
            </p>
        </header>
        <section>
            <?php the_post_thumbnail('full'); ?>
            <?php the_content()?>
            <?php wp_link_pages(); ?>
        </section>
    </article>
<?php comments_template('/loops/comments.php'); ?>
<?php endwhile; ?>

<?php else : ?>
	<?php get_template_part( 'loops/content', 'none' ); ?>
<?php endif; ?>

