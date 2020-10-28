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


/**
 * Enqueue JS files (frontend)
 */
function lh_register_scripts() {
  wp_enqueue_script(
    'lh-divi-child-js',
    get_stylesheet_directory_uri() . '/js/child.js',
    ['jquery'],
    sha1_file(get_stylesheet_directory() . '/js/child.js'),
    true
  );
  wp_localize_script(
    'lh-divi-child-js',
    'lhtranslation',
    ['material_expand' => __('Alle anzeigen', 'Divi')]
  );
  wp_enqueue_script(
    'lh-vue-js',
    get_stylesheet_directory_uri() . '/vue/dist/js/app.js',
    '',
    sha1_file(get_stylesheet_directory() . '/vue/dist/js/app.js'),
    true
  );
}
add_action('wp_enqueue_scripts', 'lh_register_scripts', 11);


/**
 * Enqueue CSS files (frontend)
 *
 * 1. Make sure to execute after Divi
 * 2. Divi autmoatically includes child theme css, so we have to remove it again
 */
function lh_register_styles () {
  wp_dequeue_style('divi-style'); /* 2 */
  wp_deregister_style('divi-style'); /* 2 */

  wp_enqueue_style(
    'parent-style',
    get_template_directory_uri() . '/style.css'
  );
  wp_enqueue_style(
    'lh-divi-child-style',
    get_stylesheet_directory_uri() . '/style.css',
    ['parent-style'],
    sha1_file(get_stylesheet_directory().'/style.css')
  );
  wp_enqueue_style(
    'lh-onetrust-style',
    get_stylesheet_directory_uri() . '/css/onetrust-style.css',
    ['parent-style'],
    sha1_file(get_stylesheet_directory().'/css/onetrust-style.css')
  );
  wp_enqueue_style(
    'lh-top-menu-style',
    get_stylesheet_directory_uri() . '/css/top-menu.css',
    ['parent-style'],
    sha1_file(get_stylesheet_directory().'/css/top-menu.css')
  );
  wp_enqueue_style(
    'lh-vue-style',
    get_stylesheet_directory_uri() . '/vue/dist/css/app.css',
    ['parent-style'],
    sha1_file(get_stylesheet_directory().'/vue/dist/css/app.css')
  );
}
add_action('wp_enqueue_scripts', 'lh_register_styles', 11); /* 1 */


/**
 * Register Styles/Scripts specifically for the admin panel
 */
function register_admin_scripts_and_styles () {
  wp_enqueue_style(
    'admin-styles',
    get_stylesheet_directory_uri() . '/css/admin.css',
    [],
    sha1_file(get_stylesheet_directory() . '/css/admin.css')
  );
};
add_action('admin_enqueue_scripts', 'register_admin_scripts_and_styles');


/**
 * Prevent divi from cropping images in the blog
 */
function lh_remove_featured_post_cropping($sizes) {
  if (isset($sizes['1080x675'])) {
    unset($sizes['1080x675']);
    $sizes['1080x9998'] = 'et-pb-post-main-image-fullwidth';
  }
  return $sizes;
}
add_filter('et_theme_image_sizes', 'lh_remove_featured_post_cropping');


/**
 * Register menus and sidebars
 */
function register_mobile_menu() {
  /**
   * Register Mobile Menu
   */
  register_nav_menu( 'mobile', __( 'Mobile Menu', 'Divi' ) );

  /**
   * Register footer sidebar
   */
  register_sidebar( array(
    'id'          => 'footer-badges',
    'name'        => __( 'Footer badges' ),
    'description' => __( 'This sidebar is in the bottom right corner for the badges'),
  ) );

  /**
   * Register sidebar for the banner
   */
  register_sidebar( array(
    'id'          => 'top-banner',
    'name'        => __( 'Top Banner' ),
    'description' => __( 'This sidebar is located above the header'),
  ) );

  /**
   * Register footer sidebar
   */
  register_sidebar( array(
    'id'          => 'footer-badges',
    'name'        => __( 'Footer badges' ),
    'description' => __( 'This sidebar is in the bottom right corner for the badges'),
  ) );
}
add_action( 'after_setup_theme', 'register_mobile_menu' );

/**
 * WPML - change language cookie
 */
function change_lang_cookie() {
	if( defined('ICL_LANGUAGE_CODE') ){
		setcookie('lhLocale', ICL_LANGUAGE_CODE, '' , '/', ".laserhub.com");
	}
}

add_action( 'wpml_language_has_switched', 'change_lang_cookie' );

/**
 * Set language cookie
 */
function set_lang_cookie(){
	$isset_lang_cookie = isset( $_COOKIE['lhLocale'] );

	if ( !$isset_lang_cookie && defined('ICL_LANGUAGE_CODE') ) {
		setcookie('lhLocale', ICL_LANGUAGE_CODE, '' , '/', ".laserhub.com");
	}
}

add_action( 'wp_loaded', 'set_lang_cookie' );

/**
 * Set new Nalio A/B testing cookie
 */
function set_nalio_cookie(){
	$isset_nalio_cookie = isset( $_COOKIE['nabExperimentsWithPageViews'] );

	if ( $isset_nalio_cookie ) {
		$expire = time() + 60 * 60 * 24 * 30 * 4;
		setcookie('nabExperimentsWithPageViewsWordPress', $_COOKIE['nabExperimentsWithPageViews'], $expire, '/', ".laserhub.com");
	}
}

add_action( 'wp_loaded', 'set_nalio_cookie' );
