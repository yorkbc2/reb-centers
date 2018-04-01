<?php

function bw_widgets_init()
{

    /**
     * Sidebar (one widget area)
     */
    register_sidebar(array(
        'name'          => __('Sidebar', 'brainworks'),
        'id'            => 'sidebar-widget-area',
        'description'   => __('The sidebar widget area', 'brainworks'),
        'before_widget' => '<section class="widget-item %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));

    /**
     * Sidebar (two widget area)
     */
    register_sidebar(array(
        'name'          => __('Sidebar 2', 'brainworks'),
        'id'            => 'sidebar-widget-area2',
        'description'   => __('The sidebar widget area', 'brainworks'),
        'before_widget' => '<section class="widget-item %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));

    /**
     * Footer (three widget areas)
     */
    register_sidebar(array(
        'name'          => __('Footer', 'brainworks'),
        'id'            => 'footer-widget-area',
        'description'   => __('The footer widget area', 'brainworks'),
        'before_widget' => '<div class="widget-item %1$s %2$s col-sm-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ));

}

add_action('widgets_init', 'bw_widgets_init');
