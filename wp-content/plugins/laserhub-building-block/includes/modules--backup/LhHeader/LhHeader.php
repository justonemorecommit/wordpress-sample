<?php
/**
 * Basic Call To Action module (title, content, and button) with PARTIAL builder support
 * This module appears on Visual Builder but requires longer time to be rendered because the UI is rendered via AJAX
 * Due to partial builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class DICM_Lh_Header extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'DICM_Lh_Header_block';

	// Visual Builder support (off|partial|on)
	public $vb_support = 'on';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	function init() {
		// Module name
		$this->name             = esc_html__( 'Laserhub Header', 'dicm-divi-custom-modules' );

		// Module Icon
		// This character will be rendered using etbuilder font-icon. For fully customized icon, create svg icon and
		// define its path on $this->icon_path property (see CustomCTAFull / DICM_CTA_Has_VB_Support)
		$this->icon             = 'g';

		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Header'),
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
				'layout' => array(
					'label'           => esc_html__( 'Fullscreen layout', 'lhrg-my-extension' ),
					'type'            => 'yes_no_button',
					'options' => array (
						'hero' => 'Hero (fullscreen)',
						'plain' => 'Plain',
					),
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Layout type'),
					'toggle_slug'     => 'main_content',
				),
				'title' => array(
					'label'           => esc_html__( 'Title', 'dicm-divi-custom-modules' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Text entered here will appear as title.', 'dicm-divi-custom-modules' ),
					'toggle_slug'     => 'main_content',
				),
				'subtitle' => array(
					'label'           => esc_html__( 'Subtitle', 'dicm-divi-custom-modules' ),
					'type'            => 'text',
					'option_category' => 'basic_option',
					'description'     => esc_html__( 'Text entered here will appear as title.', 'dicm-divi-custom-modules' ),
					'toggle_slug'     => 'main_content',
				),
				'background'=> array(
					'label'              => esc_html__( 'Background'),
					'type'               => 'upload',
					'option_category' => 'basic_option',
					'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
					'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
					'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
					'toggle_slug'        => 'main_content',
				)
                //type???
            );
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


		$layout = $this->props['layout'];
		$title = $this->props['title'];
		$subtitle = $this->props['subtitle'];
		$image = $this->props['background'];

		// Render module content
		ob_start();
		?>

		<header class="page-header page-header <?php echo $layout; ?>">
			<div class="page-header__background-wrap">
				<img class="page-header__background" src="<?php echo $image;?>">
			</div>
			<h1 class="page-header__title"><?php echo $title; ?></h1>
			<?php if(!empty($subtitle)) {
				echo '<p class="page-header__subtitle">' . $subtitle . '</p>';
			}?>
		</header>

<?php $output = ob_get_clean();

		// Render wrapper
		// 3rd party module with no full VB support has to wrap its render output with $this->_render_module_wrapper().
		// This method will automatically add module attributes and proper structure for parallax image/video background
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new DICM_Lh_Header;
