<?php
/**
 * Parent module (module which has module item / child module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class LH_Link_List extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'lh_link_list';

	// Full Visual Builder support
	public $vb_support = 'on';

	// Module item's slug
	public $child_slug = 'lh_link_list_child';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name                    = esc_html__( 'Laserhub Link List', 'dicm-divi-custom-modules' );

		// Module Icon
		// Load customized svg icon and use it on builder as module icon. If you don't have svg icon, you can use
		// $this->icon for using etbuilder font-icon. (See CustomCta / DICM_CTA class)
		$this->icon_path               =  plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'List options', 'dicm-divi-custom-modules' ),
				),
			),
		);
	}

	public function get_fields() {
		return array(
				'new_tab' => array(
					'label'           => esc_html__( 'Open links in new tab', 'lhrg-my-extension' ),
					'type'            => 'yes_no_button',
					'options' => array (
						'on' => 'yes',
						'off' => 'no',
					),
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Layout type'),
					'toggle_slug'     => 'main_content',
				),
		);
	}




	// Remove other fields like background
	protected function _add_additional_fields() {

	}


	/**
	 * Render module output
	 */
	function render( $attrs, $content = null, $render_slug ) {



		// renders all children
		$link_list_content = $this->props['content'];
		$new_tab = $this->props['new_tab'];

		// Render module content
		$output = '<ul class="lh-link-list">' . $link_list_content . '</ul>';

		if($new_tab == 'yes') {
			$output = str_replace('<a', '<a target="_blank" ', $output);
		}

		// Render wrapper
		// 3rd party module with no full VB support has to wrap its render output with $this->_render_module_wrapper().
		// This method will automatically add module attributes and proper structure for parallax image/video background
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new LH_Link_List;
