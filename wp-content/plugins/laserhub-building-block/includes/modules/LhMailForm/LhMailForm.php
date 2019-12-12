<?php

class LH_MailForm extends ET_Builder_Module {

	public $slug       = 'lh_mail_form';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => '',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__( 'Laserhub Mail Form', 'lhrg' );
	}

	public function get_settings_modal_toggles() {
		return array(
			'advanced' => array(
				'toggles' => array(
					'lh-rg-layout' => array(
						'priority' => 24,
						'title' => 'Form settings',
					),
				),
			),
		);
	}


	public function get_fields() {
		return array(
			'head_text' => array(
				'label' => esc_html__( 'Heading text', 'module-slug' ),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__( 'Heading text' ),
				'toggle_slug' => 'lh-rg-layout',
			),
			'button_text' => array(
				'label' => esc_html__( 'Button text', 'nemo-new-module' ),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__( 'Button text', 'nemo-new-module' ),
				'toggle_slug' => 'lh-rg-layout',
			),
			'layout' => array(
				'label'           => esc_html__( 'Layout', 'lhrg-my-extension' ),
				'type'            => 'yes_no_button',
				'options' => array (
					'off' => 'Horizontal',
					'on' => 'Vertical',
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Layout type'),
				'toggle_slug'     => 'lh-rg-layout',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		$layout_class = $this->props['layout'] === 'on' ? 'lh-reg-form--vertical' : 'lh-reg-form--horizontal';
		$head_text = !empty($this->props['head_text']) ? wp_kses_post($this->props['head_text']) : '<h2>Registration</h2>';
		$button_text =  !empty($this->props['button_text']) ? wp_kses_post($this->props['button_text']) : 'Register';

		return '<div class="et_pb_contact lh-reg-form lh-reg-form lh-reg-form--vertical lh-mail-form">
					<form class="et_pb_contact_form clearfix" method="post" action="admin-post.php">

					 <input type="hidden" name="action" value="lh-send-email" />
					
					<div class="lh-reg-form__heading">' . $head_text . '</div>
							
					<div class="lg-reg-form__fields">
						<div class="lg-reg-form__inputs">
							<!-- name -->
							<p class="et_pb_contact_field" data-id="name" data-type="input">
								 <input type="text" name="user[companyNameConcrete]" id="companyNameConcrete" class="form-control">
				                 <input type="text" class="input" name="email" id="email" placeholder="Email*" value="" required="required">
				            </p>
				            
				            <!-- privacy --> 
				            <div class="et_pb_contact_field consentDescription">
		                           <input type="checkbox" value="0" id="privacyAcceptance" name="privacyAcceptance" required="required">
		                            <label for="privacyAcceptance">Ich bin <strong>Geschäftskunde </strong>und willige in die<strong> Erhebung,
		                            Verarbeitung und Nutzung</strong> meiner <strong>personenbezogenen Daten </strong> ein (<a href="/datenschutz" target="_blank">Datenschutzerklärung</a>)
		                            </label>
		                    </div>
	                    </div>
	                    
	                     <!-- submit -->
						<div class="et_pb_contact_field et_pb_contact_field--submit">
							<button type="submit" class="">' . $button_text .'</button>
		                     <!-- <div class="et_pb_contact_field--submit__desc">
		                        <span>Sie haben bereits ein Konto?</span>
		                        <a href="/calc?lang=de" class="text-underline"><u>Jetzt einloggen</u></a>
		                    </div> -->
						</div>
                    </div>
			            
			           
					</form>
				</div>';
	}

}

new LH_MailForm;
