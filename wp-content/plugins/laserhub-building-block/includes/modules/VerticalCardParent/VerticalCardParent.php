<?php
/**
 * Parent module (module which has module item / child module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class LH_Vertical_Card extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'lh_vertical_cards';

	// Full Visual Builder support
	public $vb_support = 'on';

	// Module item's slug
	public $child_slug = 'lh_vertical_cards_child';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name                    = esc_html__( 'Laserhub Vertical Cards', 'dicm-divi-custom-modules' );

		// Module Icon
		// Load customized svg icon and use it on builder as module icon. If you don't have svg icon, you can use
		// $this->icon for using etbuilder font-icon. (See CustomCta / DICM_CTA class)
		$this->icon_path               =  plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Columns'),
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
		return array(
			'columns' => array(
				'label'           => esc_html__( 'Columns amount'),
				'type'            => 'select',
				'options'         => array(
//					'1' => esc_html__( '1', 'dicm-divi-custom-modules' ),
//					'2'  => esc_html__( '2', 'dicm-divi-custom-modules' ),
					'3'  => esc_html__( '3', 'dicm-divi-custom-modules' ),
					'4'  => esc_html__( '4', 'dicm-divi-custom-modules' ),
					'5'  => esc_html__( '5', 'dicm-divi-custom-modules' ),
				),
				'toggle_slug'     => 'main_content',
				'description'     => esc_html__( 'How many columns'),
			),
			'ratio' => array(
				'label'           => esc_html__( 'Image ratio'),
				'type'            => 'select',
				'options'         => array(
					'4-3' => esc_html__( '4:3 (crop)', 'dicm-divi-custom-modules' ),
					'16-9'  => esc_html__( '16:9 (crop)', 'dicm-divi-custom-modules' ),
					'long'  => esc_html__( 'Long (no crop)', 'dicm-divi-custom-modules' ),
				),
				'toggle_slug'     => 'main_content',
			),
		);
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
		// Module specific props added on $this->get_fields()
		$columns = !empty($this->props['columns']) ? $this->props['columns'] : 3;
		$ratio = $this->props['ratio'];
		$content = $this->props['content'];

		// Render module content
		$output = sprintf(
			'<div class="lh-cards-container lh-cards-container--'. $columns . ' lh-cards-container--'. $ratio . '">%1$s</div>',
			 $content
		);

		// Render wrapper
		// 3rd party module with no full VB support has to wrap its render output with $this->_render_module_wrapper().
		// This method will automatically add module attributes and proper structure for parallax image/video background
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new LH_Vertical_Card;
