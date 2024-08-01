<?php
/**
 * Handles the customizer additional functionality.
 */
if( !function_exists( 'blogistic_customizer_up_panel' ) ) :
    /**
     * Register controls for upsell, notifications and addtional info.
     * 
     */
    function blogistic_customizer_up_panel( $wp_customize ) {
        // upgrade info box
        $wp_customize->add_setting( 'preloader_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'preloader_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'blogistic' ),
                'description' => esc_html__( 'More effects, display option and background color field', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'preloader_section',
                'priority'  => 200,
                'settings'    => 'preloader_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'social_icons_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'social_icons_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'blogistic' ),
                'description' => esc_html__( 'Unlimited social icons items with unlimited choices', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'social_icons_section',
                'priority'  => 200,
                'settings'    => 'social_icons_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'animation_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'animation_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'blogistic' ),
                'description' => esc_html__( 'AOS animation, more effects and animations', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'animation_section',
                'priority'  => 200,
                'settings'    => 'animation_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'button_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'button_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'blogistic' ),
                'description' => esc_html__( 'Custom Label, custom icon, icon size, icon color, background color, border radius, box shadow and more styles', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'buttons_section',
                'priority'  => 200,
                'settings'    => 'button_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'stt_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'stt_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'blogistic' ),
                'description' => esc_html__( 'Custom Label, custom icon, icon size, icon color, background color, border radius, box shadow and more styles', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'stt_options_section',
                'priority'  => 200,
                'settings'    => 'stt_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'advertisement_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'advertisement_upgrade_info', array(
                'label'	      => esc_html__( 'More Features', 'blogistic' ),
                'description' => esc_html__( 'Any numbers of ads you would like to add', 'blogistic' ),
                'section'     => 'advertisement_section',
                'priority'  => 200,
                'settings'    => 'advertisement_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'typography_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'typography_upgrade_info', array(
                'label'	      => esc_html__( '600+ google fonts', 'blogistic' ),
                'description' => esc_html__( 'More than 600+ google fonts', 'blogistic' ),
                'section'     => 'typography_section',
                'priority'  => 200,
                'settings'    => 'typography_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'typography_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'typography_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'You will find more elements option to hide in premium version', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'mobile_options_section',
                'priority'  => 200,
                'settings'    => 'typography_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'top_header_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'top_header_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Social icons hover animation, colors, border bottom and elements colors', 'blogistic' ),
                'section'     => 'top_header_section',
                'priority'  => 200,
                'tab'  => 'design',
                'settings'    => 'top_header_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'top_header_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'top_header_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '3 header layouts, sticky header, vertical padding, margin and more style options', 'blogistic' ),
                'section'     => 'theme_header_general_settings_section',
                'priority'  => 200,
                'settings'    => 'top_header_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'menu_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'menu_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Menu background, sub menu styling options, more menu hover effects', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'header_menu_options_section',
                'priority'  => 200,
                'settings'    => 'menu_upgrade_info',
                'tab'   => 'design',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'search_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'search_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Live search, icon size, more styling options', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'header_live_search_section',
                'priority'  => 200,
                'settings'    => 'search_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'custom_button_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'custom_button_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Icon picker, icon size, icon distance, animation type, border, box shadow, padding and more', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'custom_button_section',
                'priority'  => 200,
                'settings'    => 'custom_button_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'theme_mode_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'theme_mode_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Icon picker, set dark mode as default, icons colors', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'theme_mode_section',
                'priority'  => 200,
                'settings'    => 'theme_mode_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'canvas_menu_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'canvas_menu_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Off canvas position, width, and more styling options', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'canvas_menu_section',
                'priority'  => 200,
                'settings'    => 'canvas_menu_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'main_banner_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'main_banner_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '2 layouts, Posts to exclude, offset, more posts order with modified date order, posts tags and content background', 'blogistic' ),
                'section'     => 'main_banner_section',
                'priority'  => 200,
                'settings'    => 'main_banner_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'carousel_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'carousel_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '2 layouts, Posts to exclude, offset, more posts order with modified date order, posts tags', 'blogistic' ),
                'section'     => 'carousel_section',
                'priority'  => 200,
                'settings'    => 'carousel_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'category_collection_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'category_collection_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '2 layouts, carousel settings and more', 'blogistic' ),
                'section'     => 'category_collection_section',
                'priority'  => 200,
                'settings'    => 'category_collection_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'archive_general_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'archive_general_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '3 more layouts, title html tags, meta icon picker, image border radius, box shadow and more styling options', 'blogistic' ),
                'section'     => 'archive_general_section',
                'priority'  => 200,
                'settings'    => 'archive_general_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'category_archive_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'category_archive_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Title html tags, meta icon picker, meta show hide, box shadow and more styling options', 'blogistic' ),
                'section'     => 'category_archive_section',
                'priority'  => 200,
                'settings'    => 'category_archive_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'tag_archive_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'tag_archive_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Title html tags, meta icon picker, meta show hide, box shadow and more styling options', 'blogistic' ),
                'section'     => 'tag_archive_section',
                'priority'  => 200,
                'settings'    => 'tag_archive_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'author_archive_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'author_archive_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Title html tags, meta icon picker, meta show hide, box shadow and more styling options', 'blogistic' ),
                'section'     => 'author_archive_section',
                'priority'  => 200,
                'settings'    => 'author_archive_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'blog_single_general_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'blog_single_general_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '3 more layouts, title html tags, meta icon picker, meta sortable, image border radius, box shadow and more styling options', 'blogistic' ),
                'section'     => 'blog_single_general_settings',
                'priority'  => 200,
                'settings'    => 'blog_single_general_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'blog_single_elements_settings_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'blog_single_elements_settings_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'post html tags, icon picker, and table of content settings', 'blogistic' ),
                'section'     => 'blog_single_elements_settings_section',
                'priority'  => 200,
                'settings'    => 'blog_single_elements_settings_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'blog_single_related_posts_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'blog_single_related_posts_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '2 layouts, meta show hide options, number of columns and filter by categories, tags', 'blogistic' ),
                'section'     => 'blog_single_related_posts_section',
                'priority'  => 200,
                'settings'    => 'blog_single_related_posts_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'you_may_have_missed_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'you_may_have_missed_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( '2 layouts, posts to exclude, posts by author, posts by tags, meta show hide options, image border radius, box shadow', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'customizer_you_may_have_missed_section',
                'priority'  => 200,
                'settings'    => 'you_may_have_missed_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'footer_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'block title color, text color, background color, border top', 'blogistic' ),
                'section'     => 'footer_section',
                'priority'  => 200,
                'tab'  => 'design',
                'settings'    => 'footer_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );

        // upgrade info box
        $wp_customize->add_setting( 'bottom_footer_upgrade_info', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'bottom_footer_upgrade_info', array(
                'label'	      => esc_html__( 'More features', 'blogistic' ),
                'description' => esc_html__( 'Full copyright editor, site logo fields, background color, section padding, border top and more styling options', 'blogistic' ),
                'section'     => 'bottom_footer_section',
                'priority'  => 200,
                'settings'    => 'bottom_footer_upgrade_info',
                'choices' => array(
                    array(
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro/' )
                    )
                )
            ))
        );
    }
    add_action( 'customize_register', 'blogistic_customizer_up_panel', 20 );
endif;