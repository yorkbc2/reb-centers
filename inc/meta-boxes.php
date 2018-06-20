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
    <p><b><?php echo esc_html('Show Post On Front'); ?></b></p>
    <label for="on-front">
        <input type="checkbox" name="on-front" id="on-front" value="yes" <?php checked($on_front, 'yes'); ?>>
        <?php echo esc_html('Enable/Disable'); ?>
    </label>
<?php }

add_action('save_post', 'bw_save_addition');

function bw_save_addition($post_id)
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
