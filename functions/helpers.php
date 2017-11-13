<?php

/**
 * Clear phone number for tag <a href="tel:"></a>
 *
 * @param $phone_number
 *
 * @return mixed
 */
function get_clear_phone_number( $phone_number ) {
  return str_replace( array( '-', '(', ')', ' ' ), '', $phone_number );
}

/**
 * @param $phone_number
 */
function clear_phone_number( $phone_number ) {
  echo get_clear_phone_number( $phone_number );
}

/**
 * @return bool|string
 */
function get_scroll_top() {

  if ( get_theme_mod( 'bw_scroll_top_display', true ) ) {

    $shape = '';
    switch ( get_theme_mod( 'bw_scroll_top_shape', 'circle' ) ) {
      case 'circle':
        $shape = 'is-circle';
        break;
      case 'rounded':
        $shape = 'is-rounded';
        break;
    }

    $position = '';
    switch ( get_theme_mod( 'bw_scroll_top_position', 'right' ) ) {
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
 *
 */
function scroll_top() {
  echo get_scroll_top();
}

/**
 * @param string $placed
 *
 * @return string
 */
function get_analytics_tracking_code( $placed = 'body' ) {
  $tracking_code = array();
  $tracking_code['google'] = get_theme_mod( 'bw_analytics_google' );
  $tracking_code['yandex'] = get_theme_mod( 'bw_analytics_yandex' );
  $tracking_code['custom'] = get_theme_mod( 'bw_analytics_custom' );

  $tracking_placed = array();
  $tracking_placed['google'] = get_theme_mod( 'bw_analytics_google_placed', 'body' );
  $tracking_placed['yandex'] = get_theme_mod( 'bw_analytics_yandex_placed', 'body' );
  $tracking_placed['custom'] = get_theme_mod( 'bw_analytics_custom_placed', 'body' );

  $output = '';

  foreach ( $tracking_code as $key => $script ) {
    if ( ! empty( $tracking_placed[ $key ] ) && ! empty( $script ) ) {
      if ( $tracking_placed[ $key ] === $placed ) {
        $output .= $script . PHP_EOL;
      }
    }
  };

  if ( ! empty( $output ) ) {
    return sprintf( '<script type="text/javascript">%s</script>', $output );
  }

  return '';

}

/**
 * @param string $placed
 */
function analytics_tracking_code($placed = 'body') {
  echo get_analytics_tracking_code($placed);
}
