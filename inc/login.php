<?php

/** Login page logo */
function bw_login_head()
{
    $default_logo_url = get_template_directory_uri() . '/assets/img/login-logo.svg';
    $logo_url = get_theme_mod('bw_login_logo', $default_logo_url);
    $background = get_background_login_page();

    echo sprintf(
        '<style>.login{%s}.login h1 a{background-image: url("%s"); background-position: center center;}</style>',
        $background, $logo_url
    );
}

add_action('login_head', 'bw_login_head');

/** Authorization error */
function bw_login_error()
{
    return __('<strong>ERROR:</strong> The username and password is incorrect.', 'brainworks');
}

add_filter('login_errors', 'bw_login_error');

/** Login page logo url */
function bw_login_headerurl($login_header_url)
{
    return esc_url(site_url());
}

add_filter('login_headerurl', 'bw_login_headerurl');

/** Login page logo title */
function bw_login_headertitle($login_header_title)
{
    return esc_attr(get_bloginfo('name'));
}

add_filter('login_headertitle', 'bw_login_headertitle');
