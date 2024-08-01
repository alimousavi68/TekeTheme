<?php
/**
 * Header hooks and functions
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;

if( ! function_exists( 'blogistic_header_site_branding_part' ) ) :
    /**
     * Header site branding element
     * 
     * @since 1.0.0
     */
    function blogistic_header_site_branding_part() {
        ?>
            <div class="site-branding">
                <?php
                    $site_title_tag_for_frontpage = BIT\blogistic_get_customizer_option( 'site_title_tag_for_frontpage' );
                    $site_title_tag_for_innerpage = BIT\blogistic_get_customizer_option( 'site_title_tag_for_innerpage' );
                    $site_description_show_hide = BIT\blogistic_get_customizer_option( 'blogdescription_option' );

                    the_custom_logo();

                    if ( is_front_page() ) :
                        echo '<'. esc_html( $site_title_tag_for_frontpage ) .' class="site-title"><a href="'. esc_url( home_url( '/' ) ) .'" rel="home">'. get_bloginfo( 'name' ) .'</a></'. esc_html( $site_title_tag_for_frontpage ) .'>';
                    else :
                        echo '<'. esc_html( $site_title_tag_for_innerpage ) .' class="site-title"><a href="'. esc_url( home_url( '/' ) ) .'" rel="home">'. get_bloginfo( 'name' ) .'</a></'. esc_html( $site_title_tag_for_innerpage ) .'>';
                    endif;
                    $blogistic_description = get_bloginfo( 'description', 'display' );
                    if( $site_description_show_hide ) :
                        if ( $blogistic_description ) echo '<p class="site-description">'. $blogistic_description .'</p>';
                    endif;
                ?>
            </div><!-- .site-branding -->
        <?php
    }
    add_action( 'blogistic_header__site_branding_section_hook', 'blogistic_header_site_branding_part', 10 );
endif;

if( ! function_exists( 'blogistic_header_main_advertisement_part' ) ) :
    /**
     * Header advertisement banner element
     * 
     * @since 1.0.0
     */
    function blogistic_header_main_advertisement_part() {
        $header_ads_banner_option = BIT\blogistic_get_customizer_option( 'header_ads_banner_option' );
        $header_ads_banner_image = BIT\blogistic_get_customizer_option( 'header_ads_banner_image' );
        if( ! $header_ads_banner_option ) return;
        if( ! wp_get_attachment_image_url( $header_ads_banner_image, 'full' ) ) return;
        ?>
            <div class="advertisement-banner">
                <div class="blogistic-container">
                    <div class="row my-1">
                        <?php
                            $header_ads_banner_image_url = BIT\blogistic_get_customizer_option( 'header_ads_banner_image_url' );
                            $header_ads_banner_image_target_attr = BIT\blogistic_get_customizer_option( 'header_ads_banner_image_target_attr' );
                            $header_ads_banner_image_rel_attr = BIT\blogistic_get_customizer_option( 'header_ads_banner_image_rel_attr' );
                        ?>
                        <a href="<?php echo esc_url( $header_ads_banner_image_url ); ?>" target="<?php echo esc_attr( $header_ads_banner_image_target_attr ); ?>" rel="<?php echo esc_attr( $header_ads_banner_image_rel_attr ); ?>">
                            <img src="<?php echo esc_url( wp_get_attachment_image_url( $header_ads_banner_image, 'full' ) ); ?>">
                        </a>
                    </div>
                </div>
            </div><!-- .advertisement-banner -->
        <?php
    }
endif;

if( ! function_exists( 'blogistic_header_menu_part' ) ) :
    /**
     * Header menu element
     * 
     * @since 1.0.0
     */
    function blogistic_header_menu_part() {
        $sub_menu_mobile_option = BIT\blogistic_get_customizer_option( 'sub_menu_mobile_option' );
        $nav_classes = 'hover-effect--' . BIT\blogistic_get_customizer_option( 'blogistic_header_menu_hover_effect' );
        if( ! $sub_menu_mobile_option ) $nav_classes .= ' sub-menu-hide-on-mobile';
      ?>
        <div class="site-navigation-wrapper">
            <nav id="site-navigation" class="main-navigation <?php echo esc_attr( $nav_classes ); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <div id="blogistic-menu-burger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <span class="menu-txt"><?php esc_html_e( 'Menu', 'blogistic' ); ?></span>
                </button>
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'header-menu',
                            'container_class' =>    'blogistic-primary-menu-container' 
                        )
                    );
                ?>
            </nav><!-- #site-navigation -->
        </div>
      <?php
    }
    add_action( 'blogistic_header__menu_section_hook', 'blogistic_header_menu_part', 10 );
 endif;

 if( ! function_exists( 'blogistic_header_custom_button_part' ) ) :
    /**
     * Header custom button element
     * 
     * @since 1.0.0
     */
    function blogistic_header_custom_button_part() {
        if( ! BIT\blogistic_get_customizer_option( 'blogistic_header_custom_button_option' ) ) return;
        $custom_button_redirect_link = BIT\blogistic_get_customizer_option( 'blogistic_custom_button_redirect_href_link' );
        $custom_button_label = BIT\blogistic_get_customizer_option( 'blogistic_custom_button_label' );
        $custom_button_icon = BIT\blogistic_get_customizer_option( 'blogistic_custom_button_icon' );
        $custom_button_target = BIT\blogistic_get_customizer_option( 'blogistic_custom_button_target' );
        $custom_button_option = BIT\blogistic_get_customizer_option( 'show_custom_button_mobile_option' );

        $mobile_button_class = ( ! $custom_button_option ) ? ' hide-on-mobile' : '';
        $elementClass = 'header-custom-button';
        $elementClass .= $mobile_button_class;
        ?>
            <div class="header-custom-button-wrapper">
                <a class="<?php echo esc_attr( $elementClass ); ?>" href="<?php echo esc_url( $custom_button_redirect_link ); ?>" target="<?php echo esc_attr( $custom_button_target ); ?>">
                    <?php
                        if( $custom_button_icon['type'] == 'icon' ) {
                            if( $custom_button_icon['value'] != 'fas fa-ban' ) echo '<span class="custom-button-icon"><i class="'. esc_attr( $custom_button_icon['value'] ) .'"></i></span>';
                        } else {
                            if( $custom_button_icon['type'] != 'none' ) echo '<span class="custom-button-icon">'. wp_get_attachment_image( $custom_button_icon['value'], 'full' ) .'</span>';
                        }
    
                        if( $custom_button_label ) echo '<span class="custom-button-label">' . esc_html( $custom_button_label ) .'</span>';
                    ?>
                </a>
            </div>
        <?php
    }
    add_action( 'blogistic_header__custom_button_section_hook', 'blogistic_header_custom_button_part', 10 );
 endif;

 if( ! function_exists( 'blogistic_header_live_search_part' ) ) :
    /**
     * Header live search element
     * 
     * @since 1.0.0
     */
    function blogistic_header_live_search_part() {
        if( ! BIT\blogistic_get_customizer_option( 'blogistic_header_live_search_option' ) ) return;
        ?>
            <div class="search-wrap search-type--default">
                <button class="search-trigger"><i class="fas fa-search"></i></button>
                <div class="search-form-wrap">
                    <?php echo get_search_form(); ?>
                    <button class="search-form-close"><i class="fas fa-times"></i></button>
                </div>
            </div>
        <?php
    }
    add_action( 'blogistic_header_search_hook', 'blogistic_header_live_search_part', 10 );
 endif;

 if( ! function_exists( 'blogistic_header_theme_mode_part' ) ) :
    /**
     * Header theme mode element
     * 
     * @since 1.0.0
     */
    function blogistic_header_theme_mode_part() {
        if( ! BIT\blogistic_get_customizer_option( 'blogistic_theme_mode_option' ) ) return;
        $light_mode_icon_args = BIT\blogistic_get_customizer_option( 'blogistic_theme_mode_light_icon' );
        $dark_mode_icon_args = BIT\blogistic_get_customizer_option( 'blogistic_theme_mode_dark_icon' );
        $light_mode_icon_class = ( array_key_exists( 'value', $light_mode_icon_args ) && is_array( $light_mode_icon_args ) ) ? $light_mode_icon_args['value'] : '';
        $dark_mode_icon_class = ( array_key_exists( 'value', $dark_mode_icon_args ) && is_array( $dark_mode_icon_args ) ) ? $dark_mode_icon_args['value'] : '';
        ?>
            <div class="mode-toggle-wrap">
                <span class="mode-toggle">
                    <?php 
                        blogistic_theme_mode_switch( $light_mode_icon_args, 'light' );
                        blogistic_theme_mode_switch( $dark_mode_icon_args, 'dark' );
                    ?>
                </span>
            </div>
        <?php
    }
    add_action( 'blogistic_header_theme_mode_hook', 'blogistic_header_theme_mode_part' );
 endif;

 if( ! function_exists( 'blogistic_header_canvas_menu_part' ) ) :
    /**
     * Header canvas menu element
     * 
     * @since 1.0.0
     */
    function blogistic_header_canvas_menu_part() {
        if( ! BIT\blogistic_get_customizer_option( 'canvas_menu_enable_disable_option' ) ) return;
        $elementClass = 'blogistic-canvas-menu';

        ?>
            <div class="<?php echo esc_attr( $elementClass ); ?>">
                <span class="canvas-menu-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <div class="canvas-menu-sidebar">
                    <?php if( is_active_sidebar( 'canvas-menu-sidebar' ) ) dynamic_sidebar( 'canvas-menu-sidebar' ); ?>
                </div>
            </div>
        <?php
    }
    add_action( 'blogistic_header_off_canvas_hook', 'blogistic_header_canvas_menu_part' );
 endif;
 

 if( ! function_exists( 'blogistic_header_advertisement_part' ) ) :
    /**
     * Blogistic main banner element
     * 
     * @since 1.0.0
     */
    function blogistic_header_advertisement_part() {
        $advertisement_repeater = BIT\blogistic_get_customizer_option( 'advertisement_repeater' );
        $advertisement_repeater_decoded = json_decode( $advertisement_repeater );
        $header_advertisement = array_values(array_filter( $advertisement_repeater_decoded, function( $element ) {
            if( property_exists( $element, 'item_checkbox_header' ) ) return ( $element->item_checkbox_header == true && $element->item_option == 'show' ) ? $element : '';
        }));
        if( empty( $header_advertisement ) ) return;
        $image_option = array_column( $header_advertisement, 'item_image_option' );
        $alignment = array_column( $header_advertisement, 'item_alignment' );
        $elementClass = 'alignment--' . $alignment[0];
        $elementClass .= ' image-option--' . ( ( $image_option[0] == 'full_width' ) ? 'full-width' : 'original' );
        ?>
            <section class="blogistic-advertisement-section-header blogistic-advertisement <?php echo esc_html( $elementClass ); ?>">
                <div class="blogistic-container">
                    <div class="row my-1">
                        <div class="advertisement-wrap">
                            <?php
                                if( ! empty( $advertisement_repeater_decoded ) ) :
                                    foreach( $header_advertisement as $field ) :
                                        ?>
                                        <div class="advertisement">
                                            <a href="<?php echo esc_url( $field->item_url ); ?>" target="<?php echo esc_attr( $field->item_target ); ?>" rel="<?php echo esc_attr( $field->item_rel_attribute ); ?>">
                                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $field->item_image, 'full' ) ); ?>">
                                            </a>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    }
    add_action( 'blogistic_header_after_hook', 'blogistic_header_advertisement_part', 10 );
 endif;

 if( ! function_exists( 'blogistic_footer_advertisement_part' ) ) :
    /**
     * Blogistic main banner element
     * 
     * @since 1.0.0
     */
    function blogistic_footer_advertisement_part() {
        $advertisement_repeater = BIT\blogistic_get_customizer_option( 'advertisement_repeater' );
        $advertisement_repeater_decoded = json_decode( $advertisement_repeater );
        $footer_advertisement = array_values(array_filter( $advertisement_repeater_decoded, function( $element ) {
            if( property_exists( $element, 'item_checkbox_stick_with_footer' ) ) return ( $element->item_checkbox_stick_with_footer == true && $element->item_option == 'show' ) ? $element : ''; 
        }));
        if( empty( $footer_advertisement ) ) return;
        $image_option = array_column( $footer_advertisement, 'item_image_option' );
        $alignment = array_column( $footer_advertisement, 'item_alignment' );
        $elementClass = 'alignment--' . $alignment[0];
        $elementClass .= ' image-option--' . ( ( $image_option[0] == 'full_width' ) ? 'full-width' : 'original' );
        ?>
            <section class="blogistic-advertisement-section-footer blogistic-advertisement <?php echo esc_html( $elementClass ); ?>">
                <div class="blogistic-container">
                    <div class="row my-1">
                        <div class="advertisement-wrap">
                            <?php
                                if( ! empty( $advertisement_repeater_decoded ) ) :
                                    foreach( $footer_advertisement as $field ) :
                                        ?>
                                        <div class="advertisement">
                                            <a href="<?php echo esc_url( $field->item_url ); ?>" target="<?php echo esc_attr( $field->item_target ); ?>" rel="<?php echo esc_attr( $field->item_rel_attribute ); ?>">
                                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $field->item_image, 'full' ) ); ?>">
                                            </a>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    }
    add_action( 'blogistic_before_footer_hook', 'blogistic_footer_advertisement_part' );
 endif;

 if( ! function_exists( 'blogistic_before_content_advertisement_part' ) ) :
    /**
     * Blogistic main banner element
     * 
     * @since 1.0.0
     */
    function blogistic_before_content_advertisement_part() {
        $advertisement_repeater = BIT\blogistic_get_customizer_option( 'advertisement_repeater' );
        $advertisement_repeater_decoded = json_decode( $advertisement_repeater );
        $before_content_advertisement = array_values(array_filter( $advertisement_repeater_decoded, function( $element ) {
            if( property_exists( $element, 'item_checkbox_before_post_content' ) ) return ( $element->item_checkbox_before_post_content == true && $element->item_option == 'show' ) ? $element : ''; 
        }));
        if( empty( $before_content_advertisement ) ) return;
        $image_option = array_column( $before_content_advertisement, 'item_image_option' );
        $alignment = array_column( $before_content_advertisement, 'item_alignment' );
        $elementClass = 'alignment--' . $alignment[0];
        $elementClass .= ' image-option--' . ( ( $image_option[0] == 'full_width' ) ? 'full-width' : 'original' );
        ?>
            <section class="blogistic-advertisement-section-before-content blogistic-advertisement <?php echo esc_html( $elementClass ); ?>">
                <div class="blogistic-container">
                    <div class="row my-1">
                        <div class="advertisement-wrap">
                            <?php
                                if( ! empty( $advertisement_repeater_decoded ) ) :
                                    foreach( $before_content_advertisement as $field ) :
                                        ?>
                                        <div class="advertisement">
                                            <a href="<?php echo esc_url( $field->item_url ); ?>" target="<?php echo esc_attr( $field->item_target ); ?>" rel="<?php echo esc_attr( $field->item_rel_attribute ); ?>">
                                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $field->item_image, 'full' ) ); ?>">
                                            </a>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    }
    add_action( 'blogistic_before_single_content_hook', 'blogistic_before_content_advertisement_part' );
 endif;

 if( ! function_exists( 'blogistic_after_content_advertisement_part' ) ) :
    /**
     * Blogistic main banner element
     * 
     * @since 1.0.0
     */
    function blogistic_after_content_advertisement_part() {
        $advertisement_repeater = BIT\blogistic_get_customizer_option( 'advertisement_repeater' );
        $advertisement_repeater_decoded = json_decode( $advertisement_repeater );
        $after_content_advertisement = array_values(array_filter( $advertisement_repeater_decoded, function( $element ) {
            if( property_exists( $element, 'item_checkbox_after_post_content' ) ) return ( $element->item_checkbox_after_post_content == true && $element->item_option == 'show' ) ? $element : ''; 
        }));
        if( empty( $after_content_advertisement ) ) return;
        $image_option = array_column( $after_content_advertisement, 'item_image_option' );
        $alignment = array_column( $after_content_advertisement, 'item_alignment' );
        $elementClass = 'alignment--' . $alignment[0];
        $elementClass .= ' image-option--' . ( ( $image_option[0] == 'full_width' ) ? 'full-width' : 'original' );
        ?>
            <section class="blogistic-advertisement-section-after-content blogistic-advertisement <?php echo esc_html( $elementClass ); ?>">
                <div class="blogistic-container">
                    <div class="row my-1">
                        <div class="advertisement-wrap">
                            <?php
                                if( ! empty( $advertisement_repeater_decoded ) ) :
                                    foreach( $after_content_advertisement as $field ) :
                                        ?>
                                        <div class="advertisement">
                                            <a href="<?php echo esc_url( $field->item_url ); ?>" target="<?php echo esc_attr( $field->item_target ); ?>" rel="<?php echo esc_attr( $field->item_rel_attribute ); ?>">
                                                <img src="<?php echo esc_url( wp_get_attachment_image_url( $field->item_image, 'full' ) ); ?>">
                                            </a>
                                        </div>
                                        <?php
                                    endforeach;
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
    }
    add_action( 'blogistic_after_single_content_hook', 'blogistic_after_content_advertisement_part' );
 endif;

 if( ! function_exists( 'blogistic_get_background_and_cursor_animation' ) ) :
    /**
     * Renders html for cursor and background animation
     * 
     * @since 1.0.0
     */
    function blogistic_get_background_and_cursor_animation() {
        $site_background_animation = BIT\blogistic_get_customizer_option( 'site_background_animation' );
        if( $site_background_animation ) blogistic_shooting_star_animation_html();
        $cursor_animation = BIT\blogistic_get_customizer_option( 'cursor_animation' );
        $cursorclass = 'blogistic-cursor';
        if( $cursor_animation != 'none' ) $cursorclass .= ' type--' . $cursor_animation;
        if( in_array( $cursor_animation, [ 'one' ] ) ) echo '<div class="'. esc_attr( $cursorclass ) .'"></div>';
    }
    add_action( 'blogistic_animation_hook', 'blogistic_get_background_and_cursor_animation' );
 endif;