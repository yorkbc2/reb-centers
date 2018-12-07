<div class="container-fluid">
<?php if(have_posts()):
    global $prefix;
    $i = 0;
    $col_per_row = 4;
    $col = floor(12 / $col_per_row);
    $col_class = sprintf("col-xs-12 col-sm-6 col-md-4 col-lg-%1$01d", $col);
    $len = 1 * wp_count_posts("rehab")->publish; 
    if (!$prefix)
        $prefix = "bw-reb-"; ?>
    <?php while (have_posts()): the_post(); global $post;
        if ($i === 0) echo '<div class="row">';
        ?>

        <div class="<?php echo $col_class; ?>">
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
                    <rating params="count: <?php echo get_rating($post->ID, "rehab_review"); ?>"></rating>
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
    if ($i === $col_per_row || ($len < $col_per_row && $i >= $len)) {
        $i = 0;
        echo "</div>";
    }
    endwhile; ?>
<?php endif; ?>
</div>
</div>