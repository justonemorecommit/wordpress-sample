<?php
/**
 * Basic Call To Action module (title, content, and button) with PARTIAL builder support
 * This module appears on Visual Builder but requires longer time to be rendered because the UI is rendered via AJAX
 * Due to partial builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class DICM_Lh_Image extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'DICM_Lh_Image_block';

	// Visual Builder support (off|partial|on)
	public $vb_support = 'on';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name             = esc_html__( 'Laserhub Image', 'dicm-divi-custom-modules' );

		// Module Icon
		// This character will be rendered using etbuilder font-icon. For fully customized icon, create svg icon and
		// define its path on $this->icon_path property (see CustomCTAFull / DICM_CTA_Has_VB_Support)
		$this->icon             = 'g';

		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Image(s)'),
				),
			),
		);
	}

	/**
	 * Module's specific fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function get_fields() {

		$image_fields = [];

		foreach(range(1,2) as $i) {
			$image_fields['image_' . $i] = array(
				'label'              => esc_html__( 'Image #' . $i),
				'type'               => 'upload',
				'option_category' => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'        => 'main_content',
			);
		}

		return $image_fields;
	}

	protected function _add_additional_fields() {

	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attrs       List of unprocessed attributes
	 * @param string $content     Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 */
	function render( $attrs, $content = null, $render_slug ) {

		$images = [];

		foreach(range(1,2) as $i) {

			$image = $this->props['image_' . $i];
			$id = attachment_url_to_postid($image);
			$image_alt = get_post_meta($id, '_wp_attachment_image_alt', TRUE);

			if(!empty($image)) {
				$images[$i] = array(
					'image' => $image,
					'alt' => $image_alt
				);
			}
		}

		// Render module content
		ob_start();
		$icons_length = count($images);
		?>


        <div class="lh-images">
            <div class="lh-images__content xlh-images--slanted lh-images--<?php echo $icons_length; ?>">
            <?php foreach ($images as $image) { ?>
                <div class="lh-images__item lh-images__item ">
                    <img class="lh-image lh-images__image" src="<?php echo $image['image'];?>" alt="<?php echo $image['alt'];?>" />
                </div>
            <?php } ?>
            </div>
        </div>

<?php $output = ob_get_clean();

		// Render wrapper
		// 3rd party module with no full VB support has to wrap its render output with $this->_render_module_wrapper().
		// This method will automatically add module attributes and proper structure for parallax image/video background
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new DICM_Lh_Image;
