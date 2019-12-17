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
	wp_enqueue_script( 'child-js', get_stylesheet_directory_uri() . '/js/child.js' ,'' , 1.6);
	wp_localize_script( 'child-js', 'lhtranslation', array(
	        'material_expand' => __('Alle anzeigen', 'Divi')
    ) );

}
add_action( 'wp_enqueue_scripts', 'divichild_enqueue_scripts' );

// deregister divi style
function wp_67472455() {
   wp_dequeue_style( 'divi-style' );
   wp_deregister_style( 'divi-style' );
}
add_action( 'wp_enqueue_scripts', 'wp_67472455', 1000 );



function my_theme_enqueue_styles() {
 
    $parent_style = 'laserhub-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        1.74
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


/*** Add descriptions to the menu  ***/
function prefix_nav_description( $item_output, $item, $depth, $args ) {
	if ( !empty( $item->description ) ) {
        $item_output = '<div class="menu-item-wrap">' . $item_output . '<div class="menu-item-description">' . $item->description . '</div></div>';
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'prefix_nav_description', 10, 4 );


class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
{
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<div class='lh-sub-menu-wrap'><ul class='lh-sub-menu'>\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}
}

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

/* Segmnet code */
function lh_add_segment_code() {
	ob_start(); ?>

	<script type="text/javascript">
        !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
            analytics.load("7cp8b9jFwyvGTugGOYY4nyD6qCDvNN5Y");
            analytics.page();
        }}();
	</script>

<?php echo ob_get_clean();
}
//add_action('wp_head', 'lh_add_segment_code');



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
//	$current_screen = get_current_screen();
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

