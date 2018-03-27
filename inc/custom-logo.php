<?php

/**
 * @param $html
 * @return mixed
 */
function custom_logo($html)
{
    $html = str_replace('class="custom-logo"', 'class="logo-img"', $html);
    $html = str_replace('class="custom-logo-link"', 'class="logo-link"', $html);
    return $html;
}

add_filter('get_custom_logo', 'custom_logo');
