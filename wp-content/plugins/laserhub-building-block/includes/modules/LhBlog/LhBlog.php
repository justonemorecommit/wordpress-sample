<?php
/**
 * Basic Call To Action module (title, content, and button) with PARTIAL builder support
 * This module appears on Visual Builder but requires longer time to be rendered because the UI is rendered via AJAX
 * Due to partial builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class Lh_Blog extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'lh_blog';

	// Visual Builder support (off|partial|on)
	public $vb_support = 'on';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name             = esc_html__( 'Lasehub Blog');

		// Module Icon
		// This character will be rendered using etbuilder font-icon. For fully customized icon, create svg icon and
		// define its path on $this->icon_path property (see CustomCTAFull / DICM_CTA_Has_VB_Support)
		$this->icon             = 'g';

		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Categories'),
				),
			),
		);
	}

	function get_fields() {
			return array(
				'category' => array(
					'label'           => esc_html__( 'Categories', 'dicm-divi-custom-modules' ),
					'type'            => 'categories',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Text entered here will appear as title.', 'dicm-divi-custom-modules' ),
					'toggle_slug'     => 'main_content',
				),
            );
	}


	function render( $attrs, $content = null, $render_slug ) {
		ob_start(); ?>
        <div class="et_pb_module et_pb_blog_1 et_pb_posts">
		<div class="et_pb_ajax_pagination_container">

            <?php

            	$category = $this->props['category'];
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            	if(empty($category)) {
            		// all = no category is selected	
       				 $query = new WP_Query(array('posts_per_page' => '5', 'paged' => $paged)); 
            		
            	} else {
            		// single category selected
            		// two or more selected
            		 $query = new WP_Query(array('posts_per_page' => '5', 'paged' => $paged, 'cat' => $category)); 
            	} ?>


            <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();

                    $post_format = et_pb_post_format(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

					<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];
					?>
                    <a href="<?php echo get_permalink(); ?>" class="et_bp_image_url"><?php

                        if(!empty($thumb)) {
	                        echo '<img src="' . $thumb . '">';
                        } else
                            echo '<div class="et_bp_image_url__placeholder"></div>';
                         ?>
                    </a>

					<?php et_divi_post_format_content();


                    echo '<div class="et_pb_post__content">';
                         if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
                            <?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php endif; ?>

                             <p>
                            <?php
                            if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
                                truncate_post( 270 );
                            } else {
                                the_content();
                            } ?>
                             </p>

	                         <?php echo '<p class="post-meta">';
	                         echo '<span class="published">' . esc_html( get_the_time( 'M j, Y' )) . '</span>';
	                         echo '</p>';
                            ?>


                        <?php endif; ?>
                        <?php echo '</div>';?>

				</article> <!-- .et_pb_post -->

            <?php endwhile; ?>

            <div class="pagination clearfix">
                <div class="alignright"><?php next_posts_link(esc_html__('Older entries ›', 'lh-divi-child'), $query->max_num_pages); ?></div>
                <div class="alignleft"><?php previous_posts_link(esc_html__('‹ Newer entries', 'lh-divi-child')); ?></div>
            </div>

        </div>

     </div>

		<?php endif; ?>
		<?php return ob_get_clean();
	}
}

new Lh_Blog;
