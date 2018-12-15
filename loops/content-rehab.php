<?php 
    global $posts;
    $p_len = !empty($posts) ? sizeof($posts) : 0;
    $c = 0;
?>
<div class="container-fluid">
<?php if(have_posts() || (!empty($posts) && $len > 0)):
    global $prefix;
    global $wp_query;
    if ($p_len > 0) {
        setup_postdata($posts[$c]);
    }
    $i = 0;
    $c++;
    $len = 1 * wp_count_posts("rehab")->publish; 
    if (!$prefix)
        $prefix = "bw-reb-"; ?>
    <?php while (have_posts()): the_post(); global $post;
        if ($i % 4 === 0) echo '<div class="row">';
        ?>

        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
            <div class="reb-item">
                <div class="reb-item-header">
                    <img src="<?php the_post_thumbnail_url("medium"); ?>" title="<?php the_title(); ?>">
                </div>
                <div class="reb-item-content">
                    <p class="reb-item-address">
                        <?php $address = reb_combine_address(get_the_ID(), $prefix); ?>
                        <a href="<?php echo $address['link']; ?>">
                            <i class="fa fa-map-marker-alt"></i> <?php echo $address["address"]; ?>
                        </a>
                    </p>
                    <h3 class="reb-item-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <div>
                    <rating params="count: <?php echo get_rating($post->ID, get_post_type() . "_review"); ?>"></rating>
                    </div>
                </div>
                <div class="reb-item-footer">
                    <a href="<?php the_permalink(); ?>">
                        <?php _e("Узнать больше", "brainworks"); ?>
                    </a>
                </div>
            </div>
            <div class="sp-md-2"></div>
        </div>

    <?php 
    $i++;
    if ($i % 4 === 0 && $i != 0) {
        echo "</div>";
    }
    endwhile; ?>

<?php endif; ?>
</div>
<?php if (1 * $wp_query->found_posts / get_query_var("posts_per_page") > 1): ?>
<div>
    <?php echo archive_pagination(1 * $wp_query->found_posts, get_query_var("posts_per_page"), get_query_var("paged"), get_post_type()); ?>
</div>
<?php endif; ?>
</div>