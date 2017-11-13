<?php

/** Login page logo */
function brainworks_login_head() {
  $default_image = get_template_directory_uri() . '/img/login-logo.png';
  $customize_image = get_theme_mod( 'bw_login_logo', $default_image );
  $image = ! empty( $customize_image ) ? $customize_image : $default_image;

  echo sprintf(
    '<style type="text/css">.login h1 a{background-image: url("%s"); }</style>',
    $image
  );
}

add_action( 'login_head', 'brainworks_login_head' );

/** Authorization error */
function brainworks_login_error() {
  return __( '<strong>ERROR:</strong> The username and password is incorrect.', 'brainworks' );
}

//add_filter( 'login_errors', 'brainworks_login_error' );

/** Login page logo url */
function brainworks_login_headerurl( $login_header_url ) {
  return esc_url( site_url() );
}

add_filter( 'login_headerurl', 'brainworks_login_headerurl' );

/** Login page logo title */
function brainworks_login_headertitle( $login_header_title ) {
  return esc_attr( get_bloginfo( 'name' ) );
}

add_filter( 'login_headertitle', 'brainworks_login_headertitle' );
