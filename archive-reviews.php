<?php get_header(); ?>

<div class="sp-xs-2 sp-md-3"></div>

<div class="row">
    <div class="col-xs-12 col-md-9">
        <h1 class="text-center"><?php post_type_archive_title(); ?></h1>

        <div class="sp-xs-2 sp-md-3"></div>

        <?php if (have_posts()) { ?>
            <div class="review-list">
                <?php while (have_posts()) {
                    the_post();
                    $id = get_the_ID();
                    $social = array();
                    $socials = array(
                        'facebook' => array(
                            'url' => get_post_meta($id, 'review-facebook', true),
                            'icon' => 'fa-facebook-f',
                        ),
                        'twitter' => array(
                            'url' => get_post_meta($id, 'review-instagram', true),
                            'icon' => 'fa-instagram',
                        ),
                    );

                    foreach ($socials as $item) {
                        if (!empty($item['url'])) {
                            $social['url'] = $item['url'];
                            $social['icon'] = $item['icon'];
                        }
                    }
                    ?>
                    <div id="post-<?php the_ID() ?>" <?php post_class('review-item'); ?>>
                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <div class="review-client">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'review-avatar')); ?>
                                    <?php if (count($social)) { ?>
                                        <a class="review-social" href="<?php echo esc_url($social['url']); ?>"
                                           target="_blank" rel="noopener noreferrer">
                                            <i class="fab <?php echo esc_attr($social['icon']); ?>"
                                               aria-hidden="true"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="review-author"><?php the_title() ?></div>
                            </div>
                            <div class="col-sm-10">
                                <div class="review-content"><?php the_content(); ?></div>
                                <div class="review-date text-right"><?php echo get_the_date('d.m.Y'); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php bw_pagination(); ?>
            </div>
        <?php } else {
            get_template_part('loops/content', 'none');
        } ?>
    </div>
    <div class="col-xs-12 col-md-3"><?php get_sidebar(); ?></div>
</div>

<?php get_footer(); ?>
