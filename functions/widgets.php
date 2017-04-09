<?php

function brainworks_widgets_init() {

  /*
  Sidebar (one widget area)
   */
  register_sidebar( array(
    'name'            => __( 'Sidebar', 'brainworks' ),
    'id'              => 'sidebar-widget-area',
    'description'     => __( 'The sidebar widget area', 'brainworks' ),
    'before_widget'   => '<section class="%1$s %2$s">',
    'after_widget'    => '</section>',
    'before_title'    => '<h5>',
    'after_title'     => '</h5>',
  ) );

  /*
  Footer (three widget areas)
   */
  register_sidebar( array(
    'name'            => __( 'Footer', 'brainworks' ),
    'id'              => 'footer-widget-area',
    'description'     => __( 'The footer widget area', 'brainworks' ),
    'before_widget'   => '<div class="%1$s %2$s col-sm-4">',
    'after_widget'    => '</div>',
    'before_title'    => '<h5>',
    'after_title'     => '</h5>',
  ) );

}
add_action( 'widgets_init', 'brainworks_widgets_init' );
