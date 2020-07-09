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


/*** Add descriptions to the menu  ***/
/*function prefix_nav_description( $item_output, $item, $depth, $args ) {
  if ( !empty( $item->description ) ) {
        $item_output = '<div class="menu-item-wrap">' . $item_output . '<div class="menu-item-description">' . $item->description . '</div></div>';
  }
  return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );
*/

// class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
// {
//   function start_lvl( &$output, $depth = 0, $args = array() ) {
//     $indent = str_repeat("\t", $depth);
//     $output .= "\n$indent<div class='lh-sub-menu-wrap'><ul class='lh-sub-menu'>\n";
//   }
//   function end_lvl( &$output, $depth = 0, $args = array() ) {
//     $indent = str_repeat("\t", $depth);
//     $output .= "$indent</ul></div>\n";
//   }
// }

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

/* Register footer sidebar */
register_sidebar( array(
  'id'          => 'footer-badges',
  'name'        => __( 'Footer badges' ),
  'description' => __( 'This sidebar is in the bottom right corner for the badges'),
) );


// Add custom field & quickedit field

/* Set metabox for the lh_internal_name */
function add_analytics_metaboxes() {
  add_meta_box(
    'lh_internal_name',
    'Internal name for analytics',
    'lh_internal_name_callback',
    array('post', 'page'),
    'normal',
    'high'
  );
}
// add_action( 'add_meta_boxes', 'add_analytics_metaboxes' );


// function lh_internal_name_callback() {
//   global $post;
//   // Nonce field to validate form request came from current site
//   wp_nonce_field( basename( __FILE__ ), 'lh_internal_name_field' );
//   // Get the location data if it's already been entered
//   $internal_name = get_post_meta( $post->ID, 'lh_internal_name', true );
//   // Output the field
//   echo '<input type="text" name="lh_internal_name" value="' . esc_textarea( $internal_name )  . '" class="widefat">';
// }


// DEACTIVATED
/*** Add to quick edit fields ***/
// function lh_quickedit_custom_posts_columns( $posts_columns ) {
//   $posts_columns['lh_internal_name'] = __( 'Analytics name', 'generatewp' );
//   return $posts_columns;
// }
// add_filter( 'manage_post_posts_columns', 'lh_quickedit_custom_posts_columns' );

// DEACTIVATED
// function lh_quickedit_custom_pages_columns( $posts_columns ) {
//   $posts_columns['lh_internal_name'] = __( 'Analytics name', 'generatewp' );
//   return $posts_columns;
// }
// add_filter( 'manage_pages_columns', 'lh_quickedit_custom_pages_columns' );

// DEACTIVATED
function lh_quickedit_custom_column_display( $column_name, $post_id ) {
  if ( 'lh_internal_name' == $column_name ) {
    $internal_name = get_post_meta( $post_id, 'lh_internal_name', true );

    if ( $internal_name ) {
      echo esc_html( $internal_name );
    } else {
      esc_html_e( '' );
    }
  }
}
// add_action( 'manage_post_posts_custom_column', 'lh_quickedit_custom_column_display', 10, 2 );


// DEACTIVATED
function lh_quickedit_custom_column_display_( $column_name, $post_id ) {
  if ( 'lh_internal_name' == $column_name ) {
    $internal_name = get_post_meta( $post_id, 'lh_internal_name', true );

    if ( $internal_name ) {
      echo esc_html( $internal_name );
    } else {
      esc_html_e( '' );
    }
  }
}
// add_action( 'manage_pages_custom_column', 'lh_quickedit_custom_column_display_', 10, 2 );


// DEACTIVATED
function lh_quickedit_fields( $column_name, $post_type ) {
  if ( 'lh_internal_name' != $column_name )
    return;

  $internal_name = get_post_meta( $post_id, 'lh_internal_name', true );
  ?>
  <fieldset class="inline-edit-col-right">
    <div class="inline-edit-col">
      <label>
        <span class="title"><?php esc_html_e( 'Internal name' ); ?></span>
        <span class="input-text-wrap">
                    <input type="text" name="lh_internal_name" class="lh_internal_name" value="">
                </span>
      </label>
    </div>
  </fieldset>
  <?php
}
// add_action( 'quick_edit_custom_box', 'lh_quickedit_fields', 10, 2 );

// DEACTIVATED
function lh_quickedit_save_post( $post_id, $post ) {
  // if called by autosave, then bail here
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
    return;

  // does this user have permissions?
  if ( ! current_user_can( 'edit_post', $post_id ) )
    return;

  // update!
  if ( isset( $_POST['lh_internal_name'] ) ) {
    update_post_meta( $post_id, 'lh_internal_name', $_POST['lh_internal_name'] );
  }
}
// add_action( 'save_post', 'lh_quickedit_save_post', 10, 2 );

// DEACTIVATED
function lh_quickedit_javascript() {
//  $current_screen = get_current_screen();
  // Ensure jQuery library loads
  wp_enqueue_script( 'jquery' );
  ?>
  <script type="text/javascript">
        jQuery( function( $ ) {

            $( '#the-list' ).on( 'click', '.editinline', function( e ) {
                e.preventDefault();

                console.log('here');

                var internalName = $(this).closest('.iedit').find('.lh_internal_name').text();
                if(internalName !== '') {
                    $('.lh_internal_name' ).val(internalName);
                }
                inlineEditPost.revert();
            });
        });
  </script>
  <?php
}
// add_action( 'admin_print_footer_scripts-edit.php', 'lh_quickedit_javascript' );


function register_mobile_menu() {
    register_nav_menu( 'mobile', __( 'Mobile Menu', 'Divi' ) );
}
add_action( 'after_setup_theme', 'register_mobile_menu' );
