<?php
/**
 * INcludes theme defaults and starter functions
 * 
 * @package Blogistic
 * @since 1.0.0
 */
namespace Blogistic\CustomizerDefault;

if( ! function_exists( 'blogistic_get_customizer_option' ) ) :
    /**
     * Gets customizer "theme mod" value
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_get_customizer_option( $control_id ) {
        return get_theme_mod( $control_id, blogistic_get_customizer_default( $control_id ) );
    }
endif;

if( !function_exists( 'blogistic_get_multiselect_tab_option' ) ) :
    /**
     * Gets customizer "multiselect combine tab" value
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_get_multiselect_tab_option( $key ) {
        $value = blogistic_get_customizer_option( $key );
        if( !$value["desktop"] && !$value["tablet"] && !$value["mobile"] ) return apply_filters( "blogistic_get_multiselect_tab_option", false );
        return apply_filters( "blogistic_get_multiselect_tab_option", true );
    }
 endif;

if( !function_exists( 'blogistic_get_customizer_default' ) ) :
    /**
     * Gets customizer "theme_mods" value
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_get_customizer_default($key) {
        $array_defaults = apply_filters( 'blogistic_get_customizer_defaults', [
            'theme_color'   => '#7E43FD',
            'gradient_theme_color'   => 'linear-gradient(135deg,#942cddcc 0,#38a3e2cc 100%)',
            'header_textcolor'   => '000000',
            'site_background_color'  => json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => 'linear-gradient(130deg, #682BD4 0%, #19CEAC 100%)'
            ]),
            'site_background_animation' =>  'two',
            'animation_object_color' => '#7E43FD',
            'preset_color_1'    => '#64748b',
            'preset_color_2'    => '#27272a',
            'preset_color_3'    => '#ef4444',
            'preset_color_4'    => '#eab308',
            'preset_color_5'    => '#84cc16',
            'preset_color_6'    => '#22c55e',
            'preset_color_7'    => '#06b6d4',
            'preset_color_8'    => '#0284c7',
            'preset_color_9'    => '#6366f1',
            'preset_color_10'    => '#84cc16',
            'preset_color_11'    => '#a855f7',
            'preset_color_12'    => '#f43f5e',
            'preset_gradient_1'   => 'linear-gradient( 135deg, #485563 10%, #29323c 100%)',
            'preset_gradient_2' => 'linear-gradient( 135deg, #FF512F 10%, #F09819 100%)',
            'preset_gradient_3'  => 'linear-gradient( 135deg, #00416A 10%, #E4E5E6 100%)',
            'preset_gradient_4'   => 'linear-gradient( 135deg, #CE9FFC 10%, #7367F0 100%)',
            'preset_gradient_5' => 'linear-gradient( 135deg, #90F7EC 10%, #32CCBC 100%)',
            'preset_gradient_6'  => 'linear-gradient( 135deg, #81FBB8 10%, #28C76F 100%)',
            'preset_gradient_7'   => 'linear-gradient( 135deg, #EB3349 10%, #F45C43 100%)',
            'preset_gradient_8' => 'linear-gradient( 135deg, #FFF720 10%, #3CD500 100%)',
            'preset_gradient_9'  => 'linear-gradient( 135deg, #FF96F9 10%, #C32BAC 100%)',
            'preset_gradient_10'   => 'linear-gradient( 135deg, #69FF97 10%, #00E4FF 100%)',
            'preset_gradient_11' => 'linear-gradient( 135deg, #3C8CE7 10%, #00EAFF 100%)',
            'preset_gradient_12'  => 'linear-gradient( 135deg, #FF7AF5 10%, #513162 100%)',
            'sub_menu_mobile_option'    => true,
            'scroll_to_top_mobile_option'    => false,
            'show_custom_button_mobile_option'  =>  true,
            'show_readmore_button_mobile_option'  =>  true,
            'website_layout'    => 'full-width--layout',
            'social_icons_target' => '_blank',
            'social_icons' => json_encode([
                [
                    'icon_class'    =>  'fab fa-facebook-f',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ],
                [
                    'icon_class'    =>  'fab fa-instagram',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ],
                [
                    'icon_class'    =>  'fa-brands fa-x-twitter',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ],
                [
                    'icon_class'    =>  'fab fa-youtube',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ],
                [
                    'icon_class'    =>  'fab fa-telegram',
                    'icon_url'      => '',
                    'item_option'   => 'show'
                ],
            ]),
            'social_icon_official_color_inherit'    =>  true,
            'global_button_icon_picker' => [
                'type'  => 'icon',
                'value' => 'fa-solid fa-arrow-right'
            ],
            // global button
            'global_button_label'   =>  esc_html__( 'Read More', 'blogistic' ),
            'global_button_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '500', 'label' => 'Medium 500', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 13,
                    'tablet' => 13,
                    'smartphone' => 13
                ],
                'line_height'   => [
                    'desktop' => 21,
                    'tablet' => 21,
                    'smartphone' => 21
                ],
                'letter_spacing'   => [
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ],
            'global_button_font_size'    => [
                'desktop'   => 15,
                'tablet'    => 15,
                'smartphone'    => 15
            ],
            'global_button_color'   =>  [ 'color' => '#7E43FD', 'hover' => '#7E43FD' ],
            'global_button_background_color'   =>   json_encode([
                'initial'   => [
                    'type'  => 'solid',
                    'solid' => '',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ],
                'hover'   => [
                    'type'  => 'solid',
                    'solid' => '',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ]
            ]),
            'global_button_radius'   =>  0,
            'global_button_border'    => [ "type"  => "none", "width"   => 1, "color"   => "#3858f6" ],
            'global_button_box_shadow_initial'   =>  [
                'option'    => 'none',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'global_button_box_shadow_hover'   =>  [
                'option'    => 'none',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'global_button_padding' =>  [
                'desktop' => [ 'top' => 8, 'right' => 16, 'bottom' => 8, 'left' => 16, 'link' => true ],
                'tablet' => [ 'top' => 8, 'right' => 16, 'bottom' => 8, 'left' => 16, 'link' => true ],
                'smartphone' => [ 'top' => 8, 'right' => 16, 'bottom' => 8, 'left' => 16, 'link' => true ]
            ],
            // post format
            'audio_post_format_icon_picker' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-music'
            ],
            'gallery_post_format_icon_picker' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-layer-group'
            ],
            'image_post_format_icon_picker' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-image'
            ],
            'quote_post_format_icon_picker' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-quote-left'
            ],
            'standard_post_format_icon_picker' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-regular fa-file-lines'
            ],
            'video_post_format_icon_picker' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-video'
            ],
            // scroll to top
            'blogistic_scroll_to_top_option' =>  true,
            'stt_text'  =>  esc_html__( '', 'blogistic' ),
            'stt_icon'  =>  [
                'type'  =>  'icon',
                'value' =>  'fas fa-angle-up'
            ],
            'stt_alignment' => 'right',
            'stt_color_group' => [ 'color'   => "#fff", 'hover'   => "#fff" ],
            'stt_background_color_group' => json_encode([
                'initial'   => [
                    'type'  => 'solid',
                    'solid' => '--blogistic-global-preset-theme-color',
                    'gradient'  => null
                ],
                'hover'   => [
                    'type'  => 'solid',
                    'solid' => '#7E43FD',
                    'gradient'  => null
                ]
            ]),
            //
            'sidebar_sticky_option' =>  false,
            'preloader_option'  => false,
            'post_title_hover_effects'  => 'one',
            'site_image_hover_effects'  => 'one',
            'cursor_animation'  => 'one',
            'site_breadcrumb_option'    => true,
            'site_breadcrumb_type'  => 'default',
            'breadcrumb_separator_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-angles-right'
            ],
            'breadcrumb_typo'   =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'breadcrumb_background_color'  => json_encode([
                'type'  => 'solid',
                'solid' => '#ffffffa3',
                'gradient'  => null
            ]),
            'breadcrumb_box_shadow' =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],  
            'breadcrumb_text_color' =>  '#000',
            'breadcrumb_link_color'  => [ 'color' => '#000', 'hover' => '#000' ],
            'site_schema_ready' => true,
            'site_date_format'  => 'default',
            'site_date_to_show' => 'published',
            'blogistic_disable_admin_notices'   => false,
            'site_title_hover_textcolor'=> '#000',
            'site_description_color'    => '#000',
            'site_title_tag_for_frontpage'  =>  'h1',
            'site_title_tag_for_innerpage'  =>  'h2',
            'main_banner_option'    => false,
            'main_banner_layouts'    => 'two',
            'main_banner_slider_categories' => '[]',
            'main_banner_slider_posts_to_include' => '[]',
            'default_typo_one'   =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Normal 400', 'variant' => 'normal' ]
            ],
            'site_title_typo'   =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 38,
                    'tablet' => 32,
                    'smartphone' => 30
                ],
                'line_height'   => [
                    'desktop' => 45,
                    'tablet' => 42,
                    'smartphone' => 40,
                ],
                'letter_spacing'   => [
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'site_description_typo'   =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'blogistic_header_custom_button_option'  =>  true,
            'blogistic_custom_button_label'  =>  esc_html__( 'Subscribe', 'blogistic' ),
            'blogistic_custom_button_icon' => [
                'type'  =>  'icon',
                'value' =>  'fas fa-bell'
            ],
            'blogistic_custom_button_redirect_href_link' =>  home_url(),
            'blogistic_custom_button_target' =>  '_self',
            'blogistic_custom_button_text_typography' =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'blogistic_custom_button_text_color' =>  [ 'color'   => "#fff", 'hover'   => "#fff" ],
            'blogistic_custom_button_icon_color' =>  [ 'color'   => "#fff", 'hover'   => "#fff" ],
            'header_custom_button_background_color_group'   =>  json_encode([
                'initial'   => [
                    'type'  => 'solid',
                    'solid' => '--blogistic-global-preset-theme-color',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ],
                'hover'   => [
                    'type'  => 'solid',
                    'solid' => '--blogistic-global-preset-theme-color',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ]
            ]),
            'blogistic_header_live_search_option'    =>  true,
            'blogistic_search_icon_color'    =>  [ 'color' => '#171717', 'hover' => '#171717' ],
            'blogistic_theme_mode_option'    =>  false,
            'blogistic_theme_mode_dark_icon'    =>  [
                'type'  =>  'icon',
                'value' =>  'fas fa-moon'
            ],
            'blogistic_theme_mode_light_icon'    =>  [
                'type'  =>  'icon',
                'value' =>  'fas fa-sun'
            ],
            'blogistic_theme_mode_icon_size'    =>  [
                'desktop'   =>  18,
                'tablet'    => 18,
                'smartphone'    => 18
            ],
            'menu_options_menu_alignment'   =>  'left',
            'menu_cutoff_option'    => true,
            'menu_cutoff_after'   =>  8,
            'menu_cutoff_text'   =>  esc_html__( 'More', 'blogistic' ),
            'menu_options_sticky_header'    =>  false,
            'blogistic_theme_mode_set_dark_mode_as_default'  =>  false,
            'blogistic_theme_mode_dark_icon_color'    =>  [ 'color' => null, 'hover' => null ],
            'blogistic_theme_mode_light_icon_color'    =>  [ 'color' => '#000', 'hover' => '#000' ],
            'blogistic_header_menu_hover_effect' =>  'one',
            'main_menu_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '500', 'label' => 'Medium 500', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'main_menu_sub_menu_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'header_menu_color'    =>   [ 'color' => '#000', 'hover' => '#000' ],
            'header_sub_menu_color'    =>   [ 'color' => '#333333', 'hover' => '#222222' ],
            'archive_pagination_type'   => 'number',
            'pagination_text_color'    =>  [ 'color' => '#7E43FD', 'hover' => '#7E43FD' ],
            'pagination_button_label'    =>  esc_html__( 'Load More', 'blogistic' ),
            'pagination_button_icon'    =>  [
                'type'  =>  'icon',
                'value' =>  'fas fa-chevron-down'
            ],
            'archive_pagination_button_icon_context'    =>  'suffix',
            'pagination_no_more_reults_text'    =>  esc_html__( 'No more results', 'blogistic' ),
            'pagination_button_text_color'    =>  [ 'color' => '#fff', 'hover' => '#fff' ],
            'pagination_button_background_color'    =>  json_encode([
                'initial'   => [
                    'type'  => 'solid',
                    'solid' => '--blogistic-global-preset-theme-color',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ],
                'hover'   => [
                    'type'  => 'solid',
                    'solid' => '#7E43FD',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ]
            ]),
            'archive_post_column'    => [
                'desktop'   => 2,
                'tablet'    => 2,
                'smartphone'    => 1
            ],
            'archive_post_layout'   => 'grid',
            'archive_sidebar_layout'    =>  'right-sidebar',
            'archive_show_social_share' =>  true,
            'archive_post_elements_alignment'=> 'center',
            'archive_title_option'  => true,
            'archive_title_tag'  => 'h2',
            'archive_excerpt_option'  => true,
            'archive_category_option'  => true,
            'archive_date_option'  => true,
            'archive_date_icon'  => [
                'type'  => 'icon',
                'value' => 'far fa-calendar-days'
            ],
            'archive_read_time_option'  => true,
            'archive_read_time_icon'  => [
                'type'  => 'icon',
                'value' => 'fas fa-book-open-reader'
            ],
            'archive_comments_option'  => true,
            'archive_comments_icon'  => [
                'type'  => 'icon',
                'value' => 'far fa-comments'
            ],
            'archive_author_option'  => true,
            'archive_author_image_option'  => true,
            'archive_button_option'  => true,
            'archive_hide_image_placeholder'  => false,
            'archive_image_size'  =>  'large',
            'archive_responsive_image_ratio'    =>  [
                'desktop'   => 0.5,
                'tablet'    => 0.5,
                'smartphone'    => 0.86
            ],
            'archive_image_border'    => [ "type"  => "none", "width"   => 1, "color"   => "#FF376C" ],
            'archive_image_border_radius'   =>  [ 
                'desktop' => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'link' => true ],
                'tablet' => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'link' => true ],
                'smartphone' => [ 'top' => 0, 'right' => 0, 'bottom' => 0, 'left' => 0, 'link' => true ]
            ],
            'archive_section_border_radius'   =>  15,
            'archive_image_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'archive_inner_background_color'  =>  json_encode([
                'type'  => 'solid',
                'solid' => '#ffffff',
                'gradient'  => null
            ]),
            'archive_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'archive_border_bottom_color'   =>  [ "type"  => "solid", "width"   => 1, "color"   => "#f4f4f4" ],
            'archive_title_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ],
                'line_height'   => [
                    'desktop' => 30,
                    'tablet' => 30,
                    'smartphone' => 30,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_excerpt_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Normal 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 25,
                    'tablet' => 25,
                    'smartphone' => 25,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_category_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.5,
                    'tablet' => 0.5,
                    'smartphone' => 0.5
                ],
                'text_transform'    => 'Capitalize',
                'text_decoration'    => 'none'
            ],
            'archive_date_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_author_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'Capitalize',
                'text_decoration'    => 'none'
            ],
            'archive_read_time_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 13,
                    'tablet' => 13,
                    'smartphone' => 13
                ],
                'line_height'   => [
                    'desktop' => 18,
                    'tablet' => 18,
                    'smartphone' => 18,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_comment_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 13,
                    'tablet' => 13,
                    'smartphone' => 13
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_category_info_box_option'  => true,
            'archive_category_info_box_icon_option'  => true,
            'archive_category_info_box_icon'  => [
                'type'  => 'icon',
                'value' => 'fas fa-layer-group'
            ],
            'archive_category_info_box_title_option'  => true,
            'archive_category_info_box_description_option'  => true,
            'archive_category_info_box_title_tag'   =>  'h2',
            'archive_category_info_box_background'    =>  json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'category_box_shadow'    =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'archive_category_info_box_title_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 30,
                    'tablet' => 30,
                    'smartphone' => 30
                ],
                'line_height'   => [
                    'desktop' => 33,
                    'tablet' => 33,
                    'smartphone' => 33,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_category_info_box_description_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '300', 'label' => 'Light 300', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 28,
                    'tablet' => 28,
                    'smartphone' => 28,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_tag_info_box_option'  => true,
            'archive_tag_info_box_icon_option'  => true,
            'archive_tag_info_box_icon'  => [
                'type'  => 'icon',
                'value' => 'fas fa-tag'
            ],
            'archive_tag_info_box_title_option'  => true,
            'archive_tag_info_box_description_option'  => true,
            'archive_tag_info_box_title_tag'    =>  'h2',
            'archive_tag_info_box_background' =>  json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'tag_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'archive_tag_info_box_title_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 35,
                    'tablet' => 35,
                    'smartphone' => 35
                ],
                'line_height'   => [
                    'desktop' => 33,
                    'tablet' => 33,
                    'smartphone' => 33,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_tag_info_box_description_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '300', 'label' => 'Light 300', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 28,
                    'tablet' => 28,
                    'smartphone' => 28,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'archive_author_info_box_option'  => true,
            'archive_author_info_box_image_option'  => true,
            'archive_author_info_box_title_option'  => true,
            'archive_author_info_box_description_option'  => true,
            'archive_author_info_box_title_tag' =>  'h2',
            'archive_author_info_box_background'  =>  json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'author_box_shadow' =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'archive_author_info_box_title_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 35,
                    'tablet' => 35,
                    'smartphone' => 35
                ],
                'line_height'   => [
                    'desktop' => 33,
                    'tablet' => 33,
                    'smartphone' => 33,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'uppercase',
                'text_decoration'    => 'none'
            ],
            'archive_author_info_box_description_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '300', 'label' => 'Light 300', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 28,
                    'tablet' => 28,
                    'smartphone' => 28,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_post_layout'   => 'layout-five',
            'single_sidebar_layout'=> 'no-sidebar',
            'single_article_width' =>  [
                'desktop'   =>  60,
                'tablet'    =>  100,
                'smartphone'    =>  100
            ],
            'single_title_option'  => true,
            'single_title_tag'  => 'h2',
            'single_thumbnail_option'  => true,
            'single_category_option'  => true,
            'single_date_option'  => true,
            'single_date_icon'  => [
                'type'  => 'icon',
                'value' => 'far fa-calendar-days'
            ],
            'single_read_time_option'  => true,
            'single_read_time_icon'  => [
                'type'  => 'icon',
                'value' => 'fas fa-book-open-reader'
            ],
            'single_comments_option'  => true,
            'single_comments_icon'  => [
                'type'  => 'icon',
                'value' => 'far fa-comments'
            ],
            'single_author_option'  => true,
            'single_author_image_option'  => true,
            'single_gallery_lightbox_option'  => true,
            'single_post_content_alignment' =>  'left',
            'single_image_size'  =>  'large',
            'single_responsive_image_ratio'    =>  [
                'desktop'   => 0.55,
                'tablet'    => 0.65,
                'smartphone'    => 0.88
            ],
            'single_image_border'    => [ "type"  => "none", "width"   => 1, "color"   => "#FF376C" ],
            'single_image_border_radius'   =>  15,
            'single_image_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'single_author_box_option'  => true,
            'single_author_box_image_option'  => true,
            'single_author_info_box_title_option'  => true,
            'single_author_info_box_description_option'  => true,
            'single_post_navigation_option'  => true,
            'single_post_navigation_thumbnail_option'  => true,
            'single_post_navigation_show_date'  => true,
            'single_post_related_posts_option'  => true,
            'related_posts_layouts' =>  'one',
            'single_post_related_posts_title'   => esc_html__( 'Related Articles', 'blogistic' ),
            'related_posts_no_of_column'   => 2,
            'related_posts_filter_by'   => 'categories',
            'related_posts_author_option'   => true,
            'related_posts_date_option'   => true,
            'related_posts_comment_option'   => true,
            'single_title_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 35,
                    'tablet' => 30,
                    'smartphone' => 28
                ],
                'line_height'   => [
                    'desktop' => 44,
                    'tablet' => 38,
                    'smartphone' => 32,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_content_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 16,
                    'smartphone' => 16
                ],
                'line_height'   => [
                    'desktop' => 34,
                    'tablet' => 34,
                    'smartphone' => 34,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_category_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Medium 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 12,
                    'tablet' => 12,
                    'smartphone' => 12
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.5,
                    'tablet' => 0.5,
                    'smartphone' => 0.5
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_date_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_author_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_read_time_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'single_page_background_color'  =>  json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => null
            ]),
            'single_page_box_shadow'    =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'single_reorder_option' =>  [
                [ 'value'  => 'category', 'option'   => true ],
                [ 'value'  => 'title', 'option'    => true ],
                [ 'value'  => 'meta', 'option'    => true ]
            ],
            'toc_option'    =>  true,
            'toc_heading_option'    =>  esc_html__( 'Table of content', 'blogistic' ),
            'toc_field_for_heading' =>  json_encode([
                [ 'value' =>  'h2', 'label' => esc_html__( 'H2', 'blogistic' ) ],
                [ 'value' =>  'h3', 'label' => esc_html__( 'H3', 'blogistic' ) ],
                [ 'value' =>  'h4', 'label' => esc_html__( 'H4', 'blogistic' ) ]
            ]),
            'toc_hierarchical'  =>  'tree',
            'toc_list_type' =>  'number',
            'toc_list_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-regular fa-circle-play'
            ],
            'toc_display_type' =>  'inline',
            'toc_sticky_width' =>  300,
            'toc_enable_accordion' =>  true,
            'toc_default_toggle' =>  true,
            'toc_open_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-chevron-up'
            ],
            'toc_close_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-chevron-down'
            ],
            'page_settings_sidebar_layout'  =>  'right-sidebar',
            'page_title_option'  => true,
            'page_title_tag'  => 'h1',
            'page_thumbnail_option'  => true,
            'page_content_option'  => true,
            'page_image_size'  =>  'large',
            'page_responsive_image_ratio'    =>  [
                'desktop'   => 0.55,
                'tablet'    => 0.55,
                'smartphone'    => 0.55
            ],
            'page_image_border'    => [ "type"  => "none", "width"   => 1, "color"   => "#FF376C" ],
            'page_image_border_radius'   =>  15,
            'page_image_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 2,
                'blur'  => 4,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 8%)'
            ],
            'page_toc_option'    =>  true,
            'page_toc_heading_option'    =>  esc_html__( 'Table of content', 'blogistic' ),
            'page_toc_field_for_heading' =>  json_encode([
                [ 'value' =>  'h2', 'label' => esc_html__( 'H2', 'blogistic' ) ],
                [ 'value' =>  'h3', 'label' => esc_html__( 'H3', 'blogistic' ) ],
                [ 'value' =>  'h4', 'label' => esc_html__( 'H4', 'blogistic' ) ]
            ]),
            'page_toc_hierarchical'  =>  'tree',
            'page_toc_list_type' =>  'number',
            'page_toc_list_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-chevron-up'
            ],
            'page_toc_display_type' =>  'inline',
            'page_toc_sticky_width' =>  330,
            'page_toc_enable_accordion' =>  false,
            'page_toc_default_toggle' =>  false,
            'page_toc_open_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-chevron-up'
            ],
            'page_toc_close_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-chevron-down'
            ],
            'page_title_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 33,
                    'tablet' => 33,
                    'smartphone' => 33
                ],
                'line_height'   => [
                    'desktop' => 31,
                    'tablet' => 31,
                    'smartphone' => 31,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'page_content_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 16,
                    'smartphone' => 16
                ],
                'line_height'   => [
                    'desktop' => 34,
                    'tablet' => 34,
                    'smartphone' => 34,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'page_background_color' =>  json_encode([
                'type'  => 'solid',
                'solid' => null,
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'page_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'header_sortable_options'  =>  [ 
                [ 'value'  => 'site-branding', 'option'   => true ],
                [ 'value'  => 'nav-menu', 'option'    => true ],
                [ 'value'  => 'custom-button', 'option'    => true ],
                [ 'value'  => 'search', 'option'    => true ],
                [ 'value'  => 'theme-mode', 'option'    => true ],
                [ 'value'  => 'off-canvas', 'option'    => true ]
            ],
            'header_ads_banner_option'  =>  true,
            'header_ads_banner_image'  =>  0,
            'header_ads_banner_image_url'  =>  '',
            'header_ads_banner_image_target_attr'  =>  '_blank',
            'header_ads_banner_image_rel_attr'  =>  'nofollow',
            'header_background' =>  json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'header_vertical_padding'   => [
                'desktop' => 35,
                'tablet' => 35,
                'smartphone' => 35
            ],
            'blogistic_site_logo_width'  =>  [
                'desktop'   => 230,
                'tablet'    => 200,
                'smartphone'    => 200
            ],
            'canvas_menu_icon_color'   =>  [ 'color' => '#000000', 'hover' => '#000000' ],
            'blogistic_canvas_menu_background_color'  =>  json_encode([
                'type'  => 'solid',
                'solid' => '#333333a3',
                'gradient'  => null
            ]),
            'canvas_menu_enable_disable_option' =>  false,
            'top_header_option' => false,
            'top_header_date_time_option'   => true,
            'top_header_social_option'  => true,
            'top_header_show_search'  => true,
            'top_header_section_background' =>  json_encode([
                'type'  => 'solid',
                'solid' => '#7e43fd',
                'gradient'  => null
            ]),
            'main_banner_render_in' =>  'front_page',
            'main_banner_text_width' =>  [
                'desktop'   => 80,
                'tablet'    => 90,
                'smartphone'    => 100
            ],
            'main_banner_no_of_posts_to_show'   =>  4,
            'main_banner_hide_post_with_no_featured_image'  =>  false,
            'main_banner_post_order'    =>  'date-desc',
            'main_banner_show_arrows'   =>  true,
            'main_banner_slider_prev_arrow'   =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-arrow-left-long'
            ],
            'main_banner_slider_next_arrow'   =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-arrow-right-long'
            ],
            'main_banner_show_fade'   =>  true,
            'main_banner_slider_infinite_loop'   =>  true,
            'main_banner_slider_autoplay'   =>  true,
            'main_banner_show_arrow_on_hover'   =>  true,
            'main_banner_slider_autoplay_speed'   =>  3000,
            'main_banner_slider_speed'   =>  500,
            'main_banner_center_mode'   =>  false,
            'main_banner_center_padding'    =>  80,
            'main_banner_item_gap'  =>  10,
            'main_banner_post_elements_show_title'  =>  true,
            'main_banner_post_elements_show_categories'  =>  false,
            'main_banner_post_elements_show_date'  =>  true,
            'main_banner_post_elements_show_author'  =>  true,
            'main_banner_date_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fas fa-calendar-days'
            ],
            'main_banner_post_elements_show_excerpt'  =>  false,
            'main_banner_post_elements_alignment'  =>  'center',
            'main_banner_image_sizes'  =>  'large',
            'main_banner_responsive_image_ratio'    =>  [
                'desktop'   => 0.42,
                'tablet'    => 0.8,
                'smartphone'    => 0.9
            ],
            'blogistic_main_banner_content_background'   =>  json_encode([
                'type'  => 'solid',
                'solid' => null,
                'gradient'  => null
            ]),
            'main_banner_design_post_title_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 34,
                    'tablet' => 28,
                    'smartphone' => 22
                ],
                'line_height'   => [
                    'desktop' => 47,
                    'tablet' => 36,
                    'smartphone' => 30,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'main_banner_design_post_title_html_tag'    =>  'h2',
            'main_banner_design_post_categories_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'main_banner_design_post_date_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'main_banner_design_post_author_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'main_banner_design_post_excerpt_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 27,
                    'tablet' => 27,
                    'smartphone' => 27,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'main_banner_design_slider_icon_size' =>  [
                'desktop'   =>  15,
                'tablet'   =>  14,
                'smartphone'   =>  13
            ],
            'carousel_option'    => false,
            'carousel_layouts'  =>  'two',
            'carousel_render_in'    =>  'front_page',
            'carousel_no_of_columns'    =>  3,
            'carousel_slider_categories' => '[]',
            'carousel_slider_tags' => '[]',
            'carousel_slider_authors' => '[]',
            'carousel_slider_posts_to_include' => '[]',
            'carousel_slider_posts_to_exclude' => '[]',
            'carousel_no_of_posts_to_show'   =>  5,
            'carousel_post_offset'   =>  0,
            'carousel_hide_post_with_no_featured_image'  =>  false,
            'carousel_post_order'    =>  'date-desc',
            'carousel_show_arrows'   =>  true,
            'carousel_slider_prev_arrow'   =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-arrow-left-long'
            ],
            'carousel_slider_next_arrow'   =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-arrow-right-long'
            ],
            'carousel_show_fade'   =>  false,
            'carousel_slider_infinite_loop'   =>  true,
            'carousel_slider_autoplay'   =>  true,
            'carousel_show_arrow_on_hover'   =>  true,
            'carousel_slider_autoplay_speed'   =>  3000,
            'carousel_slider_speed'   =>  500,
            'carousel_slides_to_scroll'    =>  1,
            'carousel_post_elements_show_title'  =>  true,
            'carousel_post_elements_show_categories'  =>  false,
            'carousel_post_elements_show_date'  =>  false,
            'carousel_post_elements_show_author'  =>  true,
            'carousel_post_elements_show_author_image'  =>  true,
            'carousel_date_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'fas fa-calendar-days'
            ],
            'carousel_post_elements_show_excerpt'  =>  false,
            'carousel_post_elements_alignment'  =>  'center',
            'carousel_image_sizes'  =>  'large',
            'carousel_responsive_image_ratio'    =>  [
                'desktop'   => 0.6,
                'tablet'    => 0.8,
                'smartphone'    => 0.9
            ],
            'carousel_image_border'    => [ "type"  => "none", "width"   => 1, "color"   => "#FF376C" ],
            'carousel_image_border_radius'  =>  [ 
                'desktop' => [ 'top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15, 'link' => true ],
                'tablet' => [ 'top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15, 'link' => true ],
                'smartphone' => [ 'top' => 15, 'right' => 15, 'bottom' => 15, 'left' => 15, 'link' => true ]
            ],
            'carousel_box_shadow'   =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'carousel_section_border_radius'   =>  15,
            'carousel_image_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'carousel_content_background'   =>  json_encode([
                'type'  => 'solid',
                'solid' => null,
                'gradient'  => null
            ]),
            'carousel_design_post_title_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 25,
                    'tablet' => 22,
                    'smartphone' => 20
                ],
                'line_height'   => [
                    'desktop' => 34,
                    'tablet' => 30,
                    'smartphone' => 28,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'carousel_design_post_title_html_tag'    =>  'h2',
            'carousel_design_post_categories_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'carousel_design_post_date_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'carousel_design_post_author_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ],
                'text_transform'    => 'uppercase',
                'text_decoration'    => 'none'
            ],
            'carousel_design_post_date_icon_size'  =>  [
                'desktop'   => 15,
                'tablet'    => 15,
                'smartphone'    => 15
            ],
            'carousel_design_post_excerpt_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 27,
                    'tablet' => 27,
                    'smartphone' => 27,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'carousel_design_slider_icon_size' =>  [
                'desktop'   =>  15,
                'tablet'   =>  15,
                'smartphone'   =>  15
            ],
            // category collection
            'category_collection_option'    =>  true,
            'category_collection_layout'    =>  'two',
            'category_collection_render_in'    =>  'front_page',
            'category_collection_show_count'    =>  true,
            'category_collection_number_of_columns'    =>  [
                'desktop'   =>  3,
                'tablet'    =>  2,
                'smartphone'    =>  1
            ],
            'category_to_include' => '[]',
            'category_to_exclude' => '[]',
            'category_collection_number' => 5,
            'category_collection_orderby' => 'asc-name',
            'category_collection_offset' => 0,
            'category_collection_hide_empty' =>  true,
            'category_collection_slider_option' =>  false,
            'category_collection_slider_arrow' =>  false,
            'category_collection_next_arrow'  =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-angle-right'
            ],
            'category_collection_prev_arrow'  =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-angle-left'
            ],
            'category_collection_autoplay_option' =>  true,
            'category_collection_autoplay_speed'  =>  3000,
            'category_collection_slider_infinite' =>  true,
            'category_collection_slider_speed' =>  300,
            'category_collection_slides_to_show' => 3,
            'category_collection_slides_to_scroll' =>  1,
            'category_collection_image_ratio'  =>  [
                'desktop'   => 0,
                'tablet'    => 0,
                'smartphone'    => 0
            ],
            'category_collection_image_radius'  =>  [
                'desktop'   => 15,
                'tablet'    => 15,
                'smartphone'    => 15
            ],
            'category_collection_image_size'  =>  'large',
            'category_collection_hover_effects'  =>  'none',
            'category_collection_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '500', 'label' => 'Medium 500', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20
                ],
                'line_height'   => [
                    'desktop' => 19,
                    'tablet' => 19,
                    'smartphone' => 19
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'Uppercase',
                'text_decoration'    => 'none'
            ],
            'category_collection_text_color'    =>  [ 'color' => '#fff', 'hover' => '#fff' ],
            'category_collection_content_background'    =>  json_encode([
                'type'  => 'solid',
                'solid' => null,
                'gradient'  => null
            ]),
            'category_collection_box_shadow'    =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            // error page
            'error_page_sidebar_layout'    =>  'right-sidebar',
            'error_page_title_text' =>  esc_html__( 'Oops! That page can’t be found.', 'blogistic' ),
            'error_page_image'  => 0,
            'error_page_content_text' =>  esc_html__( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'blogistic' ),
            'error_page_button_show_hide'    =>  true,
            'error_page_button_text'    =>  esc_html__( 'Back to Home', 'blogistic' ),
            'error_page_button_icon'  =>  [
                'type'  =>  'icon',
                'value' =>  'fa-solid fa-tent-arrow-turn-left'
            ],
            'error_page_button_icon_size'   =>  [
                'desktop'   =>  18,
                'tablet'    => 18,
                'smartphone'    => 18
            ],
            'error_page_button_icon_context'    =>  'prefix',
            'error_page_title_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 34,
                    'tablet' => 30,
                    'smartphone' => 25
                ],
                'line_height'   => [
                    'desktop' => 42,
                    'tablet' => 38,
                    'smartphone' => 30,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'error_page_content_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 16,
                    'smartphone' => 16
                ],
                'line_height'   => [
                    'desktop' => 25,
                    'tablet' => 25,
                    'smartphone' => 25,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'error_page_button_text_typo'  => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 16,
                    'smartphone' => 16
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'error_page_background_color'   =>  json_encode([
                'type'  => 'solid',
                'solid' => '#fff',
                'gradient'  => null
            ]),
            'error_page_button_background_color'   =>  json_encode([
                'initial'   => [
                    'type'  => 'solid',
                    'solid' => '--blogistic-global-preset-theme-color',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ],
                'hover'   => [
                    'type'  => 'solid',
                    'solid' => '--blogistic-global-preset-theme-color',
                    'gradient'  => 'linear-gradient(135deg,rgb(178,7,29) 0%,rgb(1,1,1) 100%)'
                ]
            ]),
            'search_page_sidebar_layout'    =>  'right-sidebar',
            'search_page_form_show_hide'    =>  true,
            'search_page_title' =>  esc_html__( 'Search Results for', 'blogistic' ),
            'search_nothing_found_title' =>  esc_html__( 'Nothing Found', 'blogistic' ),
            'search_nothing_found_content' =>  esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'blogistic' ),
            'search_page_button_text' =>  esc_html__( 'Search', 'blogistic' ),
            'search_box_shadow' =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'you_may_have_missed_section_option' => true,
            'you_may_have_missed_title_option' => true,
            'you_may_have_missed_title' => esc_html__( 'You May Have Missed', 'blogistic' ),
            'you_may_have_missed_categories' => '[]',
            'you_may_have_missed_posts_to_include' => '[]',
            'you_may_have_missed_no_of_posts_to_show'   =>  4,
            'you_may_have_missed_hide_post_with_no_featured_image'  =>  false,
            'you_may_have_missed_post_order'    =>  'rand-desc',
            'you_may_have_missed_post_elements_show_title'  =>  true,
            'you_may_have_missed_post_elements_show_categories'  =>  true,
            'you_may_have_missed_post_elements_show_date'  =>  true,
            'you_may_have_missed_post_elements_show_author'  =>  true,
            'you_may_have_missed_date_icon' =>  [
                'type'  =>  'icon',
                'value' =>  'far fa-calendar'
            ],
            'you_may_have_missed_post_elements_alignment'  =>  'center',
            'you_may_have_missed_image_sizes'  =>  'large',
            'you_may_have_missed_responsive_image_ratio'    =>  [
                'desktop'   => 1,
                'tablet'    => 0.8,
                'smartphone'    => 0.7
            ],
            'you_may_have_missed_title_color'   => '#000000',
            'you_may_have_missed_background_color_group'  => json_encode(array(
                'type'  => 'solid',
                'solid' => '--blogistic-global-preset-theme-color',
                'gradient'  => null
            )),
            'you_may_have_missed_design_section_title_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ],
                'line_height'   => array(
                    'desktop' => 36,
                    'tablet' => 36,
                    'smartphone' => 36,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'you_may_have_missed_design_post_title_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20
                ],
                'line_height'   => array(
                    'desktop' => 27,
                    'tablet' => 27,
                    'smartphone' => 27,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'you_may_have_missed_design_post_title_html_tag'    =>  'h2',
            'you_may_have_missed_design_post_categories_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 11,
                    'tablet' => 11,
                    'smartphone' => 11
                ],
                'line_height'   => array(
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'you_may_have_missed_design_post_date_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 12,
                    'tablet' => 12,
                    'smartphone' => 12
                ],
                'line_height'   => array(
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ),
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'you_may_have_missed_design_post_author_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 12,
                    'tablet' => 12,
                    'smartphone' => 12
                ],
                'line_height'   => array(
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ),
                'letter_spacing'   => array(
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ),
                'text_transform'    => 'capitalize',
                'text_decoration'    => 'none'
            ],
            'footer_option' => false,
            'footer_widget_column'  => 'column-three',
            'bottom_footer_option'  => true,
            'bottom_footer_site_info'   => esc_html__( 'Blogistic - Blog WordPress Theme %year%.', 'blogistic' ),
            'bottom_footer_show_logo'   =>  false,
            'bottom_footer_show_social_icons'   =>  true,
            'bottom_footer_header_or_custom'    =>  'header',
            'bottom_footer_logo_option'   =>  0,
            'bottom_footer_logo_width'  =>  [
                'desktop'   => 230,
                'tablet'    => 200,
                'smartphone'    => 200
            ],
            'heading_one_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 34,
                    'tablet' => 34,
                    'smartphone' => 34
                ],
                'line_height'   => [
                    'desktop' => 44,
                    'tablet' => 44,
                    'smartphone' => 44,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'heading_two_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 28,
                    'tablet' => 28,
                    'smartphone' => 28
                ],
                'line_height'   => [
                    'desktop' => 35,
                    'tablet' => 35,
                    'smartphone' => 35,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'heading_three_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ],
                'line_height'   => [
                    'desktop' => 31,
                    'tablet' => 31,
                    'smartphone' => 31,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.4,
                    'tablet' => 0.4,
                    'smartphone' => 0.4
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'heading_four_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 18,
                    'tablet' => 18,
                    'smartphone' => 18
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'heading_five_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 16,
                    'smartphone' => 16
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'heading_six_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_border_radius'   =>  15,
            'widgets_inner_background_color'  =>  json_encode([
                'type'  => 'solid',
                'solid' => '#ffffff',
                'gradient'  => null
            ]),
            'widgets_box_shadow'  =>  [
                'option'    => 'adjust',
                'hoffset'   => 0,
                'voffset'   => 0,
                'blur'  => 6,
                'spread'    => 0,
                'type'  => 'outset',
                'color' => 'rgb(0 0 0 / 10%)'
            ],
            'widgets_border_bottom_color'   =>  [ "type"  => "solid", "width"   => 2, "color"   => "#F4F4F4" ],
            'widgets_secondary_border_bottom_color'   =>  [ "type"  => "solid", "width"   => 1, "color"   => "#f0f0f0" ],
            'sidebar_block_title_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ],
                'line_height'   => [
                    'desktop' => 36,
                    'tablet' => 36,
                    'smartphone' => 36,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.6,
                    'tablet' => 0.6,
                    'smartphone' => 0.6
                ],
                'text_transform'    => 'capitalize',
                'text_decoration'    => 'none'
            ],
            'sidebar_post_title_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 17,
                    'smartphone' => 17
                ],
                'line_height'   => [
                    'desktop' => 25,
                    'tablet' => 25,
                    'smartphone' => 25,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_category_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 12,
                    'tablet' => 12,
                    'smartphone' => 12
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.5,
                    'tablet' => 0.5,
                    'smartphone' => 0.5
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_date_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 12,
                    'tablet' => 12,
                    'smartphone' => 12
                ],
                'line_height'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_heading_one_typography'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 30,
                    'tablet' => 30,
                    'smartphone' => 30
                ],
                'line_height'   => [
                    'desktop' => 38,
                    'tablet' => 38,
                    'smartphone' => 38,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_heading_two_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ],
                'line_height'   => [
                    'desktop' => 36,
                    'tablet' => 36,
                    'smartphone' => 36,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_heading_three_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22
                ],
                'line_height'   => [
                    'desktop' => 30,
                    'tablet' => 30,
                    'smartphone' => 30,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_heading_four_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 20,
                    'tablet' => 20,
                    'smartphone' => 20
                ],
                'line_height'   => [
                    'desktop' => 38,
                    'tablet' => 28,
                    'smartphone' => 28,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_heading_five_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 18,
                    'tablet' => 18,
                    'smartphone' => 18
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.2,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_heading_six_typo'  =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700 Italic', 'variant' => 'italic' ],
                'font_size'   => [
                    'desktop' => 16,
                    'tablet' => 16,
                    'smartphone' => 16
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'sidebar_pagination_button_typo'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '500', 'label' => 'Medium 500', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 13,
                    'tablet' => 13,
                    'smartphone' => 13
                ],
                'line_height'   => [
                    'desktop' => 13,
                    'tablet' => 13,
                    'smartphone' => 13
                ],
                'letter_spacing'   => [
                    'desktop' => 0,
                    'tablet' => 0,
                    'smartphone' => 0
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none',
            ],
            'advertisement_repeater'   =>  json_encode([
                [
                    'item_image'    => 0,
                    'item_url'      => home_url(),
                    'item_option'   => 'show',
                    'item_target'   =>  '_blank',
                    'item_rel_attribute'    =>  'nofollow',
                    'item_heading'  =>  esc_html__( 'Display Area', 'blogistic' ),
                    'item_checkbox_header'  =>  false,
                    'item_checkbox_before_post_content'  => false,
                    'item_checkbox_after_post_content'  =>  false,
                    'item_checkbox_random_post_archives'  =>    false,
                    'item_checkbox_stick_with_footer'  =>   false,
                    'item_alignment'    =>  'center',
                    'item_image_option' =>  'original'
                ],
                [
                    'item_image'    => 0,
                    'item_url'      => home_url(),
                    'item_option'   => 'show',
                    'item_target'   =>  '_blank',
                    'item_rel_attribute'    =>  'nofollow',
                    'item_heading'  =>  esc_html__( 'Display Area', 'blogistic' ),
                    'item_checkbox_header'  =>  false,
                    'item_checkbox_before_post_content'  => false,
                    'item_checkbox_after_post_content'  =>  false,
                    'item_checkbox_random_post_archives'  =>    false,
                    'item_checkbox_stick_with_footer'  =>   false,
                    'item_alignment'    =>  'center',
                    'item_image_option' =>  'original'
                ]
            ]),
            'blogdescription_option'    =>  false,
            'footer_title_typography'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '700', 'label' => 'Bold 700', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24
                ],
                'line_height'   => [
                    'desktop' => 36,
                    'tablet' => 36,
                    'smartphone' => 36,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'footer_text_typography'    =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 14,
                    'tablet' => 14,
                    'smartphone' => 14
                ],
                'line_height'   => [
                    'desktop' => 22,
                    'tablet' => 22,
                    'smartphone' => 22,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'footer_text_color' =>  '#ffffff',
            'footer_title_color'    =>   [ 'color' => '#ffffff', 'hover' => '#ffffff' ],
            'footer_background_color'   =>  json_encode([
                'type'  => 'solid',
                'solid' => '#000',
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'footer_border_top'    => [ "type"  => "none", "width"   => 1, "color"   => "#7E43FD" ],
            'bottom_footer_text_typography'    => [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'bottom_footer_link_typography'    =>  [
                'font_family'   => [ 'value' => '', 'label' => '' ],
                'font_weight'   => [ 'value' => '400', 'label' => 'Regular 400', 'variant' => 'normal' ],
                'font_size'   => [
                    'desktop' => 15,
                    'tablet' => 15,
                    'smartphone' => 15
                ],
                'line_height'   => [
                    'desktop' => 24,
                    'tablet' => 24,
                    'smartphone' => 24,
                ],
                'letter_spacing'   => [
                    'desktop' => 0.3,
                    'tablet' => 0.3,
                    'smartphone' => 0.3
                ],
                'text_transform'    => 'unset',
                'text_decoration'    => 'none'
            ],
            'bottom_footer_text_color' =>  '#8C8C8C',
            'bottom_footer_link_color'    =>   [ 'color' => '#ffffff', 'hover' => '#ffffff' ],
            'bottom_footer_background_color'   =>  json_encode([
                'type'  => 'solid',
                'solid' => '#171717',
                'gradient'  => null,
                'image'     => [ 'media_id' => 0, 'media_url' => '' ]
            ]),
            'bottom_footer_border_top'    => [ "type"  => "none", "width"   => 1, "color"   => "#FF376C" ],
            'bottom_footer_padding' =>  [ 
                'desktop' => [ 'top' => 60, 'right' => 0, 'bottom' => 60, 'left' => 0, 'link' => true ],
                'tablet' => [ 'top' => 60, 'right' => 0, 'bottom' => 60, 'left' => 0, 'link' => true ],
                'smartphone' => [ 'top' => 60, 'right' => 0, 'bottom' => 60, 'left' => 0, 'link' => true ]
            ],
        ]);
        $totalCats = get_categories();
        if( $totalCats ) :
            foreach( $totalCats as $singleCat ) :
                $array_defaults['category_' .absint($singleCat->term_id). '_color'] = ['color'   => "#fff", 'hover'   => "#fff"];
                $array_defaults['category_background_' .absint($singleCat->term_id). '_color'] = json_encode([
                    'initial'    => [
                            'type'  => 'solid',
                            'solid' => '--blogistic-global-preset-theme-color',
                            'gradient' => null
                    ],
                    'hover'    => [
                        'type'  => 'solid',
                        'solid' => '#7e43fd',
                        'gradient' => null
                    ]
                ]);
            endforeach;
        endif;
        $totalTags = get_tags();
        if( $totalTags ) :
            foreach( $totalTags as $singleTag ) :
                $array_defaults['tag_' .absint($singleTag->term_id). '_color'] = ['color'   => "#fff", 'hover'   => "#fff"];
                $array_defaults['tag_background_' .absint($singleTag->term_id). '_color'] = json_encode([
                    'initial'    => [
                            'type'  => 'solid',
                            'solid' => '--blogistic-global-preset-theme-color',
                            'gradient' => null
                    ],
                    'hover'    => [
                        'type'  => 'solid',
                        'solid' => '#EC5F01',
                        'gradient' => null
                    ]
                ]);
            endforeach;
        endif;
        return $array_defaults[$key];
    }
endif;
