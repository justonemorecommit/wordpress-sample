<?php
/**
 * Fires after the main content, before the footer is output.
 *
 * @since 3.10
 */

do_action( 'et_after_main_content' );

if ( 'on' === et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">


				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">

                        <div class="footer-social">
                            <ul class="footer-social__list">
                                <li><a target="_blank" href="<?php _e('https://de.linkedin.com/company/laserhub-gmbh', 'Divi'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/social/linkedin.svg"></a></li>
                                <li><a target="_blank" href="<?php _e('https://www.xing.com/companies/laserhubgmbh', 'Divi'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/social/xing.svg"></a></li>
                                <li><a target="_blank" href="<?php _e('https://de-de.facebook.com/laserhub.de/', 'Divi'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/social/facebook.svg"></a></li>
                                <li><a target="_blank" href="<?php _e('https://www.instagram.com/laserhub_com/', 'Divi'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/social/instagram.svg"></a></li>
                                <li><a target="_blank" href="<?php _e('https://twitter.com/laserhub_gmbh', 'Divi'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/social/twitter.svg"></a></li>
                            </ul>
                        </div>

						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>


                        <div class="footer-badges">
                            <div class="footer-badges__content">
                                <div class="footer-badges__list">
	                                <?php dynamic_sidebar( 'footer-badges' ); ?>
                                </div>
                            </div>
                        </div>
					</div>


				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
				<?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						get_template_part( 'includes/social_icons', 'footer' );
					}

					// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
					echo et_core_fix_unclosed_html_tags( et_core_esc_previously( et_get_footer_credits() ) );
					// phpcs:enable
				?>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
</body>
</html>
