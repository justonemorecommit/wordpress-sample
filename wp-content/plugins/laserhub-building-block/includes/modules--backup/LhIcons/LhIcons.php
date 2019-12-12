<?php
/**
 * Basic Call To Action module (title, content, and button) with PARTIAL builder support
 * This module appears on Visual Builder but requires longer time to be rendered because the UI is rendered via AJAX
 * Due to partial builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class DICM_Lh_Icons extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'dicm_lh_icons_block';

	// Visual Builder support (off|partial|on)
	public $vb_support = 'on';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name             = esc_html__( 'Laserhub Icons', 'dicm-divi-custom-modules' );

		// Module Icon
		// This character will be rendered using etbuilder font-icon. For fully customized icon, create svg icon and
		// define its path on $this->icon_path property (see CustomCTAFull / DICM_CTA_Has_VB_Support)
		$this->icon             = 'g';

		// Toggle settings
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Icons (min 3, max 6)'),
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

		$icon_fields = [];

		foreach(range(1,6) as $i) {

			$icon_fields['icon_' . $i . '_title'] = array(
				'label'           => esc_html__( 'Icon #' . $i . '  title', 'dicm-divi-custom-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			);

			$icon_fields['icon_' . $i . '_subtitle'] = array(
				'label'           => esc_html__( 'Icon #' . $i . '  subtitle (optional)', 'dicm-divi-custom-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			);

			$icon_fields['icon_' . $i . '_image'] = array(
				'label'              => esc_html__( 'Icon #' . $i . '  image', 'dicm-divi-custom-modules' ),
				'type'               => 'upload',
				'option_category' => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'        => 'main_content',
			);
		}

		return $icon_fields;
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

		$icons = [];

		foreach(range(1,6) as $i) {

			$title = $this->props['icon_' . $i . '_title'];
			$image = $this->props['icon_' . $i . '_image'];

			if(!empty($title) && !empty($image)) {
				$icons[$i] = array(
					'title' => $this->props['icon_' . $i . '_title'],
					'subtitle' => $this->props['icon_' . $i . '_subtitle'],
					'image' => $this->props['icon_' . $i . '_image'],
				);
			}
		}

		// Render module content
		ob_start();
		$icons_length = count($icons);
		?>


		<div class="lh-icons lh-icons--<?php echo $icons_length; ?>">
	    <?php foreach ($icons as $icon) { ?>
		    <div class="lh-icons__item">
			    <img class="lh-icons__image" src="<?php echo $icon['image'];?>" />
			    <h4 class="lh-icons__title"><?php echo $icon['title']; ?></h4>
                <?php
                    // subtitle is optional
                    if (!empty( $icon['subtitle'])) { ?>
                        <p class="lh-icons__subtitle"><?php echo $icon['subtitle']; ?></p>
                    <?php }
                ?>
		    </div>
		<?php } ?>
		</div>

<?php $output = ob_get_clean();

		// Render wrapper
		// 3rd party module with no full VB support has to wrap its render output with $this->_render_module_wrapper().
		// This method will automatically add module attributes and proper structure for parallax image/video background
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new DICM_Lh_Icons;
