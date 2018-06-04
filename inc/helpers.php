<?php

/**
 * Clear phone number for tag <a href="tel:"></a>
 *
 * @param $phone_number
 *
 * @return mixed
 */
function get_phone_number($phone_number)
{
    return str_replace(array('-', '(', ')', ' '), '', $phone_number);
}

/**
 * @see get_phone_number()
 *
 * @param $phone_number
 *
 * @return void
 */
function the_phone_number($phone_number)
{
    echo get_phone_number($phone_number);
}

/**
 * @return bool|string
 */
function get_scroll_top()
{
    if (get_theme_mod('bw_scroll_top_display', true)) {

        $shape = '';
        switch (get_theme_mod('bw_scroll_top_shape', 'circle')) {
            case 'circle':
                $shape = 'is-circle';
                break;
            case 'rounded':
                $shape = 'is-rounded';
                break;
        }

        $position = '';
        switch (get_theme_mod('bw_scroll_top_position', 'right')) {
            case 'left':
                $position = 'is-left';
                break;
            case 'right':
                $position = 'is-right';
                break;
        }

        $output = sprintf(
            '<a href="#top" class="scroll-top js-scroll-top %s %s"><i class="scroll-top--arrow"></i></a>',
            $shape,
            $position
        );

        return $output;
    }

    return false;
}

/**
 * @see get_scroll_top()
 * @return void
 */
function scroll_top()
{
    echo get_scroll_top();
}

/**
 * @param string $placed
 *
 * @return string
 */
function get_analytics_tracking_code($placed = 'body')
{
    $tracking_code                = array();
    $tracking_code['google']      = get_theme_mod('bw_analytics_google');
    $tracking_code['yandex']      = get_theme_mod('bw_analytics_yandex');
    $tracking_code['chat']        = get_theme_mod('bw_chat');
    $tracking_code['remarketing'] = get_theme_mod('bw_remarketing');
    $tracking_code['custom']      = get_theme_mod('bw_analytics_custom');

    $tracking_placed                = array();
    $tracking_placed['google']      = get_theme_mod('bw_analytics_google_placed', 'body');
    $tracking_placed['yandex']      = get_theme_mod('bw_analytics_yandex_placed', 'body');
    $tracking_placed['chat']        = get_theme_mod('bw_chat_placed', 'body');
    $tracking_placed['remarketing'] = get_theme_mod('bw_remarketing_placed', 'body');
    $tracking_placed['custom']      = get_theme_mod('bw_analytics_custom_placed', 'body');

    $output = '';

    foreach ($tracking_code as $key => $script) {
        if ( ! empty($tracking_placed[$key]) && ! empty($script)) {
            if ($tracking_placed[$key] === $placed) {
                $output .= $script . PHP_EOL;
            }
        }
    };

    if ( ! empty($output)) {
        //return sprintf( '<script type="text/javascript">%s</script>', $output );
        return $output;
    }

    return '';

}

/**
 * @see get_analytics_tracking_code()
 *
 * @param string $placed
 *
 * @return void
 */
function analytics_tracking_code($placed = 'body')
{
    echo get_analytics_tracking_code($placed);
}

if ( ! function_exists('get_lang_class')) {
    /**
     * @param string $class
     *
     * @return string
     */
    function get_lang_class($class)
    {
        return function_exists('pll_current_language') ? $class . '-' . pll_current_language('slug') : $class;
    }
}

if ( ! function_exists('the_lang_class')) {
    /**
     * @see get_lang_class()
     *
     * @param string $class
     *
     * @return void
     */
    function the_lang_class($class)
    {
        echo get_lang_class($class);
    }
}

if ( ! function_exists('has_social')) {
    /**
     * @see get_social()
     * @return bool
     */
    function has_social()
    {
        return (bool)get_social();
    }
}

if ( ! function_exists('get_social')) {
    /**
     * @return array
     */
    function get_social()
    {
        $_socials = [
            'vk'          => [
                'url'  => get_theme_mod('bw_social_vk'),
                'text' => 'Vk',
                'icon' => 'fa-vk',
            ],
            'twitter'     => [
                'url'  => get_theme_mod('bw_social_twitter'),
                'text' => 'Twitter',
                'icon' => 'fa-twitter',
            ],
            'facebook'    => [
                'url'  => get_theme_mod('bw_social_facebook'),
                'text' => 'Facebook',
                'icon' => 'fa-facebook',
            ],
            'linkedin'    => [
                'url'  => get_theme_mod('bw_social_linkedin'),
                'text' => 'Linkedin',
                'icon' => 'fa-linkedin',
            ],
            'instagram'   => [
                'url'  => get_theme_mod('bw_social_instagram'),
                'text' => 'Instagram',
                'icon' => 'fa-instagram',
            ],
            'google-plus' => [
                'url'  => get_theme_mod('bw_social_google_plus'),
                'text' => 'Google Plus',
                'icon' => 'fa-google-plus',
            ],
            'youtube'     => [
                'url'  => get_theme_mod('bw_social_youtube'),
                'text' => 'YouTube',
                'icon' => 'fa-youtube-play',
            ],
        ];

        $socials = array_filter($_socials, function ($value) {
            return $value['url'] !== '#' && ! empty($value['url']) && filter_var($value['url'], FILTER_VALIDATE_URL);
        });

        return $socials;
    }
}


if ( ! function_exists('has_phones')) {
    /**
     * @see get_phones()
     * @return bool
     */
    function has_phones()
    {
        return (bool)get_phones();
    }
}

if ( ! function_exists('get_phones')) {
    /**
     * @return array
     */
    function get_phones()
    {
        $_phones = [
            get_theme_mod('bw_phone1'),
            get_theme_mod('bw_phone2'),
            get_theme_mod('bw_phone3'),
            get_theme_mod('bw_phone4'),
        ];

        $phones = array_filter($_phones, function ($value) {
            return ! empty($value);
        });

        return $phones;
    }
}

if ( ! function_exists('wp-body')) {
    /**
     * Fire the wp_body action.
     */
    function wp_body()
    {
        /**
         * Prints scripts or data in the body tag on the front end.
         */
        do_action('wp_body');
    }
}

if ( ! function_exists('get_svg_sprite')) {
    /**
     * @return mixed|string
     */
    function get_svg_sprite()
    {
        $svg_file = get_template_directory() . '/assets/img/svg-sprite.svg';
        $svg_code = '';

        if (file_exists($svg_file) && filesize($svg_file) > 0) {
            $svg_code = file_get_contents($svg_file);
        }

        return $svg_code;
    }
}

if ( ! function_exists('svg_sprite')) {
    /**
     * Display svg sprite
     *
     * @see get_svg_sprite()
     * @return void
     */
    function svg_sprite()
    {
        echo get_svg_sprite();
    }
}

if ( ! function_exists('get_default_logo_link')) {
    /**
     * Display site logo
     *
     * @return void
     */
    function get_default_logo_link()
    {
        $desc = sprintf('<span class="logo-desc screen-reader-text">%s</span>', get_bloginfo('description'));

        if (has_custom_logo()) {

            the_custom_logo();
            echo $desc;

        } else {

            $file = get_template_directory_uri() . '/assets/img/logo.png';

            $img = sprintf('<img class="logo-img" src="%s" alt="%s">', esc_url($file), get_bloginfo('name'));

            $link = sprintf('<a class="logo-link" href="%s">%s</a>', esc_url(home_url('/')), $img);

            $span = sprintf('<span class="logo-link">%s</span>', $img);

            $html = is_front_page() ? $span : $link;

            $html .= $desc;

            echo $html;
        }
    }
}