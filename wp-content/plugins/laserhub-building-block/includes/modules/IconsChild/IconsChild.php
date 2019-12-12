<?php
/**
 * Child module / module item (module which appears inside parent module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class LH_Icons_Child extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug                     = 'lh_icons_child';

	// Module item has to use `child` as its type property
	public $type                     = 'child';

	// Module item's attribute that will be used for module item label on modal
	public $child_title_var          = 'title';

	// If the attribute defined on $this->child_title_var is empty, this attribute will be used instead
	public $child_title_fallback_var = 'subtitle';

	// Full Visual Builder support
	public $vb_support = 'on';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 *
	 * @todo Remove $this->advanced_options['background'] once https://github.com/elegantthemes/Divi/issues/6913 has been addressed
	 */
	function init() {
		// Module name
		$this->name             = esc_html__( 'Icon Child', 'dicm-divi-custom-modules' );

		// Default label for module item. Basically if $this->child_title_var and $this->child_title_fallback_var
		// attributes are empty, this default text will be used instead as item label
		$this->advanced_setting_title_text = esc_html__( 'Icon', 'et_builder' );

		// Module item's modal title
		$this->settings_text = esc_html__( 'Icon settings', 'et_builder' );

		// Toggle settings
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Icon', 'dicm-divi-custom-modules' ),
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

	public function get_fields() {
		return array(
			'image'=> array(
				'label'              => esc_html__( 'Image'),
				'type'               => 'upload',
				'option_category' => 'basic_option',
				'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
				'toggle_slug'        => 'main_content',
			),
			'title' => array(
				'label'           => esc_html__( 'Title', 'dicm-divi-custom-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'subtitle' => array(
				'label' => esc_html__( 'Subtitle', 'module-slug' ),
				'type' => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content'
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {

		$title = $this->props['title'];
		$subtitle = $this->props['subtitle'];
		$image  =  $this->props['image'];

		ob_start(); ?>

        <div class="lh-icons__item">
            <img class="lh-icons__image" src="<?php echo $image; ?>" />
            <h3 class="lh-icons__title"><?php echo $title; ?></h3>
			<?php
			// subtitle is optional
			if (!empty($subtitle)) { ?>
                <p class="lh-icons__subtitle"><?php echo $subtitle; ?></p>
			<?php }
			?>
        </div>

		<?php return ob_get_clean();
	}
}

new LH_Icons_Child;
