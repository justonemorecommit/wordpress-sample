<?php

// Add custom field & quickedit field

/* Set metabox for the lh_internal_name */
add_action( 'add_meta_boxes', 'add_analytics_metaboxes' );

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

function lh_internal_name_callback() {
  global $post;
  // Nonce field to validate form request came from current site
  wp_nonce_field( basename( __FILE__ ), 'lh_internal_name_field' );
  // Get the location data if it's already been entered
  $internal_name = get_post_meta( $post->ID, 'lh_internal_name', true );
  // Output the field
  echo '<input type="text" name="lh_internal_name" value="' . esc_textarea( $internal_name )  . '" class="widefat">';
}


/*** Add to quick edit fields ***/
function lh_quickedit_custom_posts_columns( $posts_columns ) {
  $posts_columns['lh_internal_name'] = __( 'Analytics name', 'generatewp' );
  return $posts_columns;
}
add_filter( 'manage_post_posts_columns', 'lh_quickedit_custom_posts_columns' );

function lh_quickedit_custom_pages_columns( $posts_columns ) {
  $posts_columns['lh_internal_name'] = __( 'Analytics name', 'generatewp' );
  return $posts_columns;
}
add_filter( 'manage_pages_columns', 'lh_quickedit_custom_pages_columns' );


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
add_action( 'manage_post_posts_custom_column', 'lh_quickedit_custom_column_display', 10, 2 );

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
add_action( 'manage_pages_custom_column', 'lh_quickedit_custom_column_display_', 10, 2 );




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
add_action( 'quick_edit_custom_box', 'lh_quickedit_fields', 10, 2 );

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
add_action( 'save_post', 'lh_quickedit_save_post', 10, 2 );


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
add_action( 'admin_print_footer_scripts-edit.php', 'lh_quickedit_javascript' );
