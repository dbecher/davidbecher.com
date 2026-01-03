<?php

add_action('wp_enqueue_scripts', 'twentytwentyfivechild_theme_enqueue_styles');
function twentytwentyfivechild_theme_enqueue_styles()
{
  wp_enqueue_style(
    'twentytwentyfivechild-style',
    get_stylesheet_uri(),
    array('twentytwentyfive'),
    wp_get_theme()->get('Version') // This only works if you have Version defined in the style header.
  );
}
