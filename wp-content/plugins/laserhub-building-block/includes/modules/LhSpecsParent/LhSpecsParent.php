<?php
/**
 * Parent module (module which has module item / child module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class Lh_Specs extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'Lh_specs';

	// Full Visual Builder support
	public $vb_support = 'on';

	// Module item's slug
	public $child_slug = 'lh_specs_child';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name                    = esc_html__( 'Laserhub Specs', 'dicm-divi-custom-modules' );

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


	function getElementsByClassName($elements, $className) {
		$matches = array();
		foreach($elements as $element) {
			if (!$element->hasAttribute('class')) {
				continue;
			}
			$classes = preg_split('/\s+/', $element->getAttribute('class'));
			if ( ! in_array($className, $classes)) {
				continue;
			}
			$matches[] = $element;
		}
		return $matches;
	}



	public function get_fields() {
		return array(
			'title' => array(
				'label'           => esc_html__( 'Specs section title', 'dicm-divi-custom-modules' ),
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

		$output = '<div class="lh-specs">';
		$output .= '<h3 class="lh-specs__title">' . $title . '</h3>';
		$output .= $content;
		$output .= '</div>';

		// Render wrapper
		// 3rd party module with no full VB support has to wrap its render output with $this->_render_module_wrapper().
		// This method will automatically add module attributes and proper structure for parallax image/video background
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new Lh_Specs;
