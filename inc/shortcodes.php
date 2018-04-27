<?php

if (!function_exists('bw_polylang_shortcode')) {
    /**
     * Add Shortcode Polylang
     *
     * @param $atts
     * @return array|null|string
     */
    function polylang_shortcode($atts)
    {
        // Attributes
        $atts = shortcode_atts(
            array(
                'dropdown'               => 0, // display as list and not as dropdown
                'echo'                   => 0, // echoes the list
                'hide_if_empty'          => 1, // hides languages with no posts ( or pages )
                'menu'                   => 0, // not for nav menu ( this argument is deprecated since v1.1.1 )
                'show_flags'             => 0, // don't show flags
                'show_names'             => 1, // show language names
                'display_names_as'       => 'name', // valid options are slug and name
                'force_home'             => 0, // tries to find a translation
                'hide_if_no_translation' => 0, // don't hide the link if there is no translation
                'hide_current'           => 0, // don't hide current language
                'post_id'                => null, // if not null, link to translations of post defined by post_id
                'raw'                    => 0, // set this to true to build your own custom language switcher
                'item_spacing'           => 'preserve', // 'preserve' or 'discard' whitespace between list items
            ),
            $atts
        );

        if (function_exists('pll_the_languages')) {
            $flags = pll_the_languages($atts);
            return $flags;
        }

        return '';

    }

    add_shortcode('polylang', 'bw_polylang_shortcode');
}

if (!function_exists('bw_social_shortcode')) {
    /**
     * Add Shortcode Socials
     *
     * @param $atts
     * @return string
     */
    function bw_social_shortcode($atts)
    {

        // Attributes
        $atts = shortcode_atts(
            array(),
            $atts
        );

        $output = '';

        if (has_social()) {
            $items = '';

            foreach (get_social() as $social) {
                $items .= sprintf(
                    '<li class="social-item">%s</li>',
                    sprintf(
                        '<a class="social-link" href="%s" target="_blank"><i class="fa %s" aria-hidden="true" aria-label="%s"></i></a>',
                        esc_attr(esc_url($social['url'])),
                        esc_attr($social['icon']),
                        esc_attr($social['text'])
                    )
                );
            }

            $output = sprintf('<ul class="social">%s</ul>', $items);
        }

        return $output;

    }

    add_shortcode('bw-social', 'bw_social_shortcode');
}

if (!function_exists('bw_phone_shortcode')) {
    /**
     * Add Shortcode Phones
     *
     * @param $atts
     * @return string
     */
    function bw_phone_shortcode($atts)
    {

        // Attributes
        $atts = shortcode_atts(
            array(),
            $atts
        );

        $output = '';

        if (has_phones()) {
            $items = '';

            foreach (get_phones() as $phone) {
                $items .= sprintf(
                    '<li class="phone-item">%s</li>',
                    sprintf(
                        '<a class="phone-number" href="tel:%s"></a>',
                        esc_attr(get_phone_number($phone)),
                        esc_html($phone)
                    )
                );
            }

            $output = sprintf('<ul class="phone">%s</ul>', $items);
        }

        return $output;

    }

    add_shortcode('bw-phone', 'bw_phone_shortcode');
}

if (!function_exists('bw_html_sitemap')) {
    /**
     * Add Shortcode HTML Sitemap
     *
     * @param $atts
     * @return string
     */
    function bw_html_sitemap($atts)
    {
        $output = '';
        $args   = array(
            'public' => 1,
        );

        // If you would like to ignore some post types just add them to the array below
        $ignoreposttypes = array(
            'attachment',
            'popup',
        );

        $post_types = get_post_types($args, 'objects');

        foreach ($post_types as $post_type) {
            if (!in_array($post_type->name, $ignoreposttypes)) {
                $output      .= '<h2 class="sitemap-headline">' . $post_type->labels->name . '</h2>';
                $args        = array(
                    'posts_per_page' => -1,
                    'post_type'      => $post_type->name,
                    'post_status'    => 'publish'
                );
                $posts_array = get_posts($args);
                $output      .= '<ul class="sitemap-list">';
                foreach ($posts_array as $pst) {
                    $output .= '<li class="sitemap-item"><a class="sitemap-link" href="' . get_permalink($pst->ID) . '">' . $pst->post_title . '</a></li>';
                }
                $output .= '</ul>';
            }
        }

        return $output;
    }

    add_shortcode('bw-html-sitemap', 'bw_html_sitemap');
}

if (!function_exists("bw_last_posts")) {
    /**
     * 
     * Shortcode для отображения трёх последних новостей в блоге. 
     * Новости должны быть: 
     * - Опубликованы
     * - Желательно с картинкой
     * ТАКЖЕ! Шорткод может принимать такие аттрибуты, как:
     * - count - число новостей для вывода (по-стандарту: 3)
     * - button_title - текст в кнопке (по-стандарту: "Читать полностью")
     * @param  array  $atts Аттрибуты шорткода
     * @return string       Разметка (на Bootstrap)
     */
    function bw_last_posts ( $atts = array() ) {
        $atts = shortcode_atts( 
        array(
            'count' => 3, // Кол-во новостей для отображения
            'button_title' => "Читать полностью" // Текст в ссылке
        ), $atts );

        $posts = wp_get_recent_posts( array(
            'numberposts' => $atts['count'],
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish'
        ), ARRAY_A );

        $output = '<div class="container"><div class="row">';

        foreach ($posts as $key => $post) {
            $thumbnail = get_the_post_thumbnail_url($post['ID']);
            $permalink = get_permalink($post['ID']);
            $output .= '<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12"><div class="custom-card custom-card-with-image">';
                if ($thumbnail !== false) {
                    $output .= '<div class="custom-card-image">
                                    <img src="'.$thumbnail.'" title="'.$post['post_title'].'" alt="" width="100%" height="auto"  />
                                </div>';
                }
                $output .= '<div class="custom-card-body">
                                <h3>
                                    <a href="'.$permalink.'">'.$post['post_title'].'</a>
                                </h3>
                                <p>
                                    '.$post['post_excerpt'].'
                                </p>
                                <br />
                                <a href="'.$permalink.'" class="button-small button-inverse">
                                    '.$atts['button_title'].'
                                </a>
                            </div>';
            $output .= '</div></div>';
        }

        $output .= '</div></div>';

        return $output;

    } 

    add_shortcode( "bw-last-posts", "bw_last_posts" );
}