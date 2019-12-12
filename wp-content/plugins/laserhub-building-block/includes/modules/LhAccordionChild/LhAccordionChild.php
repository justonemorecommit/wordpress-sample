<?php
/**
 * Child module / module item (module which appears inside parent module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class Lh_Accordion_Child extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug                     = 'lh_accordion_child';

	// Module item has to use `child` as its type property
	public $type                     = 'child';

	// Module item's attribute that will be used for module item label on modal
	public $child_title_var          = 'title';

	// If the attribute defined on $this->child_title_var is empty, this attribute will be used instead
	public $child_title_fallback_var = 'content';

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
		$this->name             = esc_html__( 'Accordion item', 'dicm-divi-custom-modules' );

		// Default label for module item. Basically if $this->child_title_var and $this->child_title_fallback_var
		// attributes are empty, this default text will be used instead as item label
		$this->advanced_setting_title_text = esc_html__( 'Item', 'et_builder' );

		// Module item's modal title
		$this->settings_text = esc_html__( 'Icon settings', 'et_builder' );

		// Toggle settings
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Accordion item', 'dicm-divi-custom-modules' ),
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
			'title' => array(
				'label'           => esc_html__( 'Title', 'dicm-divi-custom-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'content' => array(
				'label' => esc_html__( 'Content', 'module-slug' ),
				'type' => 'tiny_mce',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content'
			)
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$title = $this->props['title'];
		$content = $this->props['content'];
		ob_start(); ?>
            <div class="lh-accordion__item js-lh-accordion__item">
                <div class="lh-accordion__title">
                    <button aria-expanded="false">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/expand_arrow.svg"
                        <h3><?php echo $title; ?></h3>
                    </button>
                </div>
                <div class="lh-accordion__content">
                    <?php echo $content; ?>
                </div>
            </div>
		<?php return ob_get_clean();
	}
}

new Lh_Accordion_Child;
