<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
    <?php
        if ( et_builder_is_product_tour_enabled() ):
            // load fullwidth page in Product Tour mode
            while ( have_posts() ): the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
                    <div class="entry-content">
                    <?php
                        the_content();
                    ?>
                    </div> <!-- .entry-content -->

                </article> <!-- .et_pb_post -->

        <?php endwhile;
        else:
    ?>

        <div id="content-area" class="clearfix">

        <?php $hero_type = get_field('lh_hero_type');

        if(!empty($hero_type)) {
            $hero_type_class = 'new-page-header--' . $hero_type;
        } else {
            $hero_type_class = 'new-page-header--regular';
        }

        if($hero_type === 'overlay' || $hero_type === 'overlay_fullwidth') {
            $background_source = get_the_post_thumbnail_url(get_the_ID(),'full');
            $style = "background-image: linear-gradient(to bottom, transparent 50%, black 100%), url('" . $background_source . "')";
        } else {
            $style = '';
        }

        /**if($hero_type === 'overlay') {
            $hero_type_class .= ' container';
        }**/
        ?>




            <header class="container new-page-header <?php echo $hero_type_class; ?>" style="<?php echo $style; ?>">
                <div class="new-page-header__content">
                    <?php echo '<p class="post-meta">';
                    echo '<span class="published"><span class="published__icon">' .  file_get_contents(get_stylesheet_directory_uri() . "/images/calendar.svg"). '</span>' . esc_html( get_the_time( 'M j, Y' )) . '</span>';
                    echo '</p>'; ?>

                    <h1 class="new-page-header__title"><?php echo get_the_title(); ?></h1>

                </div>
            </header>

                <div class="lh-section">

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                    /**
                     * Fires before the title and post meta on single posts.
                     *
                     * @since 3.18.8
                     */
                    do_action( 'et_before_post' );
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
                        <?php if ( ( 'off' !== $show_default_title && $is_page_builder_used ) || ! $is_page_builder_used ) { ?>
                            <div class="et_post_meta_wrapper">
                                <?php
                                if ( ! post_password_required() ) :


                                    $thumb = '';

                                    $width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

                                    $height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
                                    $classtext = 'et_featured_image';
                                    $titletext = get_the_title();
                                    $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
                                    $thumb = $thumbnail["thumb"];

                                    $post_format = et_pb_post_format();

                                    if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) {
                                        printf(
                                            '<div class="et_main_video_container">
                                                %1$s
                                            </div>',
                                            et_core_esc_previously( $first_video )
                                        );
                                    } else if ( ! in_array( $post_format, array( 'gallery', 'link', 'quote' ) ) && 'on' === et_get_option( 'divi_thumbnails', 'on' ) && '' !== $thumb ) {
                                        if($hero_type === 'regular' || $hero_type === 'narrow'  || $hero_type == NULL) {

                                            if($hero_type === 'regular' || $hero_type == NULL) {
                                                $thumb_class = 'lh-single__thumb';
                                            } else {
                                                $thumb_class = 'lh-single__thumb lh-single__thumb--narrow';
                                            }

                                            print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $thumb_class);
                                        }
                                    } else if ( 'gallery' === $post_format ) {
                                        et_pb_gallery_images();
                                    }
                                ?>
                                
                                <?php
                                    $text_color_class = et_divi_get_post_text_color();

                                    $inline_style = et_divi_get_post_bg_inline_style();

                                    switch ( $post_format ) {
                                        case 'audio' :
                                            $audio_player = et_pb_get_audio_player();

                                            if ( $audio_player ) {
                                                printf(
                                                    '<div class="et_audio_content%1$s"%2$s>
                                                        %3$s
                                                    </div>',
                                                    esc_attr( $text_color_class ),
                                                    et_core_esc_previously( $inline_style ),
                                                    et_core_esc_previously( $audio_player )
                                                );
                                            }

                                            break;
                                        case 'quote' :
                                            printf(
                                                '<div class="et_quote_content%2$s"%3$s>
                                                    %1$s
                                                </div> <!-- .et_quote_content -->',
                                                et_core_esc_previously( et_get_blockquote_in_content() ),
                                                esc_attr( $text_color_class ),
                                                et_core_esc_previously( $inline_style )
                                            );

                                            break;
                                        case 'link' :
                                            printf(
                                                '<div class="et_link_content%3$s"%4$s>
                                                    <a href="%1$s" class="et_link_main_url">%2$s</a>
                                                </div> <!-- .et_link_content -->',
                                                esc_url( et_get_link_url() ),
                                                esc_html( et_get_link_url() ),
                                                esc_attr( $text_color_class ),
                                                et_core_esc_previously( $inline_style )
                                            );

                                            break;
                                    }

                                endif;
                            ?>
                        </div> <!-- .et_post_meta_wrapper -->
                    <?php  } ?>

                        <div class="entry-content container">
                        <?php
                            do_action( 'et_before_content' );

                            the_content();

                            wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
                        ?>
                        </div> <!-- .entry-content -->
                        <div class="et_post_meta_wrapper">
                        <?php
                        if ( et_get_option('divi_468_enable') === 'on' ){
                            echo '<div class="et-single-post-ad">';
                            if ( et_get_option('divi_468_adsense') !== '' ) echo et_core_intentionally_unescaped( et_core_fix_unclosed_html_tags( et_get_option('divi_468_adsense') ), 'html' );
                            else { ?>
                                <a href="<?php echo esc_url(et_get_option('divi_468_url')); ?>"><img src="<?php echo esc_attr(et_get_option('divi_468_image')); ?>" alt="468" class="foursixeight" /></a>
                    <?php   }
                            echo '</div> <!-- .et-single-post-ad -->';
                        }

                        /**
                         * Fires after the post content on single posts.
                         *
                         * @since 3.18.8
                         */
                        do_action( 'et_after_post' );

                            if ( ( comments_open() || get_comments_number() ) && 'on' === et_get_option( 'divi_show_postcomments', 'on' ) ) {
                                comments_template( '', true );
                            }
                        ?>
                        </div> <!-- .et_post_meta_wrapper -->
                    </article> <!-- .et_pb_post -->

                <?php endwhile; ?>
                </div> <!-- .lh-one-col -->

        </div> <!-- #content-area -->

    <?php endif; ?>
</div> <!-- #main-content -->

<?php

get_footer();
