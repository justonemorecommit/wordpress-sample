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
    ?>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <script type="text/javascript">document.documentElement.className = 'js';</script>

    <link rel="stylesheet" type="text/css" href="/wp-content/themes/Divi-Child/fonts/tthoves.css"/>

    <?php wp_head(); ?>

    <script type="text/javascript">
        !function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
            analytics.load("7cp8b9jFwyvGTugGOYY4nyD6qCDvNN5Y");
            // analytics.page("<?php //echo $page_name_for_analytics; ?>");
        }}();
    </script>
    <!--referral hero script-->
    <script>!function(m,a,i,t,r,e){if(m.RH)return;r=m.RH={},r.uuid=t,r.loaded=0,r.base_url=i,r.queue=[],m.rht=function(){r.queue.push(arguments)};e=a.getElementsByTagName('script')[0],c=a.createElement('script');c.async=!0,c.src=i+'/widget/'+t+'.js',e.parentNode.insertBefore(c,e)}(window,document,'https://app.referralhero.com','MF6bcb95466c');
    </script>

</head>
<body <?php body_class(); ?>>
<?php
$product_tour_enabled = et_builder_is_product_tour_enabled();
$page_container_style = $product_tour_enabled ? ' style="padding-top: 0px;"' : ''; ?>
<!--Laserhub-top-menu-->
<header id="page-header" class="page-header">
    <script>
        jQuery(document).ready(function($) {
            //toggle mobile menu
            $("#btn_mobile-menu-toggle").on("click", function() {
                $("#page-header").toggleClass("page-header--mobile");
                //disable background scroll on mobile menu
                $("body").toggleClass("disable-scroll");
            });
            //hide header on more than 50px scroll
            let posY = 90
            let scrollDir="up"
            $(document).on("scroll", function(data) {
                let currentPosY = Math.max(window.pageYOffset, 90);
                if (posY<currentPosY && scrollDir === "up"){
                    scrollDir="down"
                    $("#page-header").addClass("page-header--hidden");
                } else if (posY>currentPosY && scrollDir === "down"){
                    scrollDir="up"
                    $("#page-header").removeClass("page-header--hidden");
                }
                posY=currentPosY;
            });
            //Mobile dropdown
            $(".top-menu__link--mobile").on("click", function(event) {
                console.log($(this))
                $(this).parent().toggleClass("menu-item-collapsed")

            });
        });
    </script>
        <?php if (!array_key_exists('band-closed', $_COOKIE) && is_active_sidebar('top-banner')): ?>
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
    <?php include("top-menu.php");
        include("top-menu-mobile.php");
    ?>
</header>
<!--end-->

<div id="page-container"<?php echo et_core_intentionally_unescaped( $page_container_style, 'fixed_string' ); ?>>



    <div id="et-main-area">
<?php
/**
 * Fires after the header, before the main content is output.
 *
 * @since 3.10
 */
do_action( 'et_before_main_content' );
