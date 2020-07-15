<?php
/**
 * Child module / module item (module which appears inside parent module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class LH_Link_List_Child extends ET_Builder_Module {
  // Module slug (also used as shortcode tag)
  public $slug                     = 'lh_link_list_child';

  // Module item has to use `child` as its type property
  public $type                     = 'child';

  // Module item's attribute that will be used for module item label on modal
  public $child_title_var          = 'label';

  // If the attribute defined on $this->child_title_var is empty, this attribute will be used instead
  public $child_title_fallback_var = 'link';

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
    $this->name             = esc_html__( 'Link', 'dicm-divi-custom-modules' );

    // // Default label for module item. Basically if $this->child_title_var and $this->child_title_fallback_var
    // // attributes are empty, this default text will be used instead as item label
    // $this->advanced_setting_title_text = esc_html__( 'Link', 'et_builder' );

    // // Module item's modal title
    // $this->settings_text = esc_html__( 'List Link Settings', 'et_builder' );

    // // Toggle settings
    // $this->settings_modal_toggles  = array(
    //  'general'  => array(
    //    'toggles' => array(
    //      'main_content' => esc_html__( 'Line', 'dicm-divi-custom-modules' ),
    //    ),
    //  ),
    // );
  }



  // Remove other fields
  protected function _add_additional_fields() {
  }

  /**
   * Module's specific fields
   */

  public function get_fields() {
    return array(
      'label' => array(
        'label'           => esc_html__( 'Label', 'dicm-divi-custom-modules' ),
        'type'            => 'text',
        'option_category' => 'basic_option',
        'toggle_slug'     => 'main_content',
      ),
      'content' => array(
        'label'           => esc_html__( 'Content', 'dicm-divi-custom-modules' ),
        'type'            => 'text',
        'option_category' => 'basic_option',
        'toggle_slug'     => 'main_content',
      ),
      'link' => array(
        'label' => esc_html__( 'Link', 'module-slug' ),
        'type' => 'text',
        'option_category' => 'basic_option',
        'toggle_slug'     => 'main_content'
      ),
      'image'=> array(
        'label'              => esc_html__( 'Image'),
        'type'               => 'upload',
        'option_category' => 'basic_option',
        'upload_button_text' => esc_attr__( 'Upload an image', 'et_builder' ),
        'choose_text'        => esc_attr__( 'Choose an Image', 'et_builder' ),
        'update_text'        => esc_attr__( 'Set As Image', 'et_builder' ),
        'toggle_slug'        => 'main_content',
      ),
    );
  }

  public function render( $unprocessed_props, $content = null, $render_slug ) {
    ob_start();
    ?>

    <a class="lh-link-list-item" href="<?= $this->props['link'] ?>">
      <!-- img -->
      <?php if($this->props['image']) {?>
        <img src="<?= $this->props['image'] ?>" alt="">
      <?php } ?>

      <!-- content -->
      <p><?= $this->props['label'] ?: $this->props['content'] ?></p>
    </a>

    <?php
    return ob_get_clean();
  }
}

new LH_Link_List_Child;
