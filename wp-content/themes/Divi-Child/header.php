<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php
	elegant_description();
	elegant_keywords();
	elegant_canonical();

	/**
	 * Fires in the head, before {@see wp_head()} is called. This action can be used to
	 * insert elements into the beginning of the head before any styles or scripts.
	 *
	 * @since 1.0
	 */
	do_action( 'et_head_meta' );

	$template_directory_uri = get_template_directory_uri();
	?>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <script type="text/javascript">
        document.documentElement.className = 'js';
    </script>
    <link rel="stylesheet" type="text/css" href="/wp-content/themes/Divi-Child/fonts/tthoves.css"/>

	<?php wp_head();

        $internal_name = get_post_meta( get_the_ID(), 'lh_internal_name', true );

        if(!empty($internal_name)) {
            $page_name_for_analytics = $internal_name;
        } else {
            $post_type = get_post_type();
            $orig_id =  apply_filters( 'wpml_object_id', get_the_ID(), $post_type, TRUE, 'de');
            $page_name_for_analytics = get_the_title($orig_id);
        }

    
    ob_start();?>
    <script type="text/javascript">
                 !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
            analytics.load("7cp8b9jFwyvGTugGOYY4nyD6qCDvNN5Y");
            analytics.page("<?php echo $page_name_for_analytics; ?>");
        }}();
    </script>
    <?php echo ob_get_clean();?>

</head>
<body <?php body_class(); ?>>
<?php
$product_tour_enabled = et_builder_is_product_tour_enabled();
$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
<div id="page-container"<?php echo et_core_intentionally_unescaped( $page_container_style, 'fixed_string' ); ?>>
	<?php
	if ( $product_tour_enabled || is_page_template( 'page-template-blank.php' ) ) {
		return;
	}

	$et_secondary_nav_items = et_divi_get_top_nav_items();

	$et_phone_number = $et_secondary_nav_items->phone_number;

	$et_email = $et_secondary_nav_items->email;

	$et_contact_info_defined = $et_secondary_nav_items->contact_info_defined;

	$show_header_social_icons = $et_secondary_nav_items->show_header_social_icons;

	$et_secondary_nav = $et_secondary_nav_items->secondary_nav;

	$et_top_info_defined = $et_secondary_nav_items->top_info_defined;

	$et_slide_header = 'slide' === et_get_option( 'header_style', 'left' ) || 'fullscreen' === et_get_option( 'header_style', 'left' ) ? true : false;
	?>


	<?php if ( $et_slide_header || is_customize_preview() ) : ?>
		<?php ob_start(); ?>
        <div class="et_slide_in_menu_container">
			<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) || is_customize_preview() ) { ?>
                <span class="mobile_menu_bar et_toggle_fullscreen_menu"></span>
			<?php } ?>

			<?php
			if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
            <div class="et_slide_menu_top">

				<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
                <div class="et_pb_top_menu_inner">
					<?php } ?>
					<?php }

					if ( true === $show_header_social_icons ) {
						get_template_part( 'includes/social_icons', 'header' );
					}

					et_show_cart_total();
					?>
					<?php if ( false !== et_get_option( 'show_search_icon', true ) || is_customize_preview() ) : ?>
						<?php if ( 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) { ?>
                            <div class="clear"></div>
						<?php } ?>
                        <form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php
							printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
								esc_attr__( 'Search &hellip;', 'Divi' ),
								get_search_query(),
								esc_attr__( 'Search for:', 'Divi' )
							);
							?>
                            <button type="submit" id="searchsubmit_header"></button>
                        </form>
					<?php endif; // true === et_get_option( 'show_search_icon', false ) ?>

					<?php if ( $et_contact_info_defined ) : ?>

                        <div id="et-info">
							<?php if ( '' !== ( $et_phone_number = et_get_option( 'phone_number' ) ) ) : ?>
                                <span id="et-info-phone"><?php echo et_core_esc_previously( et_sanitize_html_input_text( $et_phone_number ) ); ?></span>
							<?php endif; ?>

							<?php if ( '' !== ( $et_email = et_get_option( 'header_email' ) ) ) : ?>
                                <a href="<?php echo esc_attr( 'mailto:' . $et_email ); ?>"><span id="et-info-email"><?php echo esc_html( $et_email ); ?></span></a>
							<?php endif; ?>
                        </div> <!-- #et-info -->

					<?php endif; // true === $et_contact_info_defined ?>
					<?php if ( $et_contact_info_defined || true === $show_header_social_icons || false !== et_get_option( 'show_search_icon', true ) || class_exists( 'woocommerce' ) || is_customize_preview() ) { ?>
					<?php if ( 'fullscreen' === et_get_option( 'header_style', 'left' ) ) { ?>
                </div> <!-- .et_pb_top_menu_inner -->
			<?php } ?>

            </div> <!-- .et_slide_menu_top -->
		<?php } ?>

            <div class="et_pb_fullscreen_nav_container">
				<?php
				$slide_nav = '';
				$slide_menu_class = 'et_mobile_menu et_mobile_menu---1';

				$slide_nav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
				$slide_nav .= wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'echo' => false, 'items_wrap' => '%3$s' ) );
				?>

                <ul id="mobile_menu_slide" class="<?php echo esc_attr( $slide_menu_class ); ?>">

					<?php
					if ( '' === $slide_nav ) :
						?>
						<?php if ( 'on' === et_get_option( 'divi_home_link' ) ) { ?>
                        <li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
					<?php }; ?>

						<?php show_page_menu( $slide_menu_class, false, false ); ?>
						<?php show_categories_menu( $slide_menu_class, false ); ?>
						<?php
					else :
						echo et_core_esc_wp( $slide_nav ) ;
					endif;
					?>

                </ul>
            </div>
        </div>
		<?php
		$slide_header = ob_get_clean();

		/**
		 * Filters the HTML output for the slide header.
		 *
		 * @since 3.10
		 *
		 * @param string $top_header
		 */
		echo et_core_intentionally_unescaped( apply_filters( 'et_html_slide_header', $slide_header ), 'html' );
		?>
	<?php endif; // true ==== $et_slide_header ?>


    <div class="header-wrap">
        <?php if($_COOKIE['band-closed'] != true && is_active_sidebar('top-banner')): ?>
            <div class="band">
                <div class="container">
                    <div class="band__content">

                        <?php
                        dynamic_sidebar( 'top-banner' );
                        ?>

                        <button class="js-band-close">&times;</button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php ob_start(); ?>

        <!-- actual header code for laserhub.com -->
        <header id="main-header" data-height-onload="<?php echo esc_attr( et_get_option( 'menu_height', '120' ) ); ?>">

            <div class="meta-menu">
                <div class="container">

                    <!-- display: flex; --> 
                    <div class="meta-menu__container">

                        <!-- menu -->
                         <?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => 'lh_custom_nav', 'menu_id' => 'lh_meta_menu') ); ?>

                        <!-- search --> 

                        <div class="meta-menu__search">
                               <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <?php
                                printf( '<input type="search" placeholder="%1$s" class="meta-menu-search" value="%2$s" name="s" title="%3$s" />',
                                    esc_attr__( 'Suchen&hellip;', 'Divi' ),
                                    get_search_query(),
                                    esc_attr__( 'Search for:', 'Divi' )
                                );
                                ?>
                                <button type="submit" class="meta-menu-search-submit">
                                    <span id="et_search_icon"></span>
                                </button>
                            </form>
                        </div>

                        <!-- newsletter -->

                        <!-- language selector --> 
                         <div class="meta-menu__wpml">
                            <?php do_action('wpml_add_language_selector'); ?>
                        </div>


                    </div>
                </div>
            </div>

            <div class="container clearfix et_menu_container">
                <?php
                $logo = ( $user_logo = et_get_option( 'divi_logo' ) ) && ! empty( $user_logo )
                    ? $user_logo
                    : $template_directory_uri . '/images/logo.png';

                ob_start();
                ?>
                <div class="logo_container">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <!-- user defined logo -->
                        <img src="https://staging-laserhubcom.kinsta.cloud/wp-content/uploads/2019/02/logo.svg" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                        <!-- small logo for breakpoints -->
                        <img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" id="logo_small" data-height-percentage="<?php echo esc_attr( et_get_option( 'logo_height', '54' ) ); ?>" />
                    </a>
                </div>
                <?php
                $logo_container = ob_get_clean();

                /**
                 * Filters the HTML output for the logo container.
                 *
                 * @since 3.10
                 *
                 * @param string $logo_container
                 */
                echo et_core_intentionally_unescaped( apply_filters( 'et_html_logo_container', $logo_container ), 'html' );
                ?>
                <div id="et-top-navigation" data-height="<?php echo esc_attr( et_get_option( 'menu_height', '66' ) ); ?>" data-fixed-height="<?php echo esc_attr( et_get_option( 'minimized_menu_height', '40' ) ); ?>">
                    <?php if ( ! $et_slide_header || is_customize_preview() ) : ?>
                        <nav id="top-menu-nav">
                            <?php
                            $menuClass = '';
                            if ( 'on' === et_get_option( 'divi_disable_toptier' ) ) $menuClass .= ' et_disable_top_tier';
                            $primaryNav = '';

                            $primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass . ' lh_custom_nav', 'menu_id' => 'lh_custom_top_menu', 'walker' => new WPSE_78121_Sublevel_Walker, 'echo' => false ) );

                            if ( empty( $primaryNav ) ) :
                                ?>
                                <ul id="top-menu" class="<?php echo esc_attr( $menuClass ); ?>">
                                    <?php if ( 'on' === et_get_option( 'divi_home_link' ) ) { ?>
                                        <li <?php if ( is_home() ) echo( 'class="current_page_item"' ); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'Divi' ); ?></a></li>
                                    <?php }; ?>

                                    <?php show_page_menu( $menuClass, false, false ); ?>
                                    <?php show_categories_menu( $menuClass, false ); ?>
                                </ul>
                                <?php
                            else :
                                echo et_core_esc_wp( $primaryNav );
                            endif;
                            ?>


                        </nav>
                    <?php endif; ?>

                    <?php
                    if ( ! $et_top_info_defined && ( ! $et_slide_header || is_customize_preview() ) ) {
                        et_show_cart_total( array(
                            'no_text' => true,
                        ) );
                    }
                    ?>

                    <?php
                    do_action( 'et_header_top' );
                     echo '<a class="et-top-navigation__cta" href="' . __('https://app.laserhub.com/register', 'Divi') . '" target="_blank">' . __('Angebot einholen', 'Divi') . '</a>';

                    ?>
                    <span class="mobile_menu_bar"></span>
                </div> <!-- #et-top-navigation -->
            </div> <!-- .container -->


            <!-- this is mobile menu --> 
            <div id="lh_mobile_nav_menu" data-scroll-lock-scrollable>

                    <!-- primary menu -->

		        <?php
		        $mobileNav = wp_nav_menu( array( 'theme_location' => 'primary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass . ' lh_custom_mobile_nav', 'menu_id' => 'lh_custom_mobile_menu', 'walker' => new WPSE_78121_Sublevel_Walker, 'echo' => false ) );
		        echo et_core_esc_wp( $mobileNav ); ?>


                <!-- secondary  menu -->
                 <?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'container' => '', 'fallback_cb' => '', 'menu_class' => 'lh_custom_mobile_nav', 'menu_id' => 'lh_custom_mobile_menu') ); ?>

                <!-- search --> 

                <div class="meta-menu__search">
                       <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        printf( '<input type="search" placeholder="%1$s" class="meta-menu-search" value="%2$s" name="s" title="%3$s" />',
                            esc_attr__( 'Suchen&hellip;', 'Divi' ),
                            get_search_query(),
                            esc_attr__( 'Search for:', 'Divi' )
                        );
                        ?>
                        <button type="submit" class="meta-menu-search-submit">
                            <span id="et_search_icon"></span>
                        </button>
                    </form>
                </div>
            <?php do_action('wpml_add_language_selector'); ?>

            </div>

            <div class="et_search_outer">
                <div class="container et_search_form_container">
                    <form role="search" method="get" class="et-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php
                        printf( '<input type="search" class="et-search-field" placeholder="%1$s" value="%2$s" name="s" title="%3$s" />',
                            esc_attr__( 'Search &hellip;', 'Divi' ),
                            get_search_query(),
                            esc_attr__( 'Search for:', 'Divi' )
                        );
                        ?>
                    </form>
                    <span class="et_close_search_field"></span>
                </div>
            </div>
        </header> <!-- #main-header -->
        <?php
        $main_header = ob_get_clean();

        /**
         * Filters the HTML output for the main header.
         *
         * @since 3.10
         *
         * @param string $main_header
         */
        echo et_core_intentionally_unescaped( apply_filters( 'et_html_main_header', $main_header ), 'html' );
        ?>
        </div>
    <div id="et-main-area">
<?php
/**
 * Fires after the header, before the main content is output.
 *
 * @since 3.10
 */
do_action( 'et_before_main_content' );
