<?php

/**
 * @param $name
 * @param bool $default
 */
function theme_mod( $name, $default = false ) {
  $theme_mod = get_theme_mod( $name, $default );

  if ( ! empty( $theme_mod ) ) {
    echo $theme_mod;
  }
}

/**
 * @param $wp_customize
 */
function brainworks_customize_register( $wp_customize ) {

  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
  $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
  $wp_customize->get_setting( 'background_color' )->transport = 'postMessage';


  // Panel Theme Options
  $wp_customize->add_panel( 'bw_theme_options', array(
    'title'       => __( 'Theme Options', 'brainworks' ),
    'description' => esc_html__( 'Theme Options Customizer', 'brainworks' ),
    'priority'    => 201,
  ) );

  // Section Scroll Top
  $wp_customize->add_section( 'bw_scroll_top', array(
    'title'       => __( 'Scroll Top', 'brainworks' ),
    'description' => esc_html__( 'Customizer Custom Scroll Top', 'brainworks' ),
    'panel'       => 'bw_theme_options',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_display', array(
    'default' => true,
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_width', array(
    'default'   => '55',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_height', array(
    'default'   => '55',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_shape', array(
    'default'   => 'circle',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_position', array(
    'default'   => 'right',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_offset_left_right', array(
    'default'   => '20',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_offset_bottom', array(
    'default'   => '20',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_border_width', array(
    'default'   => '1',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_border_color', array(
    'default'   => '#000000',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_background_color', array(
    'default'   => '#000000',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_background_color_hover', array(
    'default'   => '#000000',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_setting( 'bw_scroll_top_arrow_color', array(
    'default'   => '#ffffff',
    'transport' => 'postMessage',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_display', array(
    'label'       => __( 'Display', 'brainworks' ),
    'description' => esc_html__( 'Show/Hide scroll top', 'brainworks' ),
    'section'     => 'bw_scroll_top',
    'settings'    => 'bw_scroll_top_display',
    'type'        => 'checkbox',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_width', array(
    'label'    => __( 'Width', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_width',
    'type'     => 'number',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_height', array(
    'label'    => __( 'Height', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_height',
    'type'     => 'number',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_shape', array(
    'label'    => __( 'Shape', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_shape',
    'type'     => 'select',
    'choices'  => array(
      'circle'  => __( 'Circle', 'brainworks' ),
      'rounded' => __( 'Rounded', 'brainworks' ),
      'square'  => __( 'Square', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_scroll_top_position', array(
    'label'    => __( 'Position', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_position',
    'type'     => 'select',
    'choices'  => array(
      'right' => __( 'Right', 'brainworks' ),
      'left'  => __( 'Left', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_scroll_top_offset_left_right', array(
    'label'    => __( 'Offset Left/Right', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_offset_left_right',
    'type'     => 'number',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_offset_bottom', array(
    'label'    => __( 'Offset bottom', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_offset_bottom',
    'type'     => 'number',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_border_width', array(
    'label'    => __( 'Border width', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_border_width',
    'type'     => 'number',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_border_color', array(
    'label'    => __( 'Border color', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_border_color',
    'type'     => 'color',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_background_color', array(
    'label'    => __( 'Background color', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_background_color',
    'type'     => 'color',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_background_color_hover', array(
    'label'    => __( 'Background color hover', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_background_color_hover',
    'type'     => 'color',
  ) );

  $wp_customize->add_control( 'bw_scroll_top_arrow_color', array(
    'label'    => __( 'Arrow color', 'brainworks' ),
    'section'  => 'bw_scroll_top',
    'settings' => 'bw_scroll_top_arrow_color',
    'type'     => 'color',
  ) );

  // Section Analytics Tracking Code
  $wp_customize->add_section( 'bw_analytics', array(
    'title'       => __( 'Analytics', 'brainworks' ),
    'description' => esc_html__( 'Analytics Tracking Code', 'brainworks' ),
    'panel'       => 'bw_theme_options',
  ) );

  $wp_customize->add_setting( 'bw_analytics_google_placed', array(
    'default' => 'body',
  ) );

  $wp_customize->add_setting( 'bw_analytics_google', array() );

  $wp_customize->add_setting( 'bw_analytics_yandex_placed', array(
    'default' => 'body',
  ) );

  $wp_customize->add_setting( 'bw_analytics_yandex', array() );

  $wp_customize->add_setting( 'bw_chat_placed', array(
      'default' => 'body',
  ) );

  $wp_customize->add_setting( 'bw_chat', array() );

  $wp_customize->add_setting( 'bw_remarketing_placed', array(
      'default' => 'body',
  ) );

  $wp_customize->add_setting( 'bw_remarketing', array() );

  $wp_customize->add_setting( 'bw_analytics_custom_placed', array(
    'default' => 'body',
  ) );

  $wp_customize->add_setting( 'bw_analytics_custom', array() );

  $wp_customize->add_control( 'bw_analytics_google_placed', array(
    'label'       => __( 'Google Analytics', 'brainworks' ),
    'description' => esc_html__( 'Placed (head/body)', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_analytics_google_placed',
    'type'        => 'select',
    'choices'     => array(
      'head' => __( 'Head', 'brainworks' ),
      'body' => __( 'Body', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_analytics_google', array(
    'description' => esc_html__( 'Paste tracking code here &dArr;', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_analytics_google',
    'type'        => 'textarea',
    'input_attrs' => array(
      'placeholder' => __( '<!-- paste tracking code here -->', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_analytics_yandex_placed', array(
    'label'       => __( 'Yandex Metrika', 'brainworks' ),
    'description' => esc_html__( 'Placed (head/body)', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_analytics_yandex_placed',
    'type'        => 'select',
    'choices'     => array(
      'head' => __( 'Head', 'brainworks' ),
      'body' => __( 'Body', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_analytics_yandex', array(
    'description' => esc_html__( 'Paste tracking code here &dArr;', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_analytics_yandex',
    'type'        => 'textarea',
    'input_attrs' => array(
      'placeholder' => __( '<!-- paste tracking code here -->', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_chat_placed', array(
    'label'       => __( 'Chat code', 'brainworks' ),
    'description' => esc_html__( 'Placed (head/body)', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_chat_placed',
    'type'        => 'select',
    'choices'     => array(
        'head' => __( 'Head', 'brainworks' ),
        'body' => __( 'Body', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_chat', array(
    'description' => esc_html__( 'Paste chat code here &dArr;', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_chat',
    'type'        => 'textarea',
    'input_attrs' => array(
        'placeholder' => __( '<!-- paste chat code here -->', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_remarketing_placed', array(
    'label'       => __( 'Remarketing code', 'brainworks' ),
    'description' => esc_html__( 'Placed (head/body)', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_remarketing_placed',
    'type'        => 'select',
    'choices'     => array(
        'head' => __( 'Head', 'brainworks' ),
        'body' => __( 'Body', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_remarketing', array(
    'description' => esc_html__( 'Paste remarketing code here &dArr;', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_remarketing',
    'type'        => 'textarea',
    'input_attrs' => array(
        'placeholder' => __( '<!-- paste remarketing code here -->', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_analytics_custom_placed', array(
    'label'       => __( 'Custom Analytics', 'brainworks' ),
    'description' => esc_html__( 'Placed (head/body)', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_analytics_custom_placed',
    'type'        => 'select',
    'choices'     => array(
      'head' => __( 'Head', 'brainworks' ),
      'body' => __( 'Body', 'brainworks' ),
    ),
  ) );

  $wp_customize->add_control( 'bw_analytics_custom', array(
    'description' => esc_html__( 'Paste tracking code here &dArr;', 'brainworks' ),
    'section'     => 'bw_analytics',
    'settings'    => 'bw_analytics_custom',
    'type'        => 'textarea',
    'input_attrs' => array(
      'placeholder' => __( '<!-- paste tracking code here -->', 'brainworks' ),
    ),
  ) );

  // Section Login
  $wp_customize->add_section( 'bw_login', array(
    'title'       => __( 'Login', 'brainworks' ),
    'description' => esc_html__( 'Customizer Custom Login', 'brainworks' ),
    'panel'       => 'bw_theme_options',
  ) );

  $wp_customize->add_setting( 'bw_login_logo', array(
    'default' => get_template_directory_uri() . '/img/login-logo.png',
  ) );

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'bw_login_logo', array(
    'label'       => __( 'Logo', 'brainworks' ),
    'description' => esc_html__( 'Image size 80x80 px', 'brainworks' ),
    'section'     => 'bw_login',
    'settings'    => 'bw_login_logo',
  ) ) );

  // Section Social
  $wp_customize->add_section( 'bw_social', array(
    'title'       => __( 'Social', 'brainworks' ),
    'description' => esc_html__( 'Customizer Custom Social links', 'brainworks' ),
    'panel'       => 'bw_theme_options',
  ) );

  $wp_customize->add_setting('bw_social_vk', array('default' => '#'));
  $wp_customize->add_setting('bw_social_twitter', array('default' => '#'));
  $wp_customize->add_setting('bw_social_facebook', array('default' => '#'));
  $wp_customize->add_setting('bw_social_linkedin', array('default' => '#'));
  $wp_customize->add_setting('bw_social_instagram', array('default' => '#'));
  $wp_customize->add_setting('bw_social_google_plus', array('default' => '#'));

  $wp_customize->add_control( 'bw_social_vk', array(
    'label'    => __( 'Vk', 'brainworks' ),
    'section'  => 'bw_social',
    'settings' => 'bw_social_vk',
    'type'     => 'text',
  ) );

  $wp_customize->add_control( 'bw_social_twitter', array(
    'label'    => __( 'Twitter', 'brainworks' ),
    'section'  => 'bw_social',
    'settings' => 'bw_social_twitter',
    'type'     => 'text',
  ) );

  $wp_customize->add_control( 'bw_social_facebook', array(
    'label'    => __( 'Facebook', 'brainworks' ),
    'section'  => 'bw_social',
    'settings' => 'bw_social_facebook',
    'type'     => 'text',
  ) );

  $wp_customize->add_control( 'bw_social_linkedin', array(
    'label'    => __( 'Linkedin', 'brainworks' ),
    'section'  => 'bw_social',
    'settings' => 'bw_social_linkedin',
    'type'     => 'text',
  ) );

  $wp_customize->add_control( 'bw_social_instagram', array(
    'label'    => __( 'Instagram', 'brainworks' ),
    'section'  => 'bw_social',
    'settings' => 'bw_social_instagram',
    'type'     => 'text',
  ) );

  $wp_customize->add_control( 'bw_social_google_plus', array(
    'label'    => __( 'Google Plus', 'brainworks' ),
    'section'  => 'bw_social',
    'settings' => 'bw_social_google_plus',
    'type'     => 'text',
  ) );

  // Section Phones
  $wp_customize->add_section( 'bw_phones', array(
    'title'       => __( 'Phones', 'brainworks' ),
    'description' => esc_html__( 'Customizer Custom Phone numbers', 'brainworks' ),
    'panel'       => 'bw_theme_options',
  ) );

  $wp_customize->add_setting('bw_phone1', array());
  $wp_customize->add_setting('bw_phone2', array());
  $wp_customize->add_setting('bw_phone3', array());
  $wp_customize->add_setting('bw_phone4', array());

  $wp_customize->add_control( 'bw_phone1', array(
    'label'    => __( 'Phone №1', 'brainworks' ),
    'section'  => 'bw_phones',
    'settings' => 'bw_phone1',
    'type'     => 'tel',
  ) );

  $wp_customize->add_control( 'bw_phone2', array(
    'label'    => __( 'Phone №2', 'brainworks' ),
    'section'  => 'bw_phones',
    'settings' => 'bw_phone2',
    'type'     => 'tel',
  ) );

  $wp_customize->add_control( 'bw_phone3', array(
    'label'    => __( 'Phone №3', 'brainworks' ),
    'section'  => 'bw_phones',
    'settings' => 'bw_phone3',
    'type'     => 'tel',
  ) );

  $wp_customize->add_control( 'bw_phone4', array(
    'label'    => __( 'Phone №4', 'brainworks' ),
    'section'  => 'bw_phones',
    'settings' => 'bw_phone4',
    'type'     => 'tel',
  ) );

}

add_action( 'customize_register', 'brainworks_customize_register' );

function brainworks_customizer_preview() {
  wp_register_script( 'bw_customizer_preview', get_template_directory_uri() . '/js/customizer-preview.js', array(
    'jquery',
    'customize-preview'
  ), null, true );
  wp_enqueue_script( 'bw_customizer_preview' );
}

add_action( 'customize_preview_init', 'brainworks_customizer_preview' );

function brainworks_customize_controls_enqueue_scripts() {
  wp_register_script( 'bw_customizer_control', get_template_directory_uri() . '/js/customizer-control.js', array(
    'jquery',
    'customize-controls'
  ), null, true );
  wp_enqueue_script( 'bw_customizer_control' );
}

add_action( 'customize_controls_enqueue_scripts', 'brainworks_customize_controls_enqueue_scripts' );

function brainworks_customizer_css() { ?>
  <style type="text/css">
    .scroll-top {
      width: <?php theme_mod('bw_scroll_top_width', 55); ?>px;
      height: <?php theme_mod('bw_scroll_top_height', 55); ?>px;
      background-color: <?php theme_mod('bw_scroll_top_background_color', '#000000'); ?>;
      border-width: <?php theme_mod('bw_scroll_top_border_width', 1); ?>px;
      border-color: <?php theme_mod('bw_scroll_top_border_color', '#000000'); ?>;
      bottom: <?php theme_mod('bw_scroll_top_offset_bottom', 20); ?>px;
    <?php bw_scroll_top_position_offset(); ?>
    }

    .scroll-top:hover {
      background-color: <?php theme_mod('bw_scroll_top_background_color_hover', '#000000'); ?>;
    }

    .scroll-top--arrow {
      border-bottom-color: <?php theme_mod('bw_scroll_top_arrow_color', '#ffffff'); ?>;
    }
  </style>
  <?php
}

add_action( 'wp_head', 'brainworks_customizer_css' );

function bw_scroll_top_position_offset() {
  $position = get_theme_mod( 'bw_scroll_top_position', 'right' );
  $offset = get_theme_mod( 'bw_scroll_top_offset_left_right', 20 );

  $output = sprintf( '%s: %spx;', $position, $offset );

  echo $output;
}
