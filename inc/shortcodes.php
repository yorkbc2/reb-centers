<?php

if (!function_exists('bw_polylang_shortcode')) {
    /**
     * Add Shortcode Polylang
     *
     * @param $atts
     *
     * @return array|null|string
     */
    function polylang_shortcode($atts)
    {
        // Attributes
        $atts = shortcode_atts(
            array(
                'dropdown' => 0, // display as list and not as dropdown
                'echo' => 0, // echoes the list
                'hide_if_empty' => 1, // hides languages with no posts ( or pages )
                'menu' => 0, // not for nav menu ( this argument is deprecated since v1.1.1 )
                'show_flags' => 0, // don't show flags
                'show_names' => 1, // show language names
                'display_names_as' => 'name', // valid options are slug and name
                'force_home' => 0, // tries to find a translation
                'hide_if_no_translation' => 0, // don't hide the link if there is no translation
                'hide_current' => 0, // don't hide current language
                'post_id' => null, // if not null, link to translations of post defined by post_id
                'raw' => 0, // set this to true to build your own custom language switcher
                'item_spacing' => 'preserve', // 'preserve' or 'discard' whitespace between list items
            ),
            $atts
        );

        if (function_exists('pll_the_languages')) {
            $flags = pll_the_languages($atts);

            if (0 === (int)$atts['dropdown']) {
                $flags = sprintf('<ul class="lang"></ul>', $flags);
            }

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
     *
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
                        '<a class="social-link" href="%s" target="_blank"><i class="%s" aria-hidden="true" aria-label="%s"></i></a>',
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
     *
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
                        '<a class="phone-number" href="tel:%s">%s</a>',
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

if (!function_exists('bw_messengers_shortcode')) {
    /**
     * Add Shortcode Messengers
     *
     * @param $atts
     *
     * @return string
     */
    function bw_messengers_shortcode($atts)
    {

        // Attributes
        $atts = shortcode_atts(
            array(),
            $atts
        );

        $output = '';

        if (has_messengers()) {
            $items = '';

            foreach (get_messengers() as $name => $messenger) {
                $icon = sprintf(
                    '<i class="%s" aria-hidden="true" aria-label="%s"></i>',
                    esc_attr($messenger['icon']),
                    esc_attr($messenger['text'])
                );

                $link = sprintf(
                    '<a class="messenger-link messenger-%s" href="tel:%s" target="_blank" rel="nofollow noopener">%s</a>',
                    esc_attr($name),
                    esc_attr(get_phone_number($messenger['tel'])),
                    $icon
                );

                $item = sprintf('<li class="messenger-item">%s</li>', $link);

                $items .= $item . PHP_EOL;
            }

            $output = sprintf('<ul class="messenger">%s</ul>', $items);
        }

        return $output;

    }

    add_shortcode('bw-messengers', 'bw_messengers_shortcode');
}

if (!function_exists('bw_html_sitemap')) {
    /**
     * Add Shortcode HTML Sitemap
     *
     * @param $atts
     *
     * @return string
     */
    function bw_html_sitemap($atts)
    {
        $output = '';
        $args = array(
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
                $output .= '<h2 class="sitemap-headline">' . $post_type->labels->name . '</h2>';
                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => $post_type->name,
                    'post_status' => 'publish',
                    'orderby' => 'title',
                    'order' => 'ASC',
                );
                $posts_array = get_posts($args);
                $output .= '<ul class="sitemap-list">';
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

if (!function_exists('bw_last_posts')) {
    /**
     *
     * Shortcode для отображения трёх последних новостей в блоге.
     * Новости должны быть:
     * - Опубликованы
     * - Желательно с картинкой
     * ТАКЖЕ! Шорткод может принимать такие аттрибуты, как:
     * - count - число новостей для вывода (по-стандарту: 3)
     * - button_title - текст в кнопке (по-стандарту: 'Читать полностью')
     *
     * @param  array $atts Аттрибуты шорткода
     *
     * @return string       Разметка (на Bootstrap)
     */
    function bw_last_posts($atts = array())
    {
        $atts = shortcode_atts(
            array(
                'count' => 3, // Кол-во новостей для отображения
                'button_title' => __('Читать полностью', 'brainworks') // Текст в ссылке
            ), $atts);

        $posts = wp_get_recent_posts(array(
            'numberposts' => $atts['count'],
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish'
        ), ARRAY_A);

        $output = '<div class="container"><div class="row">';

        foreach ($posts as $key => $post) {
            $thumbnail_id = get_post_thumbnail_id($post['ID']);
            $thumbnail = get_the_post_thumbnail_url($post['ID'], 'medium');
            $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
            $permalink = get_permalink($post['ID']);
            $output .= '<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12"><div class="custom-card custom-card-with-image">';
            if ($thumbnail !== false) {
                $output .= '<div class="custom-card-image">
                                    <img src="' . $thumbnail . '" title="' . $post['post_title'] . '" alt="' . $thumbnail_alt . '" width="100%" height="auto"  />
                                </div>';
            }
            $output .= '<div class="custom-card-body">
                                <h3>
                                    <a href="' . $permalink . '">' . $post['post_title'] . '</a>
                                </h3>
                                <p>
                                    ' . $post['post_excerpt'] . '
                                </p>
                                <br />
                                <a href="' . $permalink . '" class="button-small button-inverse">
                                    ' . $atts['button_title'] . '
                                </a>
                            </div>';
            $output .= '</div></div>';
        }

        $output .= '</div></div>';

        return $output;

    }

    add_shortcode('bw-last-posts', 'bw_last_posts');
}

if (!function_exists('bw_advert_shortcode')) {
    /**
     * Add Shortcode Advert Post List
     *
     * @param $atts
     *
     * @return string
     */
    function bw_advert_shortcode($atts)
    {
        // Attributes
        $atts = shortcode_atts(
            array(
                'count' => 3,
                'class' => 'advert'
            ),
            $atts
        );

        $output = '';

        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $atts['count'],
            'meta_query' => array(
                'relation' => 'OR',
                array(
                    'key' => 'on-front',
                    'value' => 'yes',
                ),
            )
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $items = '';
            $basic_class = trim(strip_tags($atts['class']));

            while ($query->have_posts()) {
                $query->the_post();

                $thumbnail = has_post_thumbnail() ? sprintf(
                    '<figure class="%s-preview"><a href="%s">%s</a></figure>',
                    $basic_class, get_the_permalink(),
                    get_the_post_thumbnail(null, 'medium', array('class' => $basic_class . '-thumbnail'))
                ) : '';

                $headline = sprintf('<h3 class="%s-headline"><a href="%s">%s</a></h3>',
                    $basic_class, get_the_permalink(), get_the_title()
                );

                $excerpt = sprintf('<div class="%s-excerpt">%s</div>', $basic_class, get_the_excerpt());

                $btn = sprintf('<div class="text-right"><a class="button-small %s-link" href="%s">%s</a></div>',
                    $basic_class, get_the_permalink(), __('Continue reading', 'brainworks')
                );

                $item = sprintf('<section id="post-%s" class="%s">%s %s %s %s</section>', get_the_ID(),
                    join(' ', get_post_class(array('col-md-4', $basic_class . '-item'))),
                    $thumbnail, $headline, $excerpt, $btn
                );

                $items .= $item;
            }

            wp_reset_postdata();

            $output = sprintf('<div class="container"><div class="row %s-list">%s</div>', $basic_class, $items);
        }

        return $output;
    }

    add_shortcode('bw-advert', 'bw_advert_shortcode');
}

if (!function_exists('bw_custom_login_shortcode')) {
    function bw_custom_login_shortcode($atts)
    {
        if (!bw_user_logged_in()) {
            $output = '
                <form class="login-form form-" action="/wp-json/api/auth/login" method="POST" autocomplete="off">
                <fieldset>
                    <input type="hidden" name="_redirect_url" value="' . strtok($_SERVER['REQUEST_URI'], '?') . '" />
                    <div class="login-form-row form-group">
                        <label for="login">' . __('Login', 'brainworks') . '</label>
                        <input type="text" id="login" name="login" class="form-field" required />
                    </div>
                    <div class="login-form-row form-group">
                        <label for="password">' . __('Password', 'brainworks') . '</label>
                        <input type="password" id="password" name="password" class="form-field" required />
                    </div>
                    <div class="login-form-row form-group">
                        <button type="submit" name="submit" class="btn btn-primary login-form-submit">
                            ' . __('Login', 'brainworks') . '
                        </button>
                    </div>   
                </fieldset>   
                </form>
            ';
            return $output;
        }
        return '';
    }

    add_shortcode('bw-custom-login', 'bw_custom_login_shortcode');
}

if (!function_exists('bw_custom_register_shortcode')) {
    function bw_custom_register_shortcode($atts)
    {
        if (!bw_user_logged_in()) {
            $output = '
            <form class="login-form form-" action="/wp-json/api/auth/register" method="POST" autocomplete="off">
            <fieldset>
                <input type="hidden" name="_redirect_url" value="' . strtok($_SERVER['REQUEST_URI'], '?') . '" />
                <div class="login-form-row form-group">
                    <label for="login">' . __('Login', 'brainworks') . '</label>
                    <input type="text" id="login" name="login" class="form-field" required />
                </div>
                <div class="login-form-row form-group">
                    <label for="email">' . __('Email', 'brainworks') . '</label>
                    <input type="email" id="email" name="email" class="form-field" required />
                </div>
                <div class="login-form-row form-group">
                    <label for="password">' . __('Password', 'brainworks') . '</label>
                    <input type="password" id="password" name="password" class="form-field" required />
                </div>
                <div class="login-form-row form-group">
                    <label for="retry_password">' . __('Retry password', 'brainworks') . '</label>
                    <input type="password" id="retry_password" name="retry_password" class="form-field" required />
                </div>
                <div class="login-form-row form-group">
                    <button type="submit" name="submit" class="btn btn-primary login-form-submit">
                        ' . __('Register', 'brainworks') . '
                    </button>
                </div>    
            </fieldset>  
            </form>
            ';
            return $output;
        }
        return '';
    }

    add_shortcode('bw-custom-register', 'bw_custom_register_shortcode');
}


if (!function_exists('bw_custom_auth_shortcode')) {
    function bw_custom_auth_shortcode($atts)
    {

        if (!bw_user_logged_in()) {
            $login_form = do_shortcode('[bw-custom-login]');
            $register_form = do_shortcode('[bw-custom-register]');
            $output = '<div class="login-block row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                ' . $login_form . ' 
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                ' . $register_form . '
                </div>
            </div>';
            return $output;
        }
        return '';
    }

    add_shortcode('bw-custom-auth', 'bw_custom_auth_shortcode');
}

if (!function_exists('bw_reviews_shortcode')) {
    /**
     * Add Shortcode Reviews List
     *
     * @param $atts
     *
     * @return string
     */
    function bw_reviews_shortcode($atts)
    {
        // Attributes
        $atts = shortcode_atts(
            array(),
            $atts
        );

        $output = '';

        $args = array(
            'post_type' => 'reviews',
            'publish_status' => 'publish',
            'orderby' => 'post_date',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'review-display',
                    'value' => '1',
                )
            ),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {

            $output .= '<div class="review-slider text-center js-reviews">';

            while ($query->have_posts()) {
                $query->the_post();

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

                $post_class = 'class="' . join(' ', get_post_class('review-item', null)) . '"';

                $output .= '<div id="post-' . get_the_ID() . '" ' . $post_class . '>';

                $output .= '<div class="review-client">';
                $output .= get_the_post_thumbnail(null, 'thumbnail', array('class' => 'review-avatar'));
                if (count($social)) {
                    $output .= '<a class="review-social" href="' . esc_url($social['url']) . '" target="_blank" rel="noopener noreferrer">';
                    $output .= '<i class="fab ' . esc_attr($social['icon']) . '" aria-hidden="true"></i>';
                    $output .= '</a>';
                }
                $output .= '</div>';
                $output .= '<div class="review-title text-bold">' . get_the_title() . '</div>';
                $output .= '<div class="review-content">' . get_the_content() . '</div>';

                $output .= '</div>';
            }

            wp_reset_postdata();

            $output .= '</div>';
        }

        return $output;
    }

    add_shortcode('bw-reviews', 'bw_reviews_shortcode');
}
