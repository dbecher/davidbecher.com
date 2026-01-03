<?php
/**
 * Plugin Name: Photoset
 * Description: A plugin for creating and managing photo sets.
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function photoset_register_photo_post_type() {
     $args = array(
        'labels' => array(
            'name'          => 'Photo Sets',
            'singular_name' => 'Photo Set',
            'menu_name'     => 'Photo Sets',
            'add_new'       => 'Add New Photo Set',
            'add_new_item'  => 'Add New Photo Set',
            'new_item'      => 'New Photo Set',
            'edit_item'     => 'Edit Photo Set',
            'view_item'     => 'View Photo Set',
            'all_items'     => 'All Photo Sets',
        ),
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'gallery', 'excerpt' ),
    );

    register_post_type( 'photoset', $args );
}

add_action( 'init', 'photoset_register_photo_post_type' );
