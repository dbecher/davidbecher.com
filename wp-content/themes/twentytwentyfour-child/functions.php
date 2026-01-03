<?php

add_action('wp_enqueue_scripts', 'twentytwentyfourchild_theme_enqueue_styles');
function twentytwentyfourchild_theme_enqueue_styles()
{
  wp_enqueue_style(
    'twentytwentyfourchild-style',
    get_stylesheet_uri(),
    array('twentytwentyfour'),
    wp_get_theme()->get('Version') // This only works if you have Version defined in the style header.
  );
}
