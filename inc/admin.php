<?php

/**
 * Footer left text
 */
function bw_admin_footer_text()
{
    $developed_by = sprintf(
        '%s <strong><a href="%s" target="_blank">%s</a></strong>',
        __('Developed by:', 'brainworks'),
        __('https://brainworks.com.ua', 'brainworks'),
        __('brainworks.com.ua', 'brainworks')
    );
    $php_version  = sprintf(
        '%s: <b style="color: #080;">%s</b>',
        __('Running PHP version', 'brainworks'),
        phpversion()
    );
    $queries      = sprintf(
        __('%d request pear %s sec.', 'brainworks'),
        get_num_queries(),
        timer_stop(0, 3)
    );
    $memory       = sprintf(
        __('Spent %d Mb of memory (including unused pages %d Mb)', 'brainworks'),
        round(memory_get_usage() / 1024 / 1024, 2),
        round(memory_get_usage(true) / 1024 / 1024, 2)
    );

    $output = sprintf(
        '<span id="footer-thankyou">%s</span><br>%s / %s<br>%s',
        $developed_by,
        $php_version,
        $queries,
        $memory
    );

    echo $output;
}

//add_filter('admin_footer_text', 'bw_admin_footer_text');

/**
 * Footer right text
 */
function bw_update_footer()
{
    $support = sprintf(
        '%s <a href="mailto:%s" target="_blank">%s</a>',
        __('Support:', 'brainworks'),
        __('web@brainworks.com.ua', 'brainworks'),
        __('web@brainworks.com.ua', 'brainworks')
    );

    $tel = sprintf(
        '%s <a href="tel:%s" target="_blank">%s</a>',
        __('Tel:', 'brainworks'),
        get_phone_number(__('+38 (063) 20-37-137', 'brainworks')),
        __('+38 (063) 20-37-137', 'brainworks')
    );

    $output = sprintf('%s<br>%s<br>', $support, $tel);

    echo $output;

    core_update_footer();
}

add_filter('update_footer', 'bw_update_footer', 10);

/**
 * PHP version
 *
 * @param string $content Default text
 *
 * @return string
 */
function bw_php_version($content)
{
    $php_version = sprintf(
        '<br>%s: <b style="color: #080;">%s</b>',
        __('Running PHP version', 'brainworks'),
        phpversion()
    );

    return $content . $php_version;
}

//add_filter('update_right_now_text', 'bw_php_version');

if (!function_exists( 'bw_add_img_attributes' )) {
    /**
     * Добавление аттрибутов title и alt для картинок
     * @param  array $attr       Аттрибуты картинки
     * @param  WP_Post|array $attachment Наша картинка
     * @return array             Аттрибуты картинки
     */
    function bw_add_img_attributes ($attr=array(), $attachment) {
        $title = trim( strip_tags( $attachment->post_title ) );
        $alt   = trim( strip_tags( get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) ) );

        $attr['title'] = $title;
        $attr['alt'] = $alt;

        return $attr;
    }   
}

add_filter( 'wp_get_attachment_image_attributes', 'bw_add_img_attributes', 10, 3 );

/**
 * Admin Enqueue Script
 */
function bw_admin_enqueue_script() {
    wp_add_inline_script('postbox', '(function($){$(function(){var customFields=$("#postcustom-hide");if(customFields.length&&customFields.prop("checked")){setTimeout(function(){customFields.trigger("click.postboxes");},100);}});})(jQuery);');
}

add_action('admin_enqueue_scripts', 'bw_admin_enqueue_script');
