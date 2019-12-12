<?php
/**
 * Parent module (module which has module item / child module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class Lh_Accordion extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'lh_accordion';

	// Full Visual Builder support
	public $vb_support = 'on';

	// Module item's slug
	public $child_slug = 'lh_accordion_child';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name                    = esc_html__( 'Laserhub Accordion (FAQ)', 'dicm-divi-custom-modules' );

		// Module Icon
		// Load customized svg icon and use it on builder as module icon. If you don't have svg icon, you can use
		// $this->icon for using etbuilder font-icon. (See CustomCta / DICM_CTA class)
		$this->icon_path               =  plugin_dir_path( __FILE__ ) . 'icon.svg';

		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Spec item', 'dicm-divi-custom-modules' ),
				),
			),
		);
	}



	public function get_fields() {
		return array(
			'title' => array(
				'label'           => esc_html__( 'Accordion section title', 'dicm-divi-custom-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
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
		$content = $this->props['content'];
		$title = $this->props['title'];

		$output = '<div class="lh-accordion">';
		$output .= !empty($title) ? '<h3>' . $title . '</h3>' : '';
		$output .= $content;
		$output .= '</div>';

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new Lh_Accordion;
