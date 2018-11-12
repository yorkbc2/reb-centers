<?php

add_action('add_meta_boxes', 'bw_post_meta_box');

function bw_post_meta_box()
{
    add_meta_box(
        'post-meta-box', // id
        'Addition', // title
        'bw_post_addition_callback', // callback
        'post', // screen (post, page, link, attachment or custom_post_type)
        'normal', // context (normal, advanced, side)
        'high' // priority (low, default, high)
    );
}

function bw_post_addition_callback($post, $meta_info)
{
    $on_front = get_post_meta($post->ID, 'on-front', true);
    wp_nonce_field(basename(__FILE__), 'post_nonce');
    ?>
    <p class="meta-options">
        <label for="on-front"><b><?php echo esc_html('Enable/Disable'); ?></b></label>
        <br>
        <input type="checkbox" name="on-front" id="on-front" value="yes" <?php checked($on_front, 'yes'); ?>>
        <?php echo esc_html('Display post on Home page'); ?>
    </p>
<?php }

add_action('save_post', 'bw_save_post_addition');

function bw_save_post_addition($post_id)
{
    if (!isset($_POST['post_nonce']) || !wp_verify_nonce($_POST['post_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['on-front'])) {
        update_post_meta($post_id, 'on-front', 'yes');
    } else {
        update_post_meta($post_id, 'on-front', 'no');
    }

}

add_action('add_meta_boxes', 'bw_reviews_meta_box');

function bw_reviews_meta_box()
{
    add_meta_box(
        'reviews-meta-box', // id
        'Addition', // title
        'bw_reviews_addition_callback', // callback
        'reviews', // screen (post, page, link, attachment or custom_post_type)
        'normal', // context (normal, advanced, side)
        'high' // priority (low, default, high)
    );
}

function bw_reviews_addition_callback($post, $meta_info)
{
    $review = array(
        'display' => get_post_meta($post->ID, 'review-display', true),
        'facebook' => get_post_meta($post->ID, 'review-facebook', true),
        'instagram' => get_post_meta($post->ID, 'review-instagram', true),
    );
    wp_nonce_field(basename(__FILE__), 'reviews_nonce');
    ?>
    <p class="meta-options">
        <label for="review-display"><b><?php echo esc_html('Enable/Disable'); ?></b></label>
        <br>
        <input type="checkbox" name="review-display" id="review-display" value="1" <?php checked($review['display'],
            '1'); ?>>
        <?php echo esc_html('Display review on Home page'); ?>
    </p>
    <p class="meta-options">
        <label for="review-facebook"><b><?php echo esc_html('Facebook URL'); ?></b></label>
        <br>
        <input type="url" name="review-facebook" id="review-facebook" placeholder="https://www.facebook.com" size="30"
               value="<?php echo esc_attr($review['facebook']); ?>">
    </p>
    <p class="meta-options">
        <label for="review-instagram"><b><?php echo esc_html('Instagram URL'); ?></b></label>
        <br>
        <input type="url" name="review-instagram" id="review-instagram" placeholder="https://www.instagram.com"
               size="30" value="<?php echo esc_attr($review['instagram']); ?>">
    </p>
<?php }

add_action('save_post', 'bw_save_reviews_addition');

function bw_save_reviews_addition($post_id)
{
    if (!isset($_POST['reviews_nonce']) || !wp_verify_nonce($_POST['reviews_nonce'], basename(__FILE__))) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['review-display'])) {
        update_post_meta($post_id, 'review-display', '1');
    } else {
        update_post_meta($post_id, 'review-display', '0');
    }

    if (isset($_POST['review-facebook'])) {
        update_post_meta($post_id, 'review-facebook', sanitize_text_field($_POST['review-facebook']));
    } else {
        update_post_meta($post_id, 'review-facebook', '');
    }

    if (isset($_POST['review-instagram'])) {
        update_post_meta($post_id, 'review-instagram', sanitize_text_field($_POST['review-instagram']));
    } else {
        update_post_meta($post_id, 'review-instagram', '');
    }

}
