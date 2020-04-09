<?php
/**
 * Child module / module item (module which appears inside parent module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class Lh_Vert_Card_Child extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug                     = 'lh_vertical_cards_child';

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
		$this->name             = esc_html__( 'Vertical Card', 'dicm-divi-custom-modules' );

		// Default label for module item. Basically if $this->child_title_var and $this->child_title_fallback_var
		// attributes are empty, this default text will be used instead as item label
		$this->advanced_setting_title_text = esc_html__( 'Vertical card', 'et_builder' );

		// Module item's modal title
		$this->settings_text = esc_html__( 'Vertical card settings', 'et_builder' );

		// Toggle settings
		$this->settings_modal_toggles  = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Card', 'dicm-divi-custom-modules' ),
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
			'content' => array(
				'label'           => esc_html__( 'Content', 'dicm-divi-custom-modules' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'link' => array(
				'label' => esc_html__( 'More link (with #section if needed)', 'module-slug' ),
				'type' => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content'
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {

		$image = $this->props['image'];
		$content = $this->props['content'];
		$link  =  $this->props['link'];

		$class = empty($link) ? 'lh-card--no-link' : '';

		ob_start(); ?>

        <div class="lh-card lh-card--vertical <?php echo $class; ?>">
            <div class="lh-card__media">
                <?php $id = attachment_url_to_postid($image);
                echo wp_get_attachment_image($id, 'large');
                ?>
            </div>

            <div class="lh-card__content">
                <div class="lh-card__text">
					<?php echo $content; ?>
                </div>

                <?php if(!empty($link)) { 
                	echo '<a href="' . $link . '" class="lh-card__more">' .  __( 'Mehr', 'Divi' ) . '</a>';		
              	 } ?>
            </div>


        </div>

		<?php return ob_get_clean();
	}
}

new Lh_Vert_Card_Child;
