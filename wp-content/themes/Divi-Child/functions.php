<?php
/**
 * Divi Cake Child Theme
 * Functions.php
 *
 * ===== NOTES ==================================================================
 *
 * Unlike style.css, the functions.php of a child theme does not override its
 * counterpart from the parent. Instead, it is loaded in addition to the parent's
 * functions.php. (Specifically, it is loaded right before the parent's file.)
 *
 * In that way, the functions.php of a child theme provides a smart, trouble-free
 * method of modifying the functionality of a parent theme.
 *
 * Discover Divi Child Themes: https://divicake.com/products/category/divi-child-themes/
 * Sell Your Divi Child Themes: https://divicake.com/open/
 *
 * =============================================================================== */

function divichild_enqueue_scripts() {
  wp_enqueue_script(
    'child-js',
    get_stylesheet_directory_uri() . '/js/child.js',
    ['jquery'],
    sha1_file(get_stylesheet_directory() . '/js/child.js')
  );
  wp_localize_script(
    'child-js',
    'lhtranslation',
    array('material_expand' => __('Alle anzeigen', 'Divi'))
  );

  wp_enqueue_script(
    'vue-js',
    get_stylesheet_directory_uri() . '/vue/dist/js/app.js',
    '',
    sha1_file(get_stylesheet_directory() . '/vue/dist/js/app.js'),
    true
  );

}
add_action( 'wp_enqueue_scripts', 'divichild_enqueue_scripts' );

// deregister divi style
function wp_67472455() {
   wp_dequeue_style( 'divi-style' );
   wp_deregister_style( 'divi-style' );
}
add_action( 'wp_enqueue_scripts', 'wp_67472455', 1000 );



function my_theme_enqueue_styles() {

    wp_enqueue_style(
      'parent-style',
      get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_style(
      'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'parent-style' ),
        sha1_file(get_stylesheet_directory().'/style.css')
    );
    wp_enqueue_style(
      'onetrust-style',
        get_stylesheet_directory_uri() . '/onetrust-style.css',
        array( 'parent-style' ),
        sha1_file(get_stylesheet_directory().'/onetrust-style.css')
    );
     wp_enqueue_style(
      'top-menu',
        get_stylesheet_directory_uri() . '/top-menu.css',
        array( 'parent-style' ),
        sha1_file(get_stylesheet_directory().'/top-menu.css')
    );
    wp_enqueue_style(
      'Vue-css',
        get_stylesheet_directory_uri() . '/vue/dist/css/app.css',
        array( 'parent-style' ),
        sha1_file(get_stylesheet_directory().'/vue/dist/css/app.css')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/* Register sidebar for the banner */
register_sidebar( array(
  'id'          => 'top-banner',
  'name'        => __( 'Top Banner' ),
  'description' => __( 'This sidebar is located above the header'),
) );

/* Prevent divi from cropping images in the blog */
add_filter('et_theme_image_sizes', 'lh_remove_featured_post_cropping');
function lh_remove_featured_post_cropping($sizes) {
  if (isset($sizes['1080x675'])) {
    unset($sizes['1080x675']);
    $sizes['1080x9998'] = 'et-pb-post-main-image-fullwidth';
  }
  return $sizes;
}

function register_mobile_menu() {
    register_nav_menu( 'mobile', __( 'Mobile Menu', 'Divi' ) );
}
add_action( 'after_setup_theme', 'register_mobile_menu' );
