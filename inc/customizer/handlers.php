<?php
use Blogistic\CustomizerDefault as BIT;

/**
 * Binds JS handlers to make theme customizer preview reload changes asynchronously
 */
add_action( 'customize_preview_init', function() {
    wp_enqueue_script(
        'blogistic-customizer-preview',
        get_template_directory_uri() .'/inc/customizer/assets/customizer-preview.min.js',
        ['customize-preview'],
        BLOGISTIC_VERSION,
        true
    );

    // localize scripts
    wp_localize_script(
        'blogistic-customizer-preview',
        'blogisticPreviewObject', 
        [
            '_wpnonce'  =>  wp_create_nonce( 'blogistic-customizer-nonce' ),
            'ajaxUrl'   =>  admin_url( 'admin-ajax.php' ),
            'totalCats' => get_categories() ? get_categories() : [],
            'totalTags' => get_tags() ? get_tags() : []
        ]
    );
});

add_action( 'customize_controls_enqueue_scripts', function(){
    $buildControlsDeps = apply_filters(  'blogistic_customizer_build_controls_dependencies', 
        [
            'react',
            'wp-blocks',
            'wp-editor',
            'wp-element',
            'wp-i18n',
            'wp-polyfill',
            'jquery',
            'wp-components'
        ]
    );

    wp_enqueue_style(
        'blogistic-customizer-control',
        get_template_directory_uri() .'/inc/customizer/assets/customizer-controls.min.css',
        ['wp-components'],
        BLOGISTIC_VERSION,
        'all'
    );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() .'/assets/external/fontawesome/css/all.min.css', [], '6.4.2', 'all' );

    wp_enqueue_script(
        'blogistic-customizer-control',
        get_template_directory_uri() .'/inc/customizer/assets/customizer-extends.min.js',
        $buildControlsDeps,
        BLOGISTIC_VERSION,
        true
    );

    wp_enqueue_script( 
        'customizer-customizer-extras',
        get_template_directory_uri() . '/inc/customizer/assets/extras.js',
        [ 'jquery', 'customize-controls' ],
        BLOGISTIC_VERSION,
        true
    );

    wp_localize_script(
        'blogistic-customizer-control',
        'customizerControlsObject', [
            'categories'    =>  blogistic_get_multicheckbox_categories_simple_array(),
            'tags'  =>  blogistic_get_multicheckbox_tags_simple_array(),
            'users' =>  blogistic_get_multicheckbox_users_simple_array(),
            'posts' =>  blogistic_get_multicheckbox_posts_simple_array(),
            '_wpnonce'  =>  wp_create_nonce( 'blogistic-customizer-controls-live-nonce' ),
            'ajaxUrl'   =>  admin_url( 'admin-ajax.php' )
        ]
    );
});

if( !function_exists( 'blogistic_customizer_about_theme_panel' ) ) :
    /**
     * Register blog archive section settings
     * 
     */
    function blogistic_customizer_about_theme_panel( $wp_customize ) {
        /**
         * About theme section
         * 
         * @since 1.0.0
         */
        $wp_customize->add_section( BLOGISTIC_PREFIX . 'about_section', [
            'title' => esc_html__( 'About Theme', 'blogistic' ),
            'priority'  => 1
        ]);

        // theme documentation info box
        $wp_customize->add_setting( 'site_documentation_info', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'site_documentation_info', [
                'label'	      => esc_html__( 'Theme Documentation', 'blogistic' ),
                'description' => esc_html__( 'We have well prepared documentation which includes overall instructions and recommendations that are required in this theme.', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'about_section',
                'settings'    => 'site_documentation_info',
                'choices' => [
                    [
                        'label' => esc_html__( 'View Documentation', 'blogistic' ),
                        'url'   => esc_url( '//doc.blazethemes.com/blogistic' )
                    ]
                ]
            ])
        );

        // theme documentation info box
        $wp_customize->add_setting( 'site_support_info', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'site_support_info', [
                'label'	      => esc_html__( 'Theme Support', 'blogistic' ),
                'description' => esc_html__( 'We provide 24/7 support regarding any theme issue. Our support team will help you to solve any kind of issue. Feel free to contact us.', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'about_section',
                'settings'    => 'site_support_info',
                'choices' => [
                    [
                        'label' => esc_html__( 'Support Form', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/support' )
                    ]
                ]
            ])
        );

        // upsell info box
        $wp_customize->add_setting( 'premium_version_info', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Info_Box_Control( $wp_customize, 'premium_version_info', [
                'label'	      => esc_html__( 'Premium Version', 'blogistic' ),
                'description' => esc_html__( 'With premium version you will get unlimited features, premium addons and dedicated support.', 'blogistic' ),
                'section'     => BLOGISTIC_PREFIX . 'about_section',
                'settings'    => 'premium_version_info',
                'choices' => [
                    [
                        'label' => esc_html__( 'View Premium', 'blogistic' ),
                        'url'   => esc_url( '//blazethemes.com/theme/blogistic-pro' )
                    ]
                ]
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_customizer_about_theme_panel', 10 );
endif;

if( ! function_exists( 'blogistic_customizer_site_identity_panel' ) ) :
    /**
     * Register site identity settings
     */
    function blogistic_customizer_site_identity_panel( $wp_customize ) {
        /**
         * Register "Site Identity Options" panel
         */
        $wp_customize->add_panel( 'blogistic_site_identity_panel', [
            'title' =>  esc_html__( 'Site Identity', 'blogistic' ),
            'priority'  =>  6
        ]);

        $wp_customize->get_section( 'title_tagline' )->panel = 'blogistic_site_identity_panel';
        $wp_customize->get_section( 'title_tagline' )->title = esc_html__( 'Logo & Site Icon', 'blogistic' );

        $wp_customize->add_setting( 'blogistic_site_logo_width', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_site_logo_width' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'blogistic_site_logo_width',[
                'label' =>  esc_html__( 'Logo Width (px)', 'blogistic' ),
                'section'   =>  'title_tagline',
                'settings'  =>  'blogistic_site_logo_width',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'max'   =>  400,
                    'min'   =>  100,
                    'step'  =>  1,
                    'reset' =>  true
                ],
                'responsive'    =>  true
            ])
        );

        $wp_customize->add_section( 'blogistic_site_title_section', [
            'title' =>  esc_html__( 'Site Title & Tagline', 'blogistic' ),
            'panel' =>  'blogistic_site_identity_panel',
            'priority'  =>  30
        ]);

        // site title tag - for frontpage
        $wp_customize->add_setting( 'site_title_tag_for_frontpage', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'site_title_tag_for_frontpage' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'site_title_tag_for_frontpage', [
            'label'   =>  esc_html__( 'Site Title Tag (For Frontpage)', 'blogistic' ),
            'type'  =>  'select',
            'section'   =>  'blogistic_site_title_section',
            'settings'  =>  'site_title_tag_for_frontpage',
            'choices'   =>  [
                'h1'    =>  esc_html__( 'H1', 'blogistic' ),
                'h2'    =>  esc_html__( 'H2', 'blogistic' ),
                'h3'    =>  esc_html__( 'H3', 'blogistic' ),
                'h4'    =>  esc_html__( 'H4', 'blogistic' ),
                'h5'    =>  esc_html__( 'H5', 'blogistic' ),
                'h6'    =>  esc_html__( 'H6', 'blogistic' )
            ]
        ]);

        // site title tag - for innerpage
        $wp_customize->add_setting( 'site_title_tag_for_innerpage', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'site_title_tag_for_innerpage' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'site_title_tag_for_innerpage', [
            'label'   =>  esc_html__( 'Site Title Tag (For Innerpage)', 'blogistic' ),
            'type'  =>  'select',
            'section'   =>  'blogistic_site_title_section',
            'settings'  =>  'site_title_tag_for_innerpage',
            'choices'   =>  [
                'h1'    =>  esc_html__( 'H1', 'blogistic' ),
                'h2'    =>  esc_html__( 'H2', 'blogistic' ),
                'h3'    =>  esc_html__( 'H3', 'blogistic' ),
                'h4'    =>  esc_html__( 'H4', 'blogistic' ),
                'h5'    =>  esc_html__( 'H5', 'blogistic' ),
                'h6'    =>  esc_html__( 'H6', 'blogistic' )
            ]
        ]);

        $wp_customize->get_control( 'blogname' )->section = 'blogistic_site_title_section';
        $wp_customize->get_control( 'blogdescription' )->section = 'blogistic_site_title_section';
        $wp_customize->get_control( 'display_header_text' )->section = 'blogistic_site_title_section';
        $wp_customize->get_control( 'display_header_text' )->label = esc_html__( 'Display site title', 'blogistic' );
        
        $wp_customize->add_setting( 'site_title_section_tab', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'site_title_section_tab', [
                'section'   =>  'blogistic_site_title_section',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // blog description option
        $wp_customize->add_setting( 'blogdescription_option', [
            'default'   =>  false,
            'sanitize_callback' =>  'blogistic_sanitize_checkbox',
            'transport' =>  'postMessage'
        ]);
        
        $wp_customize->add_control( 'blogdescription_option', [
            'label' =>  esc_html__( 'Display site description', 'blogistic' ),
            'section'   =>  'blogistic_site_title_section',
            'type'  =>  'checkbox',
            'priority'  =>  50
        ]);

        $wp_customize->get_control( 'header_textcolor' )->section = 'blogistic_site_title_section';
        $wp_customize->get_control( 'header_textcolor' )->priority = 60;
        $wp_customize->get_control( 'header_textcolor' )->label = esc_html__( 'Site Title Color', 'blogistic' );

        //header text hover color
        $wp_customize->add_setting( 'site_title_hover_textcolor', [
            'sanitize_callback' =>  'sanitize_hex_color',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Default_Color_Control( $wp_customize, 'site_title_hover_textcolor', [
                'label' =>  esc_html__( 'Site Title Hover Color', 'blogistic' ),
                'section'   =>  'blogistic_site_title_section',
                'settings'  =>  'site_title_hover_textcolor',
                'priority'  =>  70,
                'tab'   =>  'design'
            ])
        );

        // site description color
        $wp_customize->add_setting( 'site_description_color', [
            'sanitize_callback' =>  'sanitize_hex_color',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Default_Color_Control( $wp_customize, 'site_description_color', [
                'label' =>  esc_html__( 'Site Description Color', 'blogistic' ),
                'section'   =>  'blogistic_site_title_section',
                'settings'  =>  'site_description_color',
                'priority'  =>  70,
                'tab'   =>  'design'
            ])
        );

        // site title typo
        $wp_customize->add_setting( 'site_title_typo', [
            'default'   => BIT\blogistic_get_customizer_default( 'site_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'site_title_typo', [
                'label' =>  esc_html__( 'Site Title Typography', 'blogistic' ),
                'section'   =>  'blogistic_site_title_section',
                'settings'  =>  'site_title_typo',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        $wp_customize->add_setting( 'site_description_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'site_description_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'site_description_typo', [
                'label' =>  esc_html__( 'Site Description Typography', 'blogistic' ),
                'section'   =>  'blogistic_site_title_section',
                'settings'  =>  'site_description_typo',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ],
                'tab'   =>  'design'
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_customizer_site_identity_panel' );
endif;

if( ! function_exists( 'blogistic_top_header_panel' ) ) :
    /**
     * Function for top header panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_top_header_panel( $wp_customize ) {
        $wp_customize->add_section( 'top_header_section', [
            'title' =>  esc_html__( 'Top Header', 'blogistic' ),
            'priority'  =>  40
        ]);

        // top header section heading
        $wp_customize->add_setting( 'top_header_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( 
                $wp_customize,
                'top_header_section_heading', 
                [
                    'section'   =>  'top_header_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // Top header option
        $wp_customize->add_setting( 'top_header_option', [
            'default'         => BIT\blogistic_get_customizer_default( 'top_header_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
    
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'top_header_option', [
                'label'	      => esc_html__( 'Show top header', 'blogistic' ),
                'description' => esc_html__( 'Toggle to enable or disable top header bar', 'blogistic' ),
                'section'     => 'top_header_section',
                'settings'    => 'top_header_option'
            ])
        );

        // Top header date time option
        $wp_customize->add_setting( 'top_header_date_time_option', [
            'default'         => BIT\blogistic_get_customizer_default( 'top_header_date_time_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'top_header_date_time_option', [
                'label'	      => esc_html__( 'Show date and time', 'blogistic' ),
                'section'     => 'top_header_section',
                'settings'    => 'top_header_date_time_option',
            ])
        );

        // top header social option
        $wp_customize->add_setting( 'top_header_social_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'top_header_social_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'top_header_social_option', [
                'label'	      => esc_html__( 'Show social icons', 'blogistic' ),
                'section'     => 'top_header_section',
                'settings'    => 'top_header_social_option',
            ])
        );

        // Redirect header social icons link
        $wp_customize->add_setting( 'top_header_social_icons_redirects', [
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Redirect_Control( $wp_customize, 'top_header_social_icons_redirects', [
                'section'     => 'top_header_section',
                'settings'    => 'top_header_social_icons_redirects',
                'choices'     => [
                    'header-social-icons' => [
                        'type'  => 'section',
                        'id'    => 'blogistic_social_icons_section',
                        'label' => esc_html__( 'Manage social icons', 'blogistic' )
                    ]
                ]
            ])
        );

        // top header show search
        $wp_customize->add_setting( 'top_header_show_search', [
            'default'   => BIT\blogistic_get_customizer_default( 'top_header_show_search' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'top_header_show_search', [
                'label'	      => esc_html__( 'Show search', 'blogistic' ),
                'section'     => 'top_header_section',
                'settings'    => 'top_header_show_search',
            ])
        );

        // Top header section background
        $wp_customize->add_setting( 'top_header_section_background', [
            'default'   => BIT\blogistic_get_customizer_default( 'top_header_section_background' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Color_Group_Control( $wp_customize, 'top_header_section_background', [
                'label'	      => esc_html__( 'Section Background', 'blogistic' ),
                'section'     => 'top_header_section',
                'settings'    => 'top_header_section_background',
                'tab'   => 'design'
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_top_header_panel' );
endif;

if( ! function_exists( 'blogistic_theme_header_panel' ) ) :
    /**
     * This is function for theme header panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_theme_header_panel( $wp_customize ) {
        $wp_customize->add_panel( 'blogistic_theme_header_panel', [
            'title' =>  esc_html__( 'Theme Header', 'blogistic' ),
            'priority'  =>  50
        ]);

        // General settings section
        $wp_customize->add_section( 'theme_header_general_settings_section', [
            'panel' =>  'blogistic_theme_header_panel',
            'title' =>  esc_html__( 'General Settings', 'blogistic' ),
            'priority'  =>  50
        ]);

        // header section tab
        $wp_customize->add_setting( 'header_general_section_tab', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'header_general_section_tab', [
                'section'   =>  'theme_header_general_settings_section',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // menu option - sticky header
        $wp_customize->add_setting( 'menu_options_sticky_header', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'menu_options_sticky_header' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'menu_options_sticky_header', [
                'label'	      => esc_html__( 'Enable Header Section Sticky', 'blogistic' ),
                'section'     => 'theme_header_general_settings_section'
            ])
        );

        // header re-order for layout one
        $wp_customize->add_setting( 'header_sortable_options', [
            'default'   => BIT\blogistic_get_customizer_default( 'header_sortable_options' ),
            'sanitize_callback' => 'blogistic_sanitize_sortable_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Item_Sortable_Control( $wp_customize, 'header_sortable_options', [
                'label'         => esc_html__( 'Header re-order', 'blogistic' ),
                'section'       => 'theme_header_general_settings_section',
                'settings'      => 'header_sortable_options',
                'fields'    => [
                    'site-branding'  => [
                        'label' => esc_html__( 'Site branding', 'blogistic' ),
                        'focusable_control' =>  'site_title_section_tab'
                    ],
                    'nav-menu'  => [
                        'label' => esc_html__( 'Menu', 'blogistic' ),
                        'focusable_control' =>  'menu_options_menu_alignment'
                    ],
                    'custom-button'  => [
                        'label' => esc_html__( 'Custom button', 'blogistic' ),
                        'focusable_control' =>  'blogistic_header_custom_button_option'
                    ],
                    'search'  => [
                        'label' => esc_html__( 'Search', 'blogistic' ),
                        'focusable_control' =>  'blogistic_header_live_search_option'
                    ],
                    'theme-mode'  => [
                        'label' => esc_html__( 'Theme mode', 'blogistic' ),
                        'focusable_control' =>  'blogistic_theme_mode_option'
                    ],
                    'off-canvas'  => [
                        'label' => esc_html__( 'Off canvas', 'blogistic' ),
                        'focusable_control' =>  'canvas_menu_enable_disable_option'
                    ]
                ]
            ])
        );

        // header background color
        $wp_customize->add_setting( 'header_background', [
            'default'   => BIT\blogistic_get_customizer_default( 'header_background' ),
            'sanitize_callback' => 'blogistic_sanitize_color_image_group_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Color_Image_Group_Control( $wp_customize, 'header_background', [
                'label' => esc_html__( 'Background', 'blogistic' ),
                'section'   => 'theme_header_general_settings_section',
                'tab'   => 'design'
            ])
        );

        // header top and bottom padding
        $wp_customize->add_setting( 'header_vertical_padding', [
            'default'   => BIT\blogistic_get_customizer_default( 'header_vertical_padding' ),
            'sanitize_callback' => 'blogistic_sanitize_responsive_range',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'header_vertical_padding', [
                'label'	      => esc_html__( 'Vertical Padding (px)', 'blogistic' ),
                'section'     => 'theme_header_general_settings_section',
                'settings'    => 'header_vertical_padding',
                'unit'        => 'px',
                'tab'   => 'design',
                'input_attrs' => [
                    'max'         => 500,
                    'min'         => 0,
                    'step'        => 1,
                    'reset' => true
                ],
                'responsive'    =>  true
            ])
        );

        // Menu Options Section
        $wp_customize->add_section( 'blogistic_header_menu_options_section', [
            'panel' =>  'blogistic_theme_header_panel',
            'title' =>  esc_html__( 'Menu Options', 'blogistic' ),
            'priority'  =>  50
        ]);
        $wp_customize->add_setting( 'blogistic_header_menu_typography', [
            'default'   =>  'design',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'blogistic_header_menu_typography', [
                'label' =>  esc_html__( 'Typography', 'blogistic' ),
                'section'   =>  'blogistic_header_menu_options_section',
                'settings'  =>  'blogistic_header_menu_typography',
                'choices'   =>  [
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ],
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ]
                ]
            ])
        );

        // menu option - menu alignments
        $wp_customize->add_setting( 'menu_options_menu_alignment', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'menu_options_menu_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'menu_options_menu_alignment', [
                'label'	      => esc_html__( 'Elements Alignment', 'blogistic' ),
                'section'     => 'blogistic_header_menu_options_section',
                'choices' => [
                    [
                        'value' => 'left',
                        'label' => esc_html__('Left', 'blogistic' )
                    ],
                    [
                        'value' => 'center',
                        'label' => esc_html__('Center', 'blogistic' )
                    ],
                    [
                        'value' => 'right',
                        'label' => esc_html__('Right', 'blogistic' )
                    ]
                ]
            ])
        );

        // menu option hover effects
        $wp_customize->add_setting( 'blogistic_header_menu_hover_effect', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_header_menu_hover_effect' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 'blogistic_header_menu_hover_effect', [
                'label' =>  esc_html__( 'Hover Effect', 'blogistic' ),
                'section'   =>  'blogistic_header_menu_options_section',
                'type'  =>  'select',
                'settings'  =>  'blogistic_header_menu_hover_effect',
                'choices'   =>  [
                    'none'  =>  esc_html__( 'None', 'blogistic' ),
                    'one'  =>  esc_html__( 'Effect 1', 'blogistic' ),
                    'two'  =>  esc_html__( 'Effect 2', 'blogistic' )
                ]
            ]
        );

        // header menu cutoff heading
        $wp_customize->add_setting( 'header_menu_cutoff_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'header_menu_cutoff_header', [
                'label' => esc_html__( 'Menu Cutoff Setting', 'blogistic' ),
                'section'   => 'blogistic_header_menu_options_section',
                'tab'   => 'general'
            ])
        );

        // menu cutoff option
        $wp_customize->add_setting( 'menu_cutoff_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'menu_cutoff_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'menu_cutoff_option', [
                'label'	      => esc_html__( 'Enable menu cutoff', 'blogistic' ),
                'section'     => 'blogistic_header_menu_options_section',
                'tab'   => 'general'
            ])
        );

        // menu cutoff after
        $wp_customize->add_setting( 'menu_cutoff_after', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'menu_cutoff_after' ),
            'sanitize_callback' =>  'absint'
        ]);
        $wp_customize->add_control( 'menu_cutoff_after', [
            'label' =>  esc_html( 'Menu cutoff up to', 'blogistic' ),
            'type'  =>  'number',
            'section'   =>  'blogistic_header_menu_options_section',
            'tab'   => 'general',
            'input_attrs' => [
                'max'   => 100,
                'min'   => 1,
                'step'  => 1,
                'reset' => true
            ]
        ]);

        // menu cutoff more text
        $wp_customize->add_setting( 'menu_cutoff_text', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'menu_cutoff_text' ),
            'sanitize_callback'  =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control( 'menu_cutoff_text', [
            'label' =>  esc_html__( 'Menu cutoff more text', 'blogistic' ),
            'section'   =>  'blogistic_header_menu_options_section',
            'type'  =>  'text',
            'tab'   => 'general'
        ]);

        // main banner menu options main menu text typography
        $wp_customize->add_setting( 'main_menu_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_menu_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_menu_typo', [
                'label' =>  esc_html__( 'Main Menu Typography', 'blogistic' ),
                'section'   =>  'blogistic_header_menu_options_section',
                'settings'  =>  'main_menu_typo',
                'tab'   =>  'design'
            ])
        );

        // main banner menu options sub menu text typography
        $wp_customize->add_setting( 'main_menu_sub_menu_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_menu_sub_menu_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_menu_sub_menu_typo', [
                'label' =>  esc_html__( 'Sub Menu Typography', 'blogistic' ),
                'section'   =>  'blogistic_header_menu_options_section',
                'settings'  =>  'main_menu_sub_menu_typo',
                'tab'   =>  'design'
            ])
        );

        // theme header menu options text color
        $wp_customize->add_setting( 'header_menu_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'header_menu_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'header_menu_color', [
                'label'     => esc_html__( 'Text Color', 'blogistic' ),
                'section'   => 'blogistic_header_menu_options_section',
                'settings'  => 'header_menu_color',
                'tab'   => 'design'
            ])
        );

        // header sub menu heading
        $wp_customize->add_setting( 'header_sub_menu_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'header_sub_menu_header', [
                'label' => esc_html__( 'Sub Menu', 'blogistic' ),
                'section'   => 'blogistic_header_menu_options_section',
                'tab'   => 'design'
            ])
        );

        // theme header menu options text color
        $wp_customize->add_setting( 'header_sub_menu_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'header_sub_menu_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'header_sub_menu_color', [
                'label'     => esc_html__( 'Text Color', 'blogistic' ),
                'section'   => 'blogistic_header_menu_options_section',
                'settings'  => 'header_sub_menu_color',
                'tab'   => 'design'
            ])
        );

        // Live Search Section
        $wp_customize->add_section( 'blogistic_header_live_search_section', [
            'panel' =>  'blogistic_theme_header_panel',
            'title' =>  esc_html__( 'Search', 'blogistic' ),
            'priority'  =>  50
        ]);

        // search section tab
        $wp_customize->add_setting( 'search_section_tab', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'search_section_tab', [
                'section'   =>  'blogistic_header_live_search_section',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // enable search option 
        $wp_customize->add_setting( 'blogistic_header_live_search_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_header_live_search_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_control( $wp_customize, 'blogistic_header_live_search_option', [
                'label' =>  esc_html__( 'Enable Search', 'blogistic' ),
                'section'   =>  'blogistic_header_live_search_section',
                'settings'  =>  'blogistic_header_live_search_option'
            ])
        );

        // search icon color
        $wp_customize->add_setting( 'blogistic_search_icon_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_search_icon_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'blogistic_search_icon_color', [
                'label'     => esc_html__( 'Icon Color', 'blogistic' ),
                'section'   => 'blogistic_header_live_search_section',
                'settings'  => 'blogistic_search_icon_color',
                'tab'   =>  'design'
            ])
        );

        // Custom Button Section
        $wp_customize->add_section( 'blogistic_custom_button_section', [
            'panel' =>  'blogistic_theme_header_panel',
            'title' =>  esc_html__( 'Custom Button', 'blogistic' ),
            'priority'  =>  50
        ]);
        $wp_customize->add_setting( 'blogistic_custom_button_section_tab', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'blogistic_custom_button_section_tab', [
                'section'   =>  'blogistic_custom_button_section',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );
        $wp_customize->add_setting( 'blogistic_header_custom_button_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_header_custom_button_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Toggle_Control( $wp_customize, 'blogistic_header_custom_button_option', [
                'label' =>  esc_html__( 'Show Custom Button', 'blogistic' ),
                'section'   =>  'blogistic_custom_button_section',
                'settings'  =>  'blogistic_header_custom_button_option'
            ])
        );

        // custom button - button label
        $wp_customize->add_setting( 'blogistic_custom_button_label', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_custom_button_label' ),
            'sanitize_callback'  =>  'sanitize_text_field',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 'blogistic_custom_button_label', [
            'label' =>  esc_html__( 'Button Label', 'blogistic' ),
            'section'   =>  'blogistic_custom_button_section',
            'settings'  =>  'blogistic_custom_button_label',
            'type'  =>  'text'
        ]);

        // custom button - redirect url
        $wp_customize->add_setting( 'blogistic_custom_button_redirect_href_link', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_custom_button_redirect_href_link' ),
            'sanitize_callback'  =>  'blogistic_sanitize_url'
        ]);
        $wp_customize->add_control(
            'blogistic_custom_button_redirect_href_link', [
                'label' =>  esc_html__( 'Redirect URL', 'blogistic' ),
                'description'   =>  esc_html__( 'Add url for the button to redirect', 'blogistic' ),
                'section'   =>  'blogistic_custom_button_section',
                'type'   =>  'url',
                'settings'  =>  'blogistic_custom_button_redirect_href_link'
            ]
        );

        // main banner custom button text typography
        $wp_customize->add_setting( 'blogistic_custom_button_text_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_custom_button_text_typography' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'blogistic_custom_button_text_typography', [
                'label' =>  esc_html__( 'Text Typography', 'blogistic' ),
                'section'   =>  'blogistic_custom_button_section',
                'settings'  =>  'blogistic_custom_button_text_typography',
                'tab'   =>  'design'
            ])
        );

        // main banner custom button text color
        $wp_customize->add_setting( 'blogistic_custom_button_text_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_custom_button_text_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'blogistic_custom_button_text_color', [
                'label' =>  esc_html__( 'Text Color', 'blogistic' ),
                'section'   =>  'blogistic_custom_button_section',
                'settings'  =>  'blogistic_custom_button_text_color',
                'tab'   =>  'design'
            ])
        );
        $wp_customize->add_setting( 'blogistic_custom_button_icon_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_custom_button_icon_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'blogistic_custom_button_icon_color', [
                'label' =>  esc_html__( 'Icon Color', 'blogistic' ),
                'section'   =>  'blogistic_custom_button_section',
                'settings'  =>  'blogistic_custom_button_icon_color',
                'tab'   =>  'design'
            ])
        );

        // theme mode section
        $wp_customize->add_section( 'blogistic_theme_mode_section', [
            'panel' =>  'blogistic_theme_header_panel',
            'title' =>  esc_html__( 'Theme Mode', 'blogistic' ),
            'priority'  =>  50
        ]);

        $wp_customize->add_setting( 'blogistic_theme_mode_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_theme_mode_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Toggle_Control( $wp_customize, 'blogistic_theme_mode_option', [
                'label' =>  esc_html__( 'Theme Mode', 'blogistic' ),
                'section'   =>  'blogistic_theme_mode_section',
                'settings'  =>  'blogistic_theme_mode_option'
            ])
        );

        // Canvas Menu Section
        $wp_customize->add_section( 'blogistic_canvas_menu_section', [
            'panel' =>  'blogistic_theme_header_panel',
            'title' =>  esc_html__( 'Off canvas', 'blogistic' ),
            'priority'  =>  50
        ]);

        $wp_customize->add_setting( 'blogistic_canvas_menu_setting', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control ( $wp_customize, 'blogistic_canvas_menu_setting', [
                'section'   =>  'blogistic_canvas_menu_section',
                'setttings' =>  '',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // canvas enable disable option
        $wp_customize->add_setting( 'canvas_menu_enable_disable_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'canvas_menu_enable_disable_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'canvas_menu_enable_disable_option', [
                'label' =>  esc_html__( 'Enable Canvas Menu', 'blogistic' ),
                'section'   =>  'blogistic_canvas_menu_section',
                'settings'  =>  'canvas_menu_enable_disable_option'
            ])
        );

        // canvas menu redirect links
        $wp_customize->add_setting( 'canvas_menu_redirects', [
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Redirect_Control( $wp_customize, 'canvas_menu_redirects', [
                'label'	      => esc_html__( 'Widgets', 'blogistic' ),
                'section'     => 'blogistic_canvas_menu_section',
                'settings'    => 'canvas_menu_redirects',
                'tab'   => 'general',
                'choices'     => [
                    'canvas-menu-sidebar' => [
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-canvas-menu-sidebar',
                        'label' => esc_html__( 'Manage canvas menu widget', 'blogistic' )
                    ]
                ],
                'active_callback'   =>  function( $control ) {
                    return ( $control->manager->get_setting( 'canvas_menu_enable_disable_option' )->value() );
                }
            ])
        );

        // canvas icon color
        $wp_customize->add_setting( 'canvas_menu_icon_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'canvas_menu_icon_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'canvas_menu_icon_color', [
                'label'     => esc_html__( 'Canvas Menu Icon Color', 'blogistic' ),
                'section'   => 'blogistic_canvas_menu_section',
                'settings'  => 'canvas_menu_icon_color',
                'tab'   =>  'design'
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_theme_header_panel' );
endif;

if( ! function_exists( 'blogistic_main_banner_panel' ) ) :
    /**
     * Function for main banner panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_main_banner_panel( $wp_customize ) {
        $wp_customize->add_section( 'main_banner_section', [
            'title' =>  esc_html__( 'Main Banner', 'blogistic' ),
            'priority'  =>  70
        ]);

        // main section heading
        $wp_customize->add_setting( 'main_banner_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( 
                $wp_customize,
                'main_banner_section_heading', 
                [
                    'section'   =>  'main_banner_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // main banner option
        $wp_customize->add_setting( 'main_banner_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'main_banner_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);

        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'main_banner_option', [
                'label'	      => esc_html__( 'Show main banner', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_option'
            ])
        );
        
        // banner post query settings heading
        $wp_customize->add_setting( 'main_banner_post_query_settings_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'main_banner_post_query_settings_heading', [
                'label'	      => esc_html__( 'Post Query', 'blogistic' ),
                'section'     => 'main_banner_section'
            ])
        );

        // main banner slider categories
        $wp_customize->add_setting( 'main_banner_slider_categories', [
            'default' => BIT\blogistic_get_customizer_default( 'main_banner_slider_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Categories_Multiselect_Control( $wp_customize, 'main_banner_slider_categories', [
                'label'     => esc_html__( 'Posts Categories', 'blogistic' ),
                'section'   => 'main_banner_section',
                'settings'  => 'main_banner_slider_categories',
                'choices'   => blogistic_get_multicheckbox_categories_simple_array()
            ])
        );

        // banner posts to include
        $wp_customize->add_setting( 'main_banner_slider_posts_to_include', [
            'default' => BIT\blogistic_get_customizer_default( 'main_banner_slider_posts_to_include' ),
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Posts_Multiselect_Control( $wp_customize, 'main_banner_slider_posts_to_include', [
                'label'     => esc_html__( 'Posts To Include', 'blogistic' ),
                'section'   => 'main_banner_section',
                'settings'  => 'main_banner_slider_posts_to_include',
                'choices'   => blogistic_get_multicheckbox_posts_simple_array()
            ])
        );
        
        // main banner post order
        $wp_customize->add_setting( 'main_banner_post_order', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_order' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'main_banner_post_order', [
            'label' =>  esc_html( 'Post Order', 'blogistic' ),
            'type'  =>  'select',
            'priority'  =>  10,
            'section'   =>  'main_banner_section',
            'settings'  =>  'main_banner_post_order',
            'choices'   =>  blogistic_post_order_args()
        ]);

        // main banner no of posts to show
        $wp_customize->add_setting( 'main_banner_no_of_posts_to_show', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_no_of_posts_to_show' ),
            'sanitize_callback' =>  'absint'
        ]);

        $wp_customize->add_control( 'main_banner_no_of_posts_to_show', [
            'label' =>  esc_html( 'No of posts to show', 'blogistic' ),
            'type'  =>  'number',
            'priority'  =>  10,
            'section'   =>  'main_banner_section',
            'settings'  =>  'main_banner_no_of_posts_to_show',
            'input_attrs' => [
                'max'   => 4,
                'min'   => 1,
                'step'  => 1,
                'reset' => true
            ]
        ]);

        // main banner hide post with no featured image
        $wp_customize->add_setting( 'main_banner_hide_post_with_no_featured_image', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_hide_post_with_no_featured_image' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_hide_post_with_no_featured_image', [
                'label' =>  esc_html__( 'Hide posts with no featured image', 'blogistic' ),
                'section'   =>  'main_banner_section',
                'settings'  =>  'main_banner_hide_post_with_no_featured_image'
            ])
        );

        // main banner slider settings
        $wp_customize->add_setting( 'main_banner_post_elements_settings_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'main_banner_post_elements_settings_heading', [
                'label'	      => esc_html__( 'Post Elements Settings', 'blogistic' ),
                'section'     => 'main_banner_section'
            ])
        );

        // main banner post element show title
        $wp_customize->add_setting( 'main_banner_post_elements_show_title', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_elements_show_title' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_post_elements_show_title', [
                'label'	      => esc_html__( 'Show Title', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'  =>  'main_banner_post_elements_show_title'
            ])
        );

        // main banner post element show categories
        $wp_customize->add_setting( 'main_banner_post_elements_show_categories', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_elements_show_categories' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_post_elements_show_categories', [
                'label'	      => esc_html__( 'Show Categories', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'  =>  'main_banner_post_elements_show_categories'
            ])
        );

        // main banner post element show date
        $wp_customize->add_setting( 'main_banner_post_elements_show_date', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_elements_show_date' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_post_elements_show_date', [
                'label'	      => esc_html__( 'Show Date', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'  =>  'main_banner_post_elements_show_date'
            ])
        );

        // main banner post element show author
        $wp_customize->add_setting( 'main_banner_post_elements_show_author', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_elements_show_author' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_post_elements_show_author', [
                'label'	      => esc_html__( 'Show Author', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'  =>  'main_banner_post_elements_show_author'
            ])
        );

        // main banner post element show excerpt
        $wp_customize->add_setting( 'main_banner_post_elements_show_excerpt', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_elements_show_excerpt' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'main_banner_post_elements_show_excerpt', [
                'label'	      => esc_html__( 'Show Excerpt', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'  =>  'main_banner_post_elements_show_excerpt'
            ])
        );

        // main banner post element alignment
        $wp_customize->add_setting( 'main_banner_post_elements_alignment', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_post_elements_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'main_banner_post_elements_alignment', [
                'label'	      => esc_html__( 'Elements Alignment', 'blogistic' ),
                'section'     => 'main_banner_section',
                'choices' => [
                    [
                        'value' => 'left',
                        'label' => esc_html__('Left', 'blogistic' )
                    ],
                    [
                        'value' => 'center',
                        'label' => esc_html__('Center', 'blogistic' )
                    ],
                    [
                        'value' => 'right',
                        'label' => esc_html__('Right', 'blogistic' )
                    ]
                ]
            ])
        );
        
        // main banner image settings
        $wp_customize->add_setting( 'main_banner_image_setting_heading', [
            'sanitize_callback' =>  'sanitize_text_field'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'main_banner_image_setting_heading', [
                'label' =>  esc_html__( 'Image Settings', 'blogistic' ),
                'settings'  =>  'main_banner_image_setting_heading',
                'section'   =>  'main_banner_section',
                'initial'   =>  false
            ])
        );

        // main banner image sizes
        $wp_customize->add_setting( 'main_banner_image_sizes', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_image_sizes' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'main_banner_image_sizes', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'main_banner_image_sizes',
            'section'   =>  'main_banner_section',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // main banner image ratio
        $wp_customize->add_setting( 'main_banner_responsive_image_ratio', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_responsive_image_ratio' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' => 'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'main_banner_responsive_image_ratio', [
                'label' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'settings'  =>  'main_banner_responsive_image_ratio',
                'section'   =>  'main_banner_section',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  =>  0.1,
                    'reset'    =>  true
                ],
                'responsive'    =>  true
            ])
        );

        // main banner -> design -> typography
        $wp_customize->add_setting( 'main_banner_design_typography', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'main_banner_design_typography', [
                'label'	      => esc_html__( 'Typography', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_design_typography',
                'tab'   =>  'design'
            ])
        );

        // main banner post title typography
        $wp_customize->add_setting( 'main_banner_design_post_title_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_design_post_title_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_banner_design_post_title_typography', [
                'label'	      => esc_html__( 'Title Typo', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_design_post_title_typography',
                'tab'   =>  'design'
            ])
        );

        // main banner post excerpt typography
        $wp_customize->add_setting( 'main_banner_design_post_excerpt_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_design_post_excerpt_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_banner_design_post_excerpt_typography', [
                'label'	      => esc_html__( 'Excerpt Typo', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_design_post_excerpt_typography',
                'tab'   =>  'design'
            ])
        );

        // main banner post categories typography
        $wp_customize->add_setting( 'main_banner_design_post_categories_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_design_post_categories_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_banner_design_post_categories_typography', [
                'label'	      => esc_html__( 'Category Typo', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_design_post_categories_typography',
                'tab'   =>  'design'
            ])
        );

        // main banner post date typography
        $wp_customize->add_setting( 'main_banner_design_post_date_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_design_post_date_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_banner_design_post_date_typography', [
                'label'	      => esc_html__( 'Date Typo', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_design_post_date_typography',
                'tab'   =>  'design'
            ])
        );

        // main banner post author typography
        $wp_customize->add_setting( 'main_banner_design_post_author_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'main_banner_design_post_author_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'main_banner_design_post_author_typography', [
                'label'	      => esc_html__( 'Author Typo', 'blogistic' ),
                'section'     => 'main_banner_section',
                'settings'    => 'main_banner_design_post_author_typography',
                'tab'   =>  'design'
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_main_banner_panel' );
endif;

if( ! function_exists( 'blogistic_carousel_panel' ) ) :
    /**
     * Function for carousel panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_carousel_panel( $wp_customize ) {
        $wp_customize->add_section( 'carousel_section', [
            'title' =>  esc_html__( 'Carousel', 'blogistic' ),
            'priority'  =>  70
        ]);

        // main section heading
        $wp_customize->add_setting( 'carousel_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( 
                $wp_customize,
                'carousel_section_heading', 
                [
                    'section'   =>  'carousel_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // carousel option
        $wp_customize->add_setting( 'carousel_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'carousel_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'carousel_option', [
                'label'	      => esc_html__( 'Show carousel', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_option'
            ])
        );

        // carousel no of columns
        $wp_customize->add_setting( 'carousel_no_of_columns', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_no_of_columns' ),
            'sanitize_callback' =>  'absint'
        ]);

        $wp_customize->add_control( 'carousel_no_of_columns', [
            'label' =>  esc_html__( 'No of Columns', 'blogistic' ),
            'type'  =>  'number',
            'section'   =>  'carousel_section',
            'settings'  =>  'carousel_no_of_columns',
            'input_attrs'   =>  [
                'min'   =>  2,
                'max'   =>  3,
                'step'  =>  1,
                'reset' =>  true
            ]
        ]);

        // carousel post query settings heading
        $wp_customize->add_setting( 'carousel_post_query_settings_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'carousel_post_query_settings_heading', [
                'label'	      => esc_html__( 'Post Query', 'blogistic' ),
                'section'     => 'carousel_section'
            ])
        );

        // carousel slider categories
        $wp_customize->add_setting( 'carousel_slider_categories', [
            'default' => BIT\blogistic_get_customizer_default( 'carousel_slider_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Categories_Multiselect_Control( $wp_customize, 'carousel_slider_categories', [
                'label'     => esc_html__( 'Posts Categories', 'blogistic' ),
                'section'   => 'carousel_section',
                'settings'  => 'carousel_slider_categories',
                'choices'   => blogistic_get_multicheckbox_categories_simple_array()
            ])
        );

        // carousel posts to include
        $wp_customize->add_setting( 'carousel_slider_posts_to_include', [
            'default' => BIT\blogistic_get_customizer_default( 'carousel_slider_posts_to_include' ),
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Posts_Multiselect_Control( $wp_customize, 'carousel_slider_posts_to_include', [
                'label'     => esc_html__( 'Posts To Include', 'blogistic' ),
                'section'   => 'carousel_section',
                'settings'  => 'carousel_slider_posts_to_include',
                'choices'   => blogistic_get_multicheckbox_posts_simple_array()
            ])
        );
        
        // carousel post order
        $wp_customize->add_setting( 'carousel_post_order', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_order' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'carousel_post_order', [
            'label' =>  esc_html( 'Post Order', 'blogistic' ),
            'type'  =>  'select',
            'priority'  =>  10,
            'section'   =>  'carousel_section',
            'settings'  =>  'carousel_post_order',
            'choices'   =>  blogistic_post_order_args()
        ]);

        // carousel no of posts to show
        $wp_customize->add_setting( 'carousel_no_of_posts_to_show', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_no_of_posts_to_show' ),
            'sanitize_callback' =>  'absint'
        ]);

        $wp_customize->add_control( 'carousel_no_of_posts_to_show', [
            'label' =>  esc_html( 'No of posts to show', 'blogistic' ),
            'type'  =>  'number',
            'priority'  =>  10,
            'section'   =>  'carousel_section',
            'settings'  =>  'carousel_no_of_posts_to_show',
            'input_attrs'    => [
                'min'   => 1,
                'max'   => 6,
                'step'  => 1
            ]
        ]);

        // carousel hide post with no featured image
        $wp_customize->add_setting( 'carousel_hide_post_with_no_featured_image', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_hide_post_with_no_featured_image' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'carousel_hide_post_with_no_featured_image', [
                'label' =>  esc_html__( 'Hide posts with no featured image', 'blogistic' ),
                'section'   =>  'carousel_section',
                'settings'  =>  'carousel_hide_post_with_no_featured_image'
            ])
        );

        // carousel slider settings
        $wp_customize->add_setting( 'carousel_post_elements_settings_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'carousel_post_elements_settings_heading', [
                'label'	      => esc_html__( 'Post Elements Settings', 'blogistic' ),
                'section'     => 'carousel_section'
            ])
        );

        // carousel post element show title
        $wp_customize->add_setting( 'carousel_post_elements_show_title', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_elements_show_title' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'carousel_post_elements_show_title', [
                'label'	      => esc_html__( 'Show Title', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'  =>  'carousel_post_elements_show_title'
            ])
        );

        // carousel post element show categories
        $wp_customize->add_setting( 'carousel_post_elements_show_categories', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_elements_show_categories' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'carousel_post_elements_show_categories', [
                'label'	      => esc_html__( 'Show Categories', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'  =>  'carousel_post_elements_show_categories'
            ])
        );

        // carousel post element show date
        $wp_customize->add_setting( 'carousel_post_elements_show_date', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_elements_show_date' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'carousel_post_elements_show_date', [
                'label'	      => esc_html__( 'Show Date', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'  =>  'carousel_post_elements_show_date'
            ])
        );

        // carousel post element show author
        $wp_customize->add_setting( 'carousel_post_elements_show_author', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_elements_show_author' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'carousel_post_elements_show_author', [
                'label'	      => esc_html__( 'Show Author', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'  =>  'carousel_post_elements_show_author'
            ])
        );

        // carousel post element show excerpt
        $wp_customize->add_setting( 'carousel_post_elements_show_excerpt', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_elements_show_excerpt' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'carousel_post_elements_show_excerpt', [
                'label'	      => esc_html__( 'Show Excerpt', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'  =>  'carousel_post_elements_show_excerpt'
            ])
        );

        // carousel post element alignment
        $wp_customize->add_setting( 'carousel_post_elements_alignment', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_post_elements_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'carousel_post_elements_alignment', [
                'label'	      => esc_html__( 'Elements Alignment', 'blogistic' ),
                'section'     => 'carousel_section',
                'choices' => [
                    [
                        'value' => 'left',
                        'label' => esc_html__('Left', 'blogistic' )
                    ],
                    [
                        'value' => 'center',
                        'label' => esc_html__('Center', 'blogistic' )
                    ],
                    [
                        'value' => 'right',
                        'label' => esc_html__('Right', 'blogistic' )
                    ]
                ]
            ])
        );
        
        // carousel image settings
        $wp_customize->add_setting( 'carousel_image_setting_heading', [
            'sanitize_callback' =>  'sanitize_text_field'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'carousel_image_setting_heading', [
                'label' =>  esc_html__( 'Image Settings', 'blogistic' ),
                'settings'  =>  'carousel_image_setting_heading',
                'section'   =>  'carousel_section'
            ])
        );

        // carousel image sizes
        $wp_customize->add_setting( 'carousel_image_sizes', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_image_sizes' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'carousel_image_sizes', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'carousel_image_sizes',
            'section'   =>  'carousel_section',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // carousel image ratio
        $wp_customize->add_setting( 'carousel_responsive_image_ratio', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_responsive_image_ratio' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' => 'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'carousel_responsive_image_ratio', [
                'label' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'settings'  =>  'carousel_responsive_image_ratio',
                'section'   =>  'carousel_section',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  =>  0.1,
                    'reset'    =>  true
                ],
                'responsive'    =>  true
            ])
        );

        // carousel -> design tab -> typography
        $wp_customize->add_setting( 'carousel_design_typography', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'carousel_design_typography', [
                'label'	      => esc_html__( 'Typography', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_design_typography',
                'tab'   =>  'design'
            ])
        );

        // carousel post title typography
        $wp_customize->add_setting( 'carousel_design_post_title_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_design_post_title_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'carousel_design_post_title_typography', [
                'label'	      => esc_html__( 'Title Typo', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_design_post_title_typography',
                'tab'   =>  'design'
            ])
        );

        // carousel post excerpt typography
        $wp_customize->add_setting( 'carousel_design_post_excerpt_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_design_post_excerpt_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'carousel_design_post_excerpt_typography', [
                'label'	      => esc_html__( 'Excerpt Typo', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_design_post_excerpt_typography',
                'tab'   =>  'design'
            ])
        );

        // carousel post categories typography
        $wp_customize->add_setting( 'carousel_design_post_categories_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_design_post_categories_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'carousel_design_post_categories_typography', [
                'label'	      => esc_html__( 'Category Typo', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_design_post_categories_typography',
                'tab'   =>  'design'
            ])
        );

         // carousel post date typography
         $wp_customize->add_setting( 'carousel_design_post_date_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_design_post_date_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'carousel_design_post_date_typography', [
                'label'	      => esc_html__( 'Date Typo', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_design_post_date_typography',
                'tab'   =>  'design'
            ])
        );

         // carousel post date typography
         $wp_customize->add_setting( 'carousel_design_post_author_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'carousel_design_post_author_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'carousel_design_post_author_typography', [
                'label'	      => esc_html__( 'Author Typo', 'blogistic' ),
                'section'     => 'carousel_section',
                'settings'    => 'carousel_design_post_author_typography',
                'tab'   =>  'design'
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_carousel_panel' );
endif;

if( ! function_exists( 'blogistic_category_collection_panel' ) ) :
    function blogistic_category_collection_panel( $wp_customize ) {
        // category collection section
        $wp_customize->add_section( 'category_collection_section', [
            'title' =>  esc_html__( 'Category collection', 'blogistic' ),
            'priority'  =>  71
        ]);

        // category collection section tab
        $wp_customize->add_setting( 'category_collection_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'category_collection_section_heading', [
                'section'   =>  'category_collection_section',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // category collection show option
        $wp_customize->add_setting( 'category_collection_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'category_collection_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'category_collection_option', [
                'label'	      => esc_html__( 'Enable category collection', 'blogistic' ),
                'section'     => 'category_collection_section',
                'settings'    => 'category_collection_option'
            ])
        );

        // category collection category query section heading toggle
        $wp_customize->add_setting( 'category_collection_query_section_heading_toggle', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'category_collection_query_section_heading_toggle', [
                'label'	      => esc_html__( 'Query Settings', 'blogistic' ),
                'section'     => 'category_collection_section'
            ]
        ));

        // category collection includde and exclude
        $category_collection_include_exclude_args = [
            'category_to_include'   =>  esc_html__( 'Category to include', 'blogistic' ),
            'category_to_exclude'   =>  esc_html__( 'Category to exclude', 'blogistic' )
        ];
        if( ! is_null( $category_collection_include_exclude_args ) && is_array( $category_collection_include_exclude_args ) ) :
            foreach( $category_collection_include_exclude_args as $control_id => $label ) :
                $wp_customize->add_setting( $control_id, [
                    'default' => BIT\blogistic_get_customizer_default( $control_id ),
                    'sanitize_callback' => 'sanitize_text_field'
                ]);
                $wp_customize->add_control( 
                    new Blogistic_WP_Categories_Multiselect_Control( $wp_customize, $control_id, [
                        'label'     => esc_html( $label ),
                        'section'   => 'category_collection_section',
                        'settings'  => $control_id,
                        'choices'   => blogistic_get_multicheckbox_categories_simple_array()
                    ])
                );
            endforeach;
        endif;

        // category collection number
        $wp_customize->add_setting( 'category_collection_number', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'category_collection_number' ),
            'sanitize_callback' => 'absint'
        ]);
        $wp_customize->add_control( 'category_collection_number', [
            'label'	      => esc_html__( 'Number of category', 'blogistic' ),
            'section'     => 'category_collection_section',
            'type'  =>  'number',
            'input_attrs' => [
                'min' => 1,
                'max' => 6,
                'step' => 1
            ]
        ]);

        // category collection hide empty
        $wp_customize->add_setting( 'category_collection_hide_empty', [
            'default'   => BIT\blogistic_get_customizer_default( 'category_collection_hide_empty' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'category_collection_hide_empty', [
                'label'	      => esc_html__( 'Hide empty category', 'blogistic' ),
                'section'     => 'category_collection_section',
                'settings'    => 'category_collection_hide_empty'
            ])
        );

        // category collection image setting section heading
        $wp_customize->add_setting( 'category_collection_image_heading_section_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'category_collection_image_heading_section_heading', [
                'label'	      => esc_html__( 'Image Settings', 'blogistic' ),
                'section'     => 'category_collection_section'
            ]
        ));

        // category collection image ratio and radius
        $category_collection_image_settings_array = [
            'category_collection_image_ratio' =>  [
                'label' =>  esc_html__( 'Image ratio', 'blogistic' ),
                'input_attrs'   => [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  => 0.1,
                    'reset' =>  true
                ]
            ]
        ];
        if( ! is_null( $category_collection_image_settings_array ) && is_array( $category_collection_image_settings_array ) ) :
            foreach( $category_collection_image_settings_array as $control_id => $attr ) :
                $wp_customize->add_setting( $control_id, [
                    'default'   =>  BIT\blogistic_get_customizer_default( $control_id ),
                    'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
                    'transport' =>  'postMessage'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Number_Control( $wp_customize, $control_id,[
                        'label' =>  esc_html( $attr['label'] ),
                        'section'   =>  'category_collection_section',
                        'settings'  =>  $control_id,
                        'unit'  =>  'px',
                        'input_attrs'   =>  $attr['input_attrs'],
                        'responsive'    =>  true
                    ])
                );
            endforeach;
        endif;

        // category collection image size
        $wp_customize->add_setting( 'category_collection_image_size', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'category_collection_image_size' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'category_collection_image_size', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'category_collection_image_size',
            'section'   =>  'category_collection_section',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // category collection hover effects
        $wp_customize->add_setting( 'category_collection_hover_effects', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'category_collection_hover_effects' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control( 'category_collection_hover_effects', [
            'label' =>  esc_html__( 'Hover effects', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'category_collection_hover_effects',
            'section'   =>  'category_collection_section',
            'choices'   =>  [
                'none'   =>  esc_html__( 'None', 'blogistic' ),
                'one'   =>  esc_html__( 'Effect 1', 'blogistic' )
            ]
        ]);

        // category collection typography
        $wp_customize->add_setting( 'category_collection_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'category_collection_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'category_collection_typo', [
                'label' =>  esc_html__( 'Typography', 'blogistic' ),
                'section'   =>  'category_collection_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_category_collection_panel' );
endif;

if( !function_exists( 'blogistic_customizer_colors_panel' ) ) :
    /**
     * Register colors options settings
     * 
     */
    function blogistic_customizer_colors_panel( $wp_customize ) {
        // Front sections panel
        $wp_customize->add_panel( 'blogistic_colors_panel', [
            'title' => esc_html__( 'Colors', 'blogistic' ),
            'priority'  => 20
        ]);

        // presets section
        $wp_customize->add_section('theme_presets_section',[
                'title' =>  esc_html__( 'Theme Colors / Presets', 'blogistic' ),
                'panel' =>  'blogistic_colors_panel',
                'priority' =>  10
            ]
        );

        // theme colors header
        $wp_customize->add_setting( 'theme_colors_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'theme_colors_heading', [
                'label' => esc_html__( 'Theme Colors', 'blogistic' ),
                'section'   => 'theme_presets_section'
            ])
        );

        // primary preset color
        $wp_customize->add_setting( 'theme_color', [
            'default'   => BIT\blogistic_get_customizer_default( 'theme_color' ),
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'theme_color', [
                'label'	      => esc_html__( 'Theme Color', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'theme_color',
                'variable'   => '--blogistic-global-preset-theme-color'
            ])
        );

        // gradient theme color
        $wp_customize->add_setting( 'gradient_theme_color', [
            'default'   => BIT\blogistic_get_customizer_default( 'gradient_theme_color' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'gradient_theme_color', [
                'label'	      => esc_html__( 'Gradient Theme Color', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'gradient_theme_color',
                'variable'   => '--blogistic-global-preset-gradient-theme-color'
            ])
        );

        // preset colors header
        $wp_customize->add_setting( 'preset_colors_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'preset_colors_heading', [
                'label' => esc_html__( 'Solid Presets', 'blogistic' ),
                'section'   => 'theme_presets_section',
                'initial'   => false
            ])
        );

        // primary preset color
        $wp_customize->add_setting( 'preset_color_1', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_1' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_1', [
                'label'	      => esc_html__( 'Color 1', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_1',
                'variable'   => '--blogistic-global-preset-color-1'
            ])
        );

        // secondary preset color
        $wp_customize->add_setting( 'preset_color_2', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_2' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_2', [
                'label'	      => esc_html__( 'Color 2', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_2',
                'variable'   => '--blogistic-global-preset-color-2'
            ])
        );

        // tertiary preset color
        $wp_customize->add_setting( 'preset_color_3', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_3' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_3', [
                'label'	      => esc_html__( 'Color 3', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_3',
                'variable'   => '--blogistic-global-preset-color-3'
            ])
        );

        // primary preset link color
        $wp_customize->add_setting( 'preset_color_4', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_4' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_4', [
                'label'	      => esc_html__( 'Color 4', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_4',
                'variable'   => '--blogistic-global-preset-color-4'
            ])
        );

        // secondary preset link color
        $wp_customize->add_setting( 'preset_color_5', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_5' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_5', [
                'label'	      => esc_html__( 'Color 5', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_5',
                'variable'   => '--blogistic-global-preset-color-5'
            ])
        );
        
        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_6', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_6' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_6', [
                'label'	      => esc_html__( 'Color 6', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_6',
                'variable'   => '--blogistic-global-preset-color-6'
            ])
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_7', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_7' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_7', [
                'label'       => esc_html__( 'Color 7', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_7',
                'variable'   => '--blogistic-global-preset-color-7'
            ])
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_8', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_8', [
                'label'       => esc_html__( 'Color 8', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_8',
                'variable'   => '--blogistic-global-preset-color-8'
            ])
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_9', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_9' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_9', [
                'label'       => esc_html__( 'Color 9', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_9',
                'variable'   => '--blogistic-global-preset-color-9'
            ])
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_10', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_10' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_10', [
                'label'       => esc_html__( 'Color 10', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_10',
                'variable'   => '--blogistic-global-preset-color-10'
            ])
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_11', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_11' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_11', [
                'label'       => esc_html__( 'Color 11', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_11',
                'variable'   => '--blogistic-global-preset-color-11'
            ])
        );

        // tertiary preset link color
        $wp_customize->add_setting( 'preset_color_12', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_color_12' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Color_Picker_Control( $wp_customize, 'preset_color_12', [
                'label'       => esc_html__( 'Color 12', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_color_12',
                'variable'   => '--blogistic-global-preset-color-12'
            ])
        );

        // gradient preset colors header
        $wp_customize->add_setting( 'gradient_preset_colors_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'gradient_preset_colors_heading', [
                'label'	      => esc_html__( 'Gradient Presets', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'initial'   => false
            ])
        );

        // gradient color 1
        $wp_customize->add_setting( 'preset_gradient_1', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_1' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_1', [
                'label'	      => esc_html__( 'Gradient 1', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_1',
                'variable'   => '--blogistic-global-preset-gradient-color-1'
            ])
        );
        
        // gradient color 2
        $wp_customize->add_setting( 'preset_gradient_2', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_2' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_2', [
                'label'	      => esc_html__( 'Gradient 2', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_2',
                'variable'   => '--blogistic-global-preset-gradient-color-2'
            ])
        );

        // gradient color 3
        $wp_customize->add_setting( 'preset_gradient_3', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_3' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_3', [
                'label'	      => esc_html__( 'Gradient 3', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_3',
                'variable'   => '--blogistic-global-preset-gradient-color-3'
            ])
        );

        // gradient color 4
        $wp_customize->add_setting( 'preset_gradient_4', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_4' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_4', [
                'label'	      => esc_html__( 'Gradient 4', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_4',
                'variable'   => '--blogistic-global-preset-gradient-color-4'
            ])
        );

        // gradient color 5
        $wp_customize->add_setting( 'preset_gradient_5', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_5' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_5', [
                'label'	      => esc_html__( 'Gradient 5', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_5',
                'variable'   => '--blogistic-global-preset-gradient-color-5'
            ])
        );

        // gradient color 6
        $wp_customize->add_setting( 'preset_gradient_6', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_6' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_6', [
                'label'	      => esc_html__( 'Gradient 6', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_6',
                'variable'   => '--blogistic-global-preset-gradient-color-6'
            ])
        );

        // gradient color 7
        $wp_customize->add_setting( 'preset_gradient_7', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_7' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_7', [
                'label'       => esc_html__( 'Gradient 7', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_7',
                'variable'   => '--blogistic-global-preset-gradient-color-7'
            ])
        );

        // gradient color 8
        $wp_customize->add_setting( 'preset_gradient_8', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_8' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_8', [
                'label'       => esc_html__( 'Gradient 8', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_8',
                'variable'   => '--blogistic-global-preset-gradient-color-8'
            ])
        );

        // gradient color 9
        $wp_customize->add_setting( 'preset_gradient_9', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_9' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_9', [
                'label'       => esc_html__( 'Gradient 9', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_9',
                'variable'   => '--blogistic-global-preset-gradient-color-9'
            ])
        );

        // gradient color 10
        $wp_customize->add_setting( 'preset_gradient_10', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_10' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_10', [
                'label'       => esc_html__( 'Gradient 10', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_10',
                'variable'   => '--blogistic-global-preset-gradient-color-10'
            ])
        );

        // gradient color 11
        $wp_customize->add_setting( 'preset_gradient_11', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_11' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_11', [
                'label'       => esc_html__( 'Gradient 11', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_11',
                'variable'   => '--blogistic-global-preset-gradient-color-11'
            ])
        );

        // gradient color 12
        $wp_customize->add_setting( 'preset_gradient_12', [
            'default'   => BIT\blogistic_get_customizer_default( 'preset_gradient_12' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Preset_Gradient_Picker_Control( $wp_customize, 'preset_gradient_12', [
                'label'       => esc_html__( 'Gradient 12', 'blogistic' ),
                'section'     => 'theme_presets_section',
                'settings'    => 'preset_gradient_12',
                'variable'   => '--blogistic-global-preset-gradient-color-12'
            ])
        );

        // section- category colors section
        $wp_customize->add_section( 'blogistic_category_colors_section', [
            'title' => esc_html__( 'Category Colors', 'blogistic' ),
            'panel' => 'blogistic_colors_panel',
            'priority'  => 20
        ]);

        $totalCats = get_categories();
        if( $totalCats ) :
            foreach( $totalCats as $singleCat ) :
                // banner post query settings heading
                $wp_customize->add_setting( 'category_' .absint($singleCat->term_id). '_color_heading', [
                    'sanitize_callback' => 'sanitize_text_field'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'category_' .absint($singleCat->term_id). '_color_heading', [
                        'label'	      => esc_html( $singleCat->name ),
                        'section'     => 'blogistic_category_colors_section'
                    ])
                );

                // category colors control
                $wp_customize->add_setting( 'category_' .absint($singleCat->term_id). '_color', [
                    'default'   =>  BIT\blogistic_get_customizer_default( 'category_' .absint($singleCat->term_id). '_color' ),
                    'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
                    'transport' =>  'postMessage'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'category_' .absint($singleCat->term_id). '_color', [
                        'label'     => esc_html__( 'Text Color', 'blogistic' ),
                        'section'   => 'blogistic_category_colors_section'
                    ])
                );

                // background colors control
                $wp_customize->add_setting( 'category_background_' .absint($singleCat->term_id). '_color', [
                    'default'   =>  BIT\blogistic_get_customizer_default( 'category_background_' .absint($singleCat->term_id). '_color' ),
                    'sanitize_callback' =>  'sanitize_text_field',
                    'transport' =>  'postMessage'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Background_Color_Group_Picker_Control( $wp_customize, 'category_background_' .absint($singleCat->term_id). '_color', [
                        'label'     => esc_html__( 'Background', 'blogistic' ),
                        'section'   => 'blogistic_category_colors_section'
                    ])
                );
            endforeach;
        endif;

        // section- tag colors section
        $wp_customize->add_section( 'blogistic_tag_colors_section', [
            'title' => esc_html__( 'Tag Colors', 'blogistic' ),
            'panel' => 'blogistic_colors_panel',
            'priority'  => 30
        ]);

        $totalTags = get_tags();
        if( $totalTags ) :
            foreach( $totalTags as $singleTag ) :
                // banner post query settings heading
                $wp_customize->add_setting( 'tag_' .absint($singleTag->term_id). '_color_heading', [
                    'sanitize_callback' => 'sanitize_text_field'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'tag_' .absint($singleTag->term_id). '_color_heading', [
                        'label'	      => esc_html( $singleTag->name ),
                        'section'     => 'blogistic_tag_colors_section'
                    ])
                );

                // tag colors control
                $wp_customize->add_setting( 'tag_' .absint($singleTag->term_id). '_color', [
                    'default'   =>  BIT\blogistic_get_customizer_default( 'tag_' .absint($singleTag->term_id). '_color' ),
                    'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
                    'transport' =>  'postMessage'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'tag_' .absint($singleTag->term_id). '_color', [
                        'label'     => esc_html__( 'Text Color', 'blogistic' ),
                        'section'   => 'blogistic_tag_colors_section'
                    ])
                );

                // background colors control
                $wp_customize->add_setting( 'tag_background_' .absint($singleTag->term_id). '_color', [
                    'default'   =>  BIT\blogistic_get_customizer_default( 'tag_background_' .absint($singleTag->term_id). '_color' ),
                    'sanitize_callback' =>  'sanitize_text_field',
                    'transport' =>  'postMessage'
                ]);
                $wp_customize->add_control(
                    new Blogistic_WP_Background_Color_Group_Picker_Control( $wp_customize, 'tag_background_' .absint($singleTag->term_id). '_color', [
                        'label'     => esc_html__( 'Background', 'blogistic' ),
                        'section'   => 'blogistic_tag_colors_section'
                    ])
                );
            endforeach;
        endif;
    }
    add_action( 'customize_register', 'blogistic_customizer_colors_panel' );
endif;

if( !function_exists( 'blogistic_customizer_global_panel' ) ) :
    /**
     * Register global options settings
     * 
     */
    function blogistic_customizer_global_panel( $wp_customize ) {
        /**
         * Global panel
         * 
         * @package Blogistic
         * @since 1.0.0
         */
        $wp_customize->add_panel( 'blogistic_global_panel', [
            'title' => esc_html__( 'Global', 'blogistic' ),
            'priority'  => 6
        ]);

        // section- seo/misc settings section
        $wp_customize->add_section( 'blogistic_seo_misc_section', [
            'title' => esc_html__( 'SEO / Misc', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);

        // site schema ready option
        $wp_customize->add_setting( 'site_schema_ready', [
            'default'   => BIT\blogistic_get_customizer_default( 'site_schema_ready' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
            'transport'    => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'site_schema_ready', [
                'label'	      => esc_html__( 'Make website schema ready', 'blogistic' ),
                'section'     => 'blogistic_seo_misc_section',
                'settings'    => 'site_schema_ready'
            ])
        );

        // site date to show
        $wp_customize->add_setting( 'site_date_to_show', [
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => BIT\blogistic_get_customizer_default( 'site_date_to_show' )
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'site_date_to_show', [
                'label'	      => esc_html__( 'Date to display', 'blogistic' ),
                'section'     => 'blogistic_seo_misc_section',
                'settings'    => 'site_date_to_show',
                'description' => esc_html__( 'Whether to show date published or modified date.', 'blogistic' ),
                'choices' => [
                    [
                        'value' => 'published',
                        'label' => esc_html__('Published date', 'blogistic' )
                    ],
                    [
                        'value' => 'modified',
                        'label' => esc_html__('Modified date', 'blogistic' )
                    ]
                ]
            ])
        );

        // site date format
        $wp_customize->add_setting( 'site_date_format', [
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'default'   => BIT\blogistic_get_customizer_default( 'site_date_format' )
        ]);
        $wp_customize->add_control( 'site_date_format', [
            'type'      => 'select',
            'section'   => 'blogistic_seo_misc_section',
            'label'     => esc_html__( 'Date format', 'blogistic' ),
            'description' => esc_html__( 'Date format applied to single and archive pages.', 'blogistic' ),
            'choices'   => [
                'theme_format'  => esc_html__( 'Default by theme', 'blogistic' ),
                'default'   => esc_html__( 'Wordpress default date', 'blogistic' )
            ]
        ]);

        // notices header
        $wp_customize->add_setting( 'blogistic_disable_admin_notices_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'blogistic_disable_admin_notices_heading', [
                'label'	      => esc_html__( 'Admin Settings', 'blogistic' ),
                'section'     => 'blogistic_seo_misc_section',
                'settings'    => 'blogistic_disable_admin_notices_heading'
            ])
        );

        // site notices option
        $wp_customize->add_setting( 'blogistic_disable_admin_notices', [
            'default'   => BIT\blogistic_get_customizer_default( 'blogistic_disable_admin_notices' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
            'transport'    => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'blogistic_disable_admin_notices', [
                'label'	      => esc_html__( 'Disabled the theme admin notices', 'blogistic' ),
                'description'	      => esc_html__( 'This will hide all the notices or any message shown by the theme like review notices, change log notices', 'blogistic' ),
                'section'     => 'blogistic_seo_misc_section',
                'settings'    => 'blogistic_disable_admin_notices'
            ])
        );

        // section- preloader section
        $wp_customize->add_section( 'blogistic_preloader_section', [
            'title' => esc_html__( 'Preloader', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);
        
        // preloader option
        $wp_customize->add_setting( 'preloader_option', [
            'default'   => BIT\blogistic_get_customizer_default('preloader_option'),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'preloader_option', [
                'label'	      => esc_html__( 'Enable site preloader', 'blogistic' ),
                'section'     => 'blogistic_preloader_section',
                'settings'    => 'preloader_option'
            ])
        );

        // section- website layout section
        $wp_customize->add_section( 'blogistic_website_layout_section', [
            'title' => esc_html__( 'Website Layout', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);
        
        // website layout heading
        $wp_customize->add_setting( 'website_layout_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'website_layout_header', [
                'label'	      => esc_html__( 'Website Layout', 'blogistic' ),
                'section'     => 'blogistic_website_layout_section',
                'settings'    => 'website_layout_header'
            ])
        );

        // website layout
        $wp_customize->add_setting( 'website_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'website_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'website_layout', [
                'section'  => 'blogistic_website_layout_section',
                'choices'  => [
                    'boxed--layout' => [
                        'label' => esc_html__( 'Boxed', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/boxed-width.png'
                    ],
                    'full-width--layout' => [
                        'label' => esc_html__( 'Full Width', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/full-width.png'
                    ]
                ]
            ]
        ));
        
        // section- animation section
        $wp_customize->add_section( 'blogistic_animation_section', [
            'title' => esc_html__( 'Animation / Hover Effects', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);

        // post title animation effects 
        $wp_customize->add_setting( 'post_title_hover_effects', [
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'default'   => BIT\blogistic_get_customizer_default( 'post_title_hover_effects' ),
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 'post_title_hover_effects', [
            'type'      => 'select',
            'section'   => 'blogistic_animation_section',
            'label'     => esc_html__( 'Post title hover effects', 'blogistic' ),
            'description' => esc_html__( 'Applied to post titles listed in archive pages.', 'blogistic' ),
            'choices'   => [
                'none' => esc_html__( 'None', 'blogistic' ),
                'one'  => esc_html__( 'Effect one', 'blogistic' ),
                'two'  => esc_html__( 'Effect Two', 'blogistic' )
            ]
        ]);

        // site image animation effects 
        $wp_customize->add_setting( 'site_image_hover_effects', [
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'default'   => BIT\blogistic_get_customizer_default( 'site_image_hover_effects' ),
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 'site_image_hover_effects', [
            'type'      => 'select',
            'section'   => 'blogistic_animation_section',
            'label'     => esc_html__( 'Image hover effects', 'blogistic' ),
            'description' => esc_html__( 'Applied to post thumbanails listed in archive pages.', 'blogistic' ),
            'choices'   => [
                'none' => esc_html__( 'None', 'blogistic' ),
                'one'  => esc_html__( 'Effect One', 'blogistic' ),
                'two'  => esc_html__( 'Effect Two', 'blogistic' ) 
            ]
        ]);

        // cursor animation effects
        $wp_customize->add_setting( 'cursor_animation', [
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'default'   => BIT\blogistic_get_customizer_default( 'cursor_animation' ),
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 'cursor_animation', [
            'type'      => 'select',
            'section'   => 'blogistic_animation_section',
            'label'     => esc_html__( 'Cursor animation', 'blogistic' ),
            'description' => esc_html__( 'Applied to mouse pointer.', 'blogistic' ),
            'choices'   => [
                'none' => esc_html__( 'None', 'blogistic' ),
                'one'  => esc_html__( 'Animation 1', 'blogistic' )
            ]
        ]);

        // section- social icons section
        $wp_customize->add_section( 'blogistic_social_icons_section', [
            'title' => esc_html__( 'Social Icons', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);
        
        // social icons setting heading
        $wp_customize->add_setting( 'social_icons_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'social_icons_settings_header', [
                'label'	      => esc_html__( 'Social Icons Settings', 'blogistic' ),
                'section'     => 'blogistic_social_icons_section',
                'settings'    => 'social_icons_settings_header'
            ])
        );

        // social icons target attribute value
        $wp_customize->add_setting( 'social_icons_target', [
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'default'   => BIT\blogistic_get_customizer_default( 'social_icons_target' ),
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 'social_icons_target', [
            'type'      => 'select',
            'section'   => 'blogistic_social_icons_section',
            'label'     => esc_html__( 'Open link in', 'blogistic' ),
            'choices'   => [
                '_blank' => esc_html__( 'Open in new tab', 'blogistic' ),
                '_self'  => esc_html__( 'Open in same tab', 'blogistic' )
            ]
        ]);

        // social icons items
        $wp_customize->add_setting( 'social_icons', [
            'default'   => BIT\blogistic_get_customizer_default( 'social_icons' ),
            'sanitize_callback' => 'blogistic_sanitize_repeater_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Custom_Repeater( $wp_customize, 'social_icons', [
                'label'         => esc_html__( 'Social Icons', 'blogistic' ),
                'description'   => esc_html__( 'Hold and drag vertically to re-order the icons', 'blogistic' ),
                'section'       => 'blogistic_social_icons_section',
                'settings'      => 'social_icons',
                'row_label'     => 'inherit-icon_class',
                'add_new_label' => esc_html__( 'Add New Icon', 'blogistic' ),
                'fields'        => [
                    'icon_class'   => [
                        'type'          => 'fontawesome-icon-picker',
                        'label'         => esc_html__( 'Social Icon', 'blogistic' ),
                        'description'   => esc_html__( 'Select from dropdown.', 'blogistic' ),
                        'default'       => esc_attr( 'fab fa-instagram' ),
                        'families'  =>  'social'
                    ],
                    'icon_url'  => [
                        'type'      => 'url',
                        'label'     => esc_html__( 'URL for icon', 'blogistic' ),
                        'default'   => ''
                    ],
                    'item_option'             => 'show'
                ]
            ])
        );

        // social icon officla color inherit
        $wp_customize->add_setting( 'social_icon_official_color_inherit', [
            'default'   => BIT\blogistic_get_customizer_default( 'social_icon_official_color_inherit' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'social_icon_official_color_inherit', [
                'label'	      => esc_html__( 'Inherit official color', 'blogistic' ),
                'section'     => 'blogistic_social_icons_section',
                'settings'    => 'social_icon_official_color_inherit'
            ])
        );
        
        // section - global button
        $wp_customize->add_section( 'blogistic_buttons_section', [
            'title' => esc_html__( 'Buttons', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);

        // global button typo
        $wp_customize->add_setting( 'global_button_typo', [
            'default'   => BIT\blogistic_get_customizer_default( 'global_button_typo' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'global_button_typo', [
                'label'	      => esc_html__( 'Typography', 'blogistic' ),
                'section'     => 'blogistic_buttons_section',
                'settings'    => 'global_button_typo',
                'fields'    => [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // section- breadcrumb options section
        $wp_customize->add_section( 'blogistic_breadcrumb_options_section', [
            'title' => esc_html__( 'Breadcrumb Options', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);

        // scroll to top section tab
        $wp_customize->add_setting( 'breadcrumb_section_tab', [
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'breadcrumb_section_tab', [
                'section'     => 'blogistic_breadcrumb_options_section',
                'choices'  => [
                    [
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // breadcrumb option
        $wp_customize->add_setting( 'site_breadcrumb_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'site_breadcrumb_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'site_breadcrumb_option', [
                'label'	      => esc_html__( 'Show breadcrumb trails', 'blogistic' ),
                'section'     => 'blogistic_breadcrumb_options_section',
                'settings'    => 'site_breadcrumb_option'
            ])
        );

        // breadcrumb type 
        $wp_customize->add_setting( 'site_breadcrumb_type', [
            'sanitize_callback' => 'blogistic_sanitize_select_control',
            'default'   => BIT\blogistic_get_customizer_default( 'site_breadcrumb_type' )
        ]);
        $wp_customize->add_control( 'site_breadcrumb_type', [
            'type'      => 'select',
            'section'   => 'blogistic_breadcrumb_options_section',
            'label'     => esc_html__( 'Breadcrumb type', 'blogistic' ),
            'description' => esc_html__( 'If you use other than "default" one you will need to install and activate respective plugins Breadcrumb NavXT, Yoast SEO and Rank Math SEO', 'blogistic' ),
            'choices'   => [
                'default' => esc_html__( 'Default', 'blogistic' ),
                'bcn'  => esc_html__( 'NavXT', 'blogistic' ),
                'yoast'  => esc_html__( 'Yoast SEO', 'blogistic' ),
                'rankmath'  => esc_html__( 'Rank Math', 'blogistic' )
            ]
        ]);

        // breadcrumb typography
        $wp_customize->add_setting( 'breadcrumb_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'breadcrumb_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'breadcrumb_typo', [
                'label' =>  esc_html__( 'Typography', 'blogistic' ),
                'section'   =>  'blogistic_breadcrumb_options_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // section- scroll to top options
        $wp_customize->add_section( 'blogistic_stt_options_section', [
            'title' => esc_html__( 'Scroll To Top', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);

        // scroll to top option
        $wp_customize->add_setting( 'blogistic_scroll_to_top_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'blogistic_scroll_to_top_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Toggle_Control( $wp_customize, 'blogistic_scroll_to_top_option', [
                'label' =>  esc_html__( 'Show Scroll to Top', 'blogistic' ),
                'section'   =>  'blogistic_stt_options_section'
            ])
        );

        // section- sidebar options
        $wp_customize->add_section( 'blogistic_global_sidebar_sticky_section', [
            'title' => esc_html__( 'Sidebar Sticky', 'blogistic' ),
            'panel' => 'blogistic_global_panel'
        ]);

        $wp_customize->add_setting( 'sidebar_sticky_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_sticky_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'sidebar_sticky_option', [
                'label'	      => esc_html__( 'Enable Sidebar Sticky', 'blogistic' ),
                'section'     => 'blogistic_global_sidebar_sticky_section'
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_customizer_global_panel', 10 );
endif;

if( ! function_exists( 'blogistic_blog_archive_panel' ) ) :
    /**
     * Function for theme blog / archives panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_blog_archive_panel( $wp_customize ) {
        $wp_customize->add_panel(
            'blog_archive_panel',
            [
                'title' =>  esc_html__( 'Blog / Archives', 'blogistic' ),
                'priority'  =>  80
            ]
        );

        // archive layouts page
        $wp_customize->add_section( 'archive_general_section', [
            'title' =>  esc_html__( 'General Settings', 'blogistic' ),
            'panel'  =>  'blog_archive_panel',
            'priority'  =>  10
        ]);

        // archive section heading
        $wp_customize->add_setting( 'archive_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'archive_section_heading', 
                [
                    'section'   =>  'archive_general_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // archive layouts settings heading
        $wp_customize->add_setting( 'archive_layouts_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'archive_layouts_settings_header', [
                'label'	      => esc_html__( 'Layouts Settings', 'blogistic' ),
                'section'     => 'archive_general_section'
            ])
        );

        // archive posts column
        $wp_customize->add_setting( 'archive_post_column', [
            'default'   => BIT\blogistic_get_customizer_default( 'archive_post_column' ),
            'sanitize_callback' => 'blogistic_sanitize_responsive_range',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'archive_post_column', [
                'label' => esc_html__( 'No. of columns', 'blogistic' ),
                'section'   => 'archive_general_section',
                'settings'  => 'archive_post_column',
                'unit'  => 'px',
                'input_attrs' => [
                    'max'   => 3,
                    'min'   => 1,
                    'step'  => 1,
                    'reset' => true
                ],
                'responsive'    =>  true
            ])
        );
        
        // archive posts layout
        $wp_customize->add_setting( 'archive_post_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'archive_post_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'archive_post_layout', [
                'label' =>  esc_html__( 'Archive Layout', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'choices'  => [
                    'grid' => [
                        'label' => esc_html__( 'Grid', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/archive-grid.png'
                    ],
                    'list' => [
                        'label' => esc_html__( 'List', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/archive-list.png'
                    ],
                    'masonry' => [
                        'label' => esc_html__( 'Masonry', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/archive-masonry.png'
                    ]
                ]
            ])
        );

        // archive sidebar layout
        $wp_customize->add_setting( 'archive_sidebar_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'archive_sidebar_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'archive_sidebar_layout', [
                'label' =>  esc_html__( 'Sidebar Layout', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'choices'  => [
                    'right-sidebar' => [
                        'label' => esc_html__( 'Right Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/right-sidebar.png'
                    ],
                    'left-sidebar' => [
                        'label' => esc_html__( 'Left Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/left-sidebar.png'
                    ],
                    'both-sidebar' => [
                        'label' => esc_html__( 'Both Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/both-sidebar.png'
                    ],
                    'no-sidebar' => [
                        'label' => esc_html__( 'No Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/no-sidebar.png'
                    ]
                ]
            ])
        );
        
        // archive elements settings heading
        $wp_customize->add_setting( 'archive_elements_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'archive_elements_settings_header', [
                'label'	      => esc_html__( 'Elements Settings', 'blogistic' ),
                'section'     => 'archive_general_section'
            ])
        );
        
        // archive post elements alignment
        $wp_customize->add_setting( 'archive_post_elements_alignment', [
            'default' => BIT\blogistic_get_customizer_default( 'archive_post_elements_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'archive_post_elements_alignment', [
                'label'	      => esc_html__( 'Elements Alignment', 'blogistic' ),
                'section'     => 'archive_general_section',
                'choices' => [
                    [
                        'value' => 'left',
                        'label' => esc_html__('Left', 'blogistic' )
                    ],
                    [
                        'value' => 'center',
                        'label' => esc_html__('Center', 'blogistic' )
                    ],
                    [
                        'value' => 'right',
                        'label' => esc_html__('Right', 'blogistic' )
                    ]
                ]
            ])
        );

        // post title option
        $wp_customize->add_setting( 'archive_title_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_title_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_title_option', [
                'label' =>  esc_html__( 'Show post title', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post excerpt option
        $wp_customize->add_setting( 'archive_excerpt_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_excerpt_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_excerpt_option', [
                'label' =>  esc_html__( 'Show post excerpt', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post category option
        $wp_customize->add_setting( 'archive_category_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_category_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_category_option', [
                'label' =>  esc_html__( 'Show post category', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post date option
        $wp_customize->add_setting( 'archive_date_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_date_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_date_option', [
                'label' =>  esc_html__( 'Show post date', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post read time option
        $wp_customize->add_setting( 'archive_read_time_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_read_time_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_read_time_option', [
                'label' =>  esc_html__( 'Show post read time', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post comments option
        $wp_customize->add_setting( 'archive_comments_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_comments_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_comments_option', [
                'label' =>  esc_html__( 'Show comments number', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post author option
        $wp_customize->add_setting( 'archive_author_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_author_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_author_option', [
                'label' =>  esc_html__( 'Show author', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // post button option
        $wp_customize->add_setting( 'archive_button_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_button_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'archive_button_option', [
                'label' =>  esc_html__( 'Show button', 'blogistic' ),
                'section'   =>  'archive_general_section'
            ])
        );

        // archive image settings
        $wp_customize->add_setting( 'archive_image_setting_heading', [
            'sanitize_callback' =>  'sanitize_text_field'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'archive_image_setting_heading', [
                'label' =>  esc_html__( 'Image Settings', 'blogistic' ),
                'settings'  =>  'archive_image_setting_heading',
                'section'   =>  'archive_general_section'
            ])
        );

        // archive image sizes
        $wp_customize->add_setting( 'archive_image_size', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_image_size' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'archive_image_size', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'archive_image_size',
            'section'   =>  'archive_general_section',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // archive image ratio
        $wp_customize->add_setting( 'archive_responsive_image_ratio', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_responsive_image_ratio' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'archive_responsive_image_ratio', [
                'label' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'settings'  =>  'archive_responsive_image_ratio',
                'section'   =>  'archive_general_section',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  =>  0.1,
                    'reset'    =>  true
                ],
                'responsive'    =>  true
            ])
        );

         // archive color settings heading
         $wp_customize->add_setting( 'archive_background_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'archive_background_settings_header', [
                'label'	      => esc_html__( 'Color Settings', 'blogistic' ),
                'section'     => 'archive_general_section',
                'tab'   =>  'design'
            ])
        );

        // archive inner background
        $wp_customize->add_setting( 'archive_inner_background_color', [
            'default'   => BIT\blogistic_get_customizer_default( 'archive_inner_background_color' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Color_Group_Control( $wp_customize, 'archive_inner_background_color', [
                'label'	      => esc_html__( 'Inner Background Color', 'blogistic' ),
                'section'     => 'archive_general_section',
                'settings'    => 'archive_inner_background_color',
                'tab'   =>  'design'
            ])
        );

        // archive typography heading
        $wp_customize->add_setting( 'archive_typography_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'archive_typography_header', [
                'label' => esc_html__( 'Typography', 'blogistic' ),
                'section'   => 'archive_general_section',
                'tab'   => 'design'
            ])
        );

        // archive 
        $wp_customize->add_setting( 'archive_title_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_title_typo', [
                'label' =>  esc_html__( 'Post Title', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive excerpt typo
        $wp_customize->add_setting( 'archive_excerpt_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_excerpt_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_excerpt_typo', [
                'label' =>  esc_html__( 'Excerpt Typo', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive category typo
        $wp_customize->add_setting( 'archive_category_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_category_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_category_typo', [
                'label' =>  esc_html__( 'Category Typo', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive date typo
        $wp_customize->add_setting( 'archive_date_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_date_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_date_typo', [
                'label' =>  esc_html__( 'Date Typo', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive author typo
        $wp_customize->add_setting( 'archive_author_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_author_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_author_typo', [
                'label' =>  esc_html__( 'Author Typo', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive read time typo
        $wp_customize->add_setting( 'archive_read_time_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_read_time_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_read_time_typo', [
                'label' =>  esc_html__( 'Read Time Typo', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive comment typo
        $wp_customize->add_setting( 'archive_comment_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_comment_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_comment_typo', [
                'label' =>  esc_html__( 'Comment Typo', 'blogistic' ),
                'section'   =>  'archive_general_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // category archive page
        $wp_customize->add_section( 'category_archive_section', [
            'title' =>  esc_html__( 'Category Page', 'blogistic' ),
            'panel'  =>  'blog_archive_panel',
            'priority'  =>  20
        ]);

        // category archive section heading
        $wp_customize->add_setting( 'category_archive_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'category_archive_section_heading',
                [
                    'section'   =>  'category_archive_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // show or hide category info box
        $wp_customize->add_setting( 'archive_category_info_box_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_category_info_box_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Toggle_Control( $wp_customize, 'archive_category_info_box_option', [
                'label' =>  esc_html__( 'Show category info box', 'blogistic' ),
                'section'   =>  'category_archive_section'
            ])
        );

        // info box typography settings heading
        $wp_customize->add_setting( 'archive_category_info_box_typography_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'archive_category_info_box_typography_heading', [
                'label' => esc_html__( 'Typography', 'blogistic' ),
                'tab'   =>  'design',
                'section'   => 'category_archive_section'
            ])
        );

        // archive category info box 
        $wp_customize->add_setting( 'archive_category_info_box_title_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_category_info_box_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_category_info_box_title_typo', [
                'label' =>  esc_html__( 'Category Title', 'blogistic' ),
                'section'   =>  'category_archive_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive category info box description typo
        $wp_customize->add_setting( 'archive_category_info_box_description_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_category_info_box_description_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_category_info_box_description_typo', [
                'label' =>  esc_html__( 'Category Description Typo', 'blogistic' ),
                'section'   =>  'category_archive_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // tag archive page
        $wp_customize->add_section( 'tag_archive_section', [
            'title' =>  esc_html__( 'Tag Page', 'blogistic' ),
            'panel'  =>  'blog_archive_panel',
            'priority'  =>  20
        ]);

        // tag archive section heading
        $wp_customize->add_setting( 'tag_archive_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'tag_archive_section_heading',
                [
                    'section'   =>  'tag_archive_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // show or hide tag info box
        $wp_customize->add_setting( 'archive_tag_info_box_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_tag_info_box_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Toggle_Control( $wp_customize, 'archive_tag_info_box_option', [
                'label' =>  esc_html__( 'Show tag info box', 'blogistic' ),
                'section'   =>  'tag_archive_section'
            ])
        );

        // info box typography settings heading
        $wp_customize->add_setting( 'archive_tag_info_box_typography_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'archive_tag_info_box_typography_heading', [
                'label' => esc_html__( 'Typography', 'blogistic' ),
                'tab'   =>  'design',
                'section'   => 'tag_archive_section'
            ])
        );

        // archive tag info box 
        $wp_customize->add_setting( 'archive_tag_info_box_title_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_tag_info_box_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_tag_info_box_title_typo', [
                'label' =>  esc_html__( 'Tag Title', 'blogistic' ),
                'section'   =>  'tag_archive_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive tag info box description typo
        $wp_customize->add_setting( 'archive_tag_info_box_description_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_tag_info_box_description_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_tag_info_box_description_typo', [
                'label' =>  esc_html__( 'Tag Description Typo', 'blogistic' ),
                'section'   =>  'tag_archive_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // author archive page
        $wp_customize->add_section( 'author_archive_section', [
            'title' =>  esc_html__( 'Author Page', 'blogistic' ),
            'panel'  =>  'blog_archive_panel',
            'priority'  =>  20
        ]);

        // author archive section heading
        $wp_customize->add_setting( 'author_archive_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'author_archive_section_heading',
                [
                    'section'   =>  'author_archive_section',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // show or hide author info box
        $wp_customize->add_setting( 'archive_author_info_box_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_author_info_box_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Toggle_Control( $wp_customize, 'archive_author_info_box_option', [
                'label' =>  esc_html__( 'Show author info box', 'blogistic' ),
                'section'   =>  'author_archive_section'
            ])
        );

        // info box typography settings heading
        $wp_customize->add_setting( 'archive_author_info_box_typography_heading', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Control( $wp_customize, 'archive_author_info_box_typography_heading', [
                'label' => esc_html__( 'Typography', 'blogistic' ),
                'tab'   =>  'design',
                'section'   => 'author_archive_section'
            ])
        );

        // archive author info box 
        $wp_customize->add_setting( 'archive_author_info_box_title_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_author_info_box_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_author_info_box_title_typo', [
                'label' =>  esc_html__( 'Author Name', 'blogistic' ),
                'section'   =>  'author_archive_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // archive author info box description typo
        $wp_customize->add_setting( 'archive_author_info_box_description_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_author_info_box_description_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'archive_author_info_box_description_typo', [
                'label' =>  esc_html__( 'Author Description Typo', 'blogistic' ),
                'section'   =>  'author_archive_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // pagination setting section
        $wp_customize->add_section( 'pagination_settings_section', [
            'title' =>  esc_html__( 'Pagination Settings', 'blogistic' ),
            'panel'  =>  'blog_archive_panel',
            'priority'  =>  30
        ]);

        // pagination type
        $wp_customize->add_setting( 'archive_pagination_type', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'archive_pagination_type' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);
        $wp_customize->add_control( 'archive_pagination_type', [
                'label' =>  esc_html__( 'Pagination Type', 'blogistic' ),
                'section'   =>  'pagination_settings_section',
                'type'  =>  'select',
                'choices'   =>  apply_filters( 'blogistic_get_pagination_type_array_filter', [
                    'default'   => esc_html__( 'Default', 'blogistic' ),
                    'number'    => esc_html__( 'Number', 'blogistic' )
                ])
            ]
        );

        // pagination button text color for default and number
        $wp_customize->add_setting( 'pagination_text_color', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'pagination_text_color' ),
            'sanitize_callback' =>  'blogistic_sanitize_color_group_picker_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Color_Group_Picker_Control( $wp_customize, 'pagination_text_color', [
                'label'     => esc_html__( 'Text Color', 'blogistic' ),
                'section'   => 'pagination_settings_section',
                'settings'  => 'pagination_text_color',
                'tab'   =>  'design',
                'active_callback'   =>  function( $control ) {
                    return ( $control->manager->get_setting( 'archive_pagination_type' )->value() == 'number' );
                }
            ])
        );
    }
add_action( 'customize_register', 'blogistic_blog_archive_panel' );
endif;

if( ! function_exists( 'blogistic_blog_single_panel' ) ) :
    /**
     * Function for theme blog single panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_blog_single_panel( $wp_customize ) {
        $wp_customize->add_panel( 'blog_single_section_panel', [
            'title' =>  esc_html__( 'Single Post', 'blogistic' ),
            'priority'  =>  80
        ]);

        $wp_customize->add_section( 'blog_single_general_settings', [
            'title' =>  esc_html__( 'General Settings', 'blogistic' ),
            'priority'  =>  80,
            'panel' =>  'blog_single_section_panel'
        ]);

        // single section heading
        $wp_customize->add_setting( 'single_section_heading', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'single_section_heading', 
                [
                    'section'   =>  'blog_single_general_settings',
                    'priority'  =>  1,
                    'choices'   =>  [
                        [
                            'name'  =>  'general',
                            'title' =>  esc_html__( 'General', 'blogistic' )
                        ],
                        [
                            'name'  =>  'design',
                            'title' =>  esc_html__( 'Design', 'blogistic' )
                        ]
                    ]
                ]
            )
        );

        // single general settings heading
        $wp_customize->add_setting( 'single_general_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'single_general_settings_header', [
                'label'	      => esc_html__( 'General Settings', 'blogistic' ),
                'section'     => 'blog_single_general_settings'
            ])
        );

        // single posts layout
        $wp_customize->add_setting( 'single_post_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'single_post_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'single_post_layout', [
                'label' =>  esc_html__( 'Single Layout', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'choices'  => [
                    'layout-one' => [
                        'label' => esc_html__( 'Layout One', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/single-one.png'
                    ],
                    'layout-five' => [
                        'label' => esc_html__( 'Layout Five', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/single-five.png'
                    ]
                ]
            ])
        );

        // single sidebar layout
        $wp_customize->add_setting( 'single_sidebar_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'single_sidebar_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'single_sidebar_layout', [
                'label' =>  esc_html__( 'Sidebar Layout', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'choices'  => [
                    'right-sidebar' => [
                        'label' => esc_html__( 'Right Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/right-sidebar.png'
                    ],
                    'left-sidebar' => [
                        'label' => esc_html__( 'Left Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/left-sidebar.png'
                    ],
                    'both-sidebar' => [
                        'label' => esc_html__( 'Both Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/both-sidebar.png'
                    ],
                    'no-sidebar' => [
                        'label' => esc_html__( 'No Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/no-sidebar.png'
                    ]
                ]
            ])
        );

        // single image settings heading toggle
        $wp_customize->add_setting( 'single_image_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'single_image_settings_header', [
                'label'	      => esc_html__( 'Image Settings', 'blogistic' ),
                'section'     => 'blog_single_general_settings'
            ])
        );

        // single image sizes
        $wp_customize->add_setting( 'single_image_size', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_image_size' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'single_image_size', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'single_image_size',
            'section'   =>  'blog_single_general_settings',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // single image ratio
        $wp_customize->add_setting( 'single_responsive_image_ratio', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_responsive_image_ratio' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' => 'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'single_responsive_image_ratio', [
                'label' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'settings'  =>  'single_responsive_image_ratio',
                'section'   =>  'blog_single_general_settings',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  =>  0.1,
                    'reset'    =>  true
                ],
                'responsive'    =>  true
            ])
        );

        // single typography heading
        $wp_customize->add_setting( 'single_typography_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'single_typography_header', [
                'label' => esc_html__( 'Typography', 'blogistic' ),
                'section'   => 'blog_single_general_settings',
                'tab'   => 'design'
            ])
        );

        // single title typo
        $wp_customize->add_setting( 'single_title_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'single_title_typo', [
                'label' =>  esc_html__( 'Title Typo', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // single excerpt typo
        $wp_customize->add_setting( 'single_content_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_content_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'single_content_typo', [
                'label' =>  esc_html__( 'Content Typo', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // single category typo
        $wp_customize->add_setting( 'single_category_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_category_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'single_category_typo', [
                'label' =>  esc_html__( 'Category Typo', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // single date typo
        $wp_customize->add_setting( 'single_date_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_date_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'single_date_typo', [
                'label' =>  esc_html__( 'Date Typo', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // single author typo
        $wp_customize->add_setting( 'single_author_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_author_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'single_author_typo', [
                'label' =>  esc_html__( 'Author Typo', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // single read time typo
        $wp_customize->add_setting( 'single_read_time_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_read_time_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'single_read_time_typo', [
                'label' =>  esc_html__( 'Read Time Typo', 'blogistic' ),
                'section'   =>  'blog_single_general_settings',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // single color settings heading
        $wp_customize->add_setting( 'single_color_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'single_color_settings_header', [
                'label' => esc_html__( 'Color Settings', 'blogistic' ),
                'section'   => 'blog_single_general_settings',
                'tab'   => 'design'
            ])
        );

        // single page background color
        $wp_customize->add_setting( 'single_page_background_color', [
            'default'   => BIT\blogistic_get_customizer_default( 'single_page_background_color' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Color_Group_Control( $wp_customize, 'single_page_background_color', [
                'label'	      => esc_html__( 'Background', 'blogistic' ),
                'section'     => 'blog_single_general_settings',
                'settings'    => 'single_page_background_color',
                'tab'   =>  'design'
            ])
        );
        
        // single elements settings section
        $wp_customize->add_section( 'blog_single_elements_settings_section', [
            'title' =>  esc_html__( 'Elements Settings', 'blogistic' ),
            'priority'  =>  80,
            'panel' =>  'blog_single_section_panel'
        ]);

        // post title option
        $wp_customize->add_setting( 'single_title_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_title_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_title_option', [
                'label' =>  esc_html__( 'Show post title', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );

        // post thumbnail option
        $wp_customize->add_setting( 'single_thumbnail_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_thumbnail_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_thumbnail_option', [
                'label' =>  esc_html__( 'Show post thumbnail', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );

        // post category option
        $wp_customize->add_setting( 'single_category_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_category_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_category_option', [
                'label' =>  esc_html__( 'Show post category', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );

        // post date option
        $wp_customize->add_setting( 'single_date_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_date_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_date_option', [
                'label' =>  esc_html__( 'Show post date', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );

        // post read time option
        $wp_customize->add_setting( 'single_read_time_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_read_time_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_read_time_option', [
                'label' =>  esc_html__( 'Show post read time', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );
        // post comments option
        $wp_customize->add_setting( 'single_comments_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_comments_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_comments_option', [
                'label' =>  esc_html__( 'Show comments number', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );

        // post author option
        $wp_customize->add_setting( 'single_author_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'single_author_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'single_author_option', [
                'label' =>  esc_html__( 'Show author', 'blogistic' ),
                'section'   =>  'blog_single_elements_settings_section'
            ])
        );
        // single post content alignment
        $wp_customize->add_setting( 'single_post_content_alignment', [
            'default'         => BIT\blogistic_get_customizer_default( 'single_post_content_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'single_post_content_alignment', [
                'label'	      => esc_html__( 'Post content alignment', 'blogistic' ),
                'section'     => 'blog_single_elements_settings_section',
                'choices' => [
                    [
                        'value' => 'left',
                        'label' => esc_html__( 'Left', 'blogistic' )
                    ],
                    [
                        'value' => 'center',
                        'label' => esc_html__( 'Center', 'blogistic' )
                    ],
                    [
                        'value' => 'right',
                        'label' => esc_html__( 'Right', 'blogistic' )
                    ]
                ]
            ])
        );

        // single related posts section
        $wp_customize->add_section( 'blog_single_related_posts_section', [
            'title' =>  esc_html__( 'Related Posts', 'blogistic' ),
            'priority'  =>  80,
            'panel' =>  'blog_single_section_panel'
        ]);

        // related articles option
        $wp_customize->add_setting( 'single_post_related_posts_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'single_post_related_posts_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
            'transport' => 'refresh'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'single_post_related_posts_option', [
                'label'	      => esc_html__( 'Show related articles', 'blogistic' ),
                'section'     => 'blog_single_related_posts_section',
                'settings'    => 'single_post_related_posts_option'
            ])
        );

        // related articles title
        $wp_customize->add_setting( 'single_post_related_posts_title', [
            'default' => BIT\blogistic_get_customizer_default( 'single_post_related_posts_title' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 'single_post_related_posts_title', [
            'type'      => 'text',
            'section'   => 'blog_single_related_posts_section',
            'label'     => esc_html__( 'Related articles title', 'blogistic' )
        ]);
    }
    add_action( 'customize_register', 'blogistic_blog_single_panel' );
endif;

if( ! function_exists( 'blogistic_page_setting_panel' ) ) :
    /**
     * Function for theme page setting panel
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_page_setting_panel( $wp_customize ) {
        $wp_customize->add_panel( 'page_setting_panel', [
            'title' =>  esc_html__( 'Page Settings', 'blogistic' ),
            'priority'  =>  85
        ]);

        // page settings section
        $wp_customize->add_section('page_settings_section',[
            'title' =>  esc_html__( 'Page Settings', 'blogistic' ),
            'panel' =>  'page_setting_panel',
            'priority' =>  10
        ]);

        // scroll to top section tab
        $wp_customize->add_setting( 'page_settings_section_tab', [
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'page_settings_section_tab', [
                'section'     => 'page_settings_section',
                'choices'  => [
                    [
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // page settings sidebar layout
        $wp_customize->add_setting( 'page_settings_sidebar_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'page_settings_sidebar_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'page_settings_sidebar_layout', [
                'label' =>  esc_html__( 'Sidebar Layout', 'blogistic' ),
                'section'   =>  'page_settings_section',
                'choices'  => [
                    'right-sidebar' => [
                        'label' => esc_html__( 'Right Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/right-sidebar.png'
                    ],
                    'left-sidebar' => [
                        'label' => esc_html__( 'Left Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/left-sidebar.png'
                    ],
                    'both-sidebar' => [
                        'label' => esc_html__( 'Both Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/both-sidebar.png'
                    ],
                    'no-sidebar' => [
                        'label' => esc_html__( 'No Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/no-sidebar.png'
                    ]
                ]
            ])
        );

        // page title option
        $wp_customize->add_setting( 'page_title_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_title_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'page_title_option', [
                'label' =>  esc_html__( 'Show page title', 'blogistic' ),
                'section'   =>  'page_settings_section'
            ])
        );

        // page thumbnail option
        $wp_customize->add_setting( 'page_thumbnail_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_thumbnail_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'page_thumbnail_option', [
                'label' =>  esc_html__( 'Show page thumbnail', 'blogistic' ),
                'section'   =>  'page_settings_section'
            ])
        );

        // page content option
        $wp_customize->add_setting( 'page_content_option', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_content_option' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'page_content_option', [
                'label' =>  esc_html__( 'Show post content', 'blogistic' ),
                'section'   =>  'page_settings_section'
            ])
        );

        // page image settings
        $wp_customize->add_setting( 'page_image_setting_heading', [
            'sanitize_callback' =>  'sanitize_text_field'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'page_image_setting_heading', [
                'label' =>  esc_html__( 'Image Settings', 'blogistic' ),
                'settings'  =>  'page_image_setting_heading',
                'section'   =>  'page_settings_section',
                'initial'   =>  false
            ])
        );

        // page image sizes
        $wp_customize->add_setting( 'page_image_size', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_image_size' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'page_image_size', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'page_image_size',
            'section'   =>  'page_settings_section',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // page image ratio
        $wp_customize->add_setting( 'page_responsive_image_ratio', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_responsive_image_ratio' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' =>  'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'page_responsive_image_ratio', [
                'label' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'settings'  =>  'page_responsive_image_ratio',
                'section'   =>  'page_settings_section',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  =>  0.1,
                    'reset'    =>  true
                ],
                'responsive'    =>  true
            ])
        );

        // page typography heading
        $wp_customize->add_setting( 'page_typography_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'page_typography_header', [
                'label' => esc_html__( 'Typography', 'blogistic' ),
                'section'   => 'page_settings_section',
                'tab'   => 'design'
            ])
        );

        // page title typo
        $wp_customize->add_setting( 'page_title_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_title_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'page_title_typo', [
                'label' =>  esc_html__( 'Page Title Typo', 'blogistic' ),
                'section'   =>  'page_settings_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // page content typo
        $wp_customize->add_setting( 'page_content_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'page_content_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'page_content_typo', [
                'label' =>  esc_html__( 'Page Content Typo', 'blogistic' ),
                'section'   =>  'page_settings_section',
                'tab'   =>  'design',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // page color settings heading
        $wp_customize->add_setting( 'page_color_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'page_color_settings_header', [
                'label' => esc_html__( 'Color Settings', 'blogistic' ),
                'section'   => 'page_settings_section',
                'tab'   => 'design'
            ])
        );

         // page background color
         $wp_customize->add_setting( 'page_background_color', [
            'default'   => BIT\blogistic_get_customizer_default( 'page_background_color' ),
            'sanitize_callback' => 'blogistic_sanitize_color_image_group_control',
            'transport' => 'postMessage'
        ]);
        
        $wp_customize->add_control( 
            new Blogistic_WP_Color_Image_Group_Control( $wp_customize, 'page_background_color', [
                'label' => esc_html__( 'Background Color', 'blogistic' ),
                'section'   => 'page_settings_section',
                'tab'   => 'design'
            ])
        );

        // error page settings section
        $wp_customize->add_section('error_page_settings_section', [
            'title' =>  esc_html__( '404 Page', 'blogistic' ),
            'panel' =>  'page_setting_panel',
            'priority' =>  30
        ]);

        // 404 sidebar layout
        $wp_customize->add_setting( 'error_page_sidebar_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'error_page_sidebar_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'error_page_sidebar_layout', [
                'label' =>  esc_html__( 'Sidebar Layout', 'blogistic' ),
                'section'   =>  'error_page_settings_section',
                'choices'  => [
                    'right-sidebar' => [
                        'label' => esc_html__( 'Right Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/right-sidebar.png'
                    ],
                    'left-sidebar' => [
                        'label' => esc_html__( 'Left Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/left-sidebar.png'
                    ],
                    'both-sidebar' => [
                        'label' => esc_html__( 'Both Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/both-sidebar.png'
                    ],
                    'no-sidebar' => [
                        'label' => esc_html__( 'No Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/no-sidebar.png'
                    ]
                ]
            ])
        );
        
        // 404 image field
        $wp_customize->add_setting( 'error_page_image', [
            'default' => BIT\blogistic_get_customizer_default( 'error_page_image' ),
            'sanitize_callback' => 'absint',
        ]);
        $wp_customize->add_control(
            new WP_Customize_Media_Control($wp_customize, 'error_page_image', [
                'section' => 'error_page_settings_section',
                'mime_type' => 'image',
                'label' => esc_html__( '404 Image', 'blogistic' ),
                'description' => esc_html__( 'Upload image that shows you are on 404 error page', 'blogistic' )
            ])
        );

        // search page settings - section
        $wp_customize->add_section( 'search_page_settings', [
            'title' =>  esc_html__( 'Search Page', 'blogistic' ),   
            'panel' =>  'page_setting_panel',
            'priority'  =>   30
        ]);

        // search page settings
        $wp_customize->add_setting( 'search_page_sidebar_layout', [
            'default'           => BIT\blogistic_get_customizer_default( 'search_page_sidebar_layout' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control',
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'search_page_sidebar_layout', [
                'label' =>  esc_html__( 'Sidebar Layout', 'blogistic' ),
                'section'   =>  'search_page_settings',
                'choices'  => [
                    'right-sidebar' => [
                        'label' => esc_html__( 'Right Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/right-sidebar.png'
                    ],
                    'left-sidebar' => [
                        'label' => esc_html__( 'Left Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/left-sidebar.png'
                    ],
                    'both-sidebar' => [
                        'label' => esc_html__( 'Both Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/both-sidebar.png'
                    ],
                    'no-sidebar' => [
                        'label' => esc_html__( 'No Sidebar', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/no-sidebar.png'
                    ]
                ]
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_page_setting_panel' );
endif;

if( !function_exists( 'blogistic_customizer_you_may_have_missed_panel' ) ) :
    /**
     * Register footer You May Have Missed Section settings
     * 
     */
    function blogistic_customizer_you_may_have_missed_panel( $wp_customize ) {
        /**
         * Theme You May Have Missed Section
         * 
         * panel - blogistic_customizer_you_may_have_missed_panel
         */
        $wp_customize->add_section( 'blogistic_customizer_you_may_have_missed_section', array(
            'title' => esc_html__( 'You May Have Missed', 'blogistic' ),
            'priority'  => 85
        ));

        // section tab
        $wp_customize->add_setting( 'you_may_have_missed_section_tab', [
            'default'   =>  'general',
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'you_may_have_missed_section_tab', [
                'section'   =>  'blogistic_customizer_you_may_have_missed_section',
                'priority'  =>  1,
                'choices'   =>  [
                    [
                        'name'  =>  'general',
                        'title' =>  esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  =>  'design',
                        'title' =>  esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // Footer Option
        $wp_customize->add_setting( 'you_may_have_missed_section_option', array(
            'default'   => BIT\blogistic_get_customizer_default( 'you_may_have_missed_section_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'you_may_have_missed_section_option', array(
                'label'	      => esc_html__( 'Enable you may have missed section', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'tab'   => 'general'
            ))
        );

        // you may have missed show section title
        $wp_customize->add_setting( 'you_may_have_missed_title_option', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_title_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
            'transport' =>  'postMessage'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'you_may_have_missed_title_option', array(
                'label'	      => esc_html__( 'Show section title', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section'
            ))
        );

        // // you may have missed section title
        $wp_customize->add_setting( 'you_may_have_missed_title', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_title' ),
            'sanitize_callback'  =>  'sanitize_text_field',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control( 'you_may_have_missed_title', [
            'label' =>  esc_html__( 'Section title', 'blogistic' ),
            'section'   =>  'blogistic_customizer_you_may_have_missed_section',
            'type'  =>  'text',
            'tab'   => 'general'
        ]);

        // you may have missed post query settings heading
        $wp_customize->add_setting( 'you_may_have_missed_post_query_settings_heading', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'you_may_have_missed_post_query_settings_heading', array(
                'label'	      => esc_html__( 'Post Query', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section'
            ))
        );

        // you may have missed slider categories
        $wp_customize->add_setting( 'you_may_have_missed_categories', array(
            'default' => BIT\blogistic_get_customizer_default( 'you_may_have_missed_categories' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Categories_Multiselect_Control( $wp_customize, 'you_may_have_missed_categories', array(
                'label'     => esc_html__( 'Posts Categories', 'blogistic' ),
                'section'   => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  => 'you_may_have_missed_categories',
                'choices'   => blogistic_get_multicheckbox_categories_simple_array()
            ))
        );

        // you may have missed posts to include
        $wp_customize->add_setting( 'you_may_have_missed_posts_to_include', array(
            'default' => BIT\blogistic_get_customizer_default( 'you_may_have_missed_posts_to_include' ),
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Posts_Multiselect_Control( $wp_customize, 'you_may_have_missed_posts_to_include', array(
                'label'     => esc_html__( 'Posts To Include', 'blogistic' ),
                'section'   => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  => 'you_may_have_missed_posts_to_include',
                'choices'   => blogistic_get_multicheckbox_posts_simple_array()
            ))
        );
        
        // you may have missed post order
        $wp_customize->add_setting( 'you_may_have_missed_post_order', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_post_order' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'you_may_have_missed_post_order', [
            'label' =>  esc_html( 'Post Order', 'blogistic' ),
            'type'  =>  'select',
            'priority'  =>  10,
            'section'   =>  'blogistic_customizer_you_may_have_missed_section',
            'settings'  =>  'you_may_have_missed_post_order',
            'choices'   =>  blogistic_post_order_args()
        ]);

        // you may have missed no of posts to show
        $wp_customize->add_setting( 'you_may_have_missed_no_of_posts_to_show', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_no_of_posts_to_show' ),
            'sanitize_callback' =>  'absint'
        ]);

        $wp_customize->add_control( 'you_may_have_missed_no_of_posts_to_show', [
            'label' =>  esc_html( 'No of posts to show', 'blogistic' ),
            'type'  =>  'number',
            'priority'  =>  10,
            'section'   =>  'blogistic_customizer_you_may_have_missed_section',
            'settings'  =>  'you_may_have_missed_no_of_posts_to_show',
            'input_attrs'    => [
                'min'   => 1,
                'max'   => 4,
                'step'  => 1
            ]
        ]);

        // you may have missed hide post with no featured image
        $wp_customize->add_setting( 'you_may_have_missed_hide_post_with_no_featured_image', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_hide_post_with_no_featured_image' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'you_may_have_missed_hide_post_with_no_featured_image', [
                'label' =>  esc_html__( 'Hide posts with no featured image', 'blogistic' ),
                'section'   =>  'blogistic_customizer_you_may_have_missed_section',
                'settings'  =>  'you_may_have_missed_hide_post_with_no_featured_image'
            ])
        );

        // you may have missed slider settings
        $wp_customize->add_setting( 'you_may_have_missed_post_elements_settings_heading', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'you_may_have_missed_post_elements_settings_heading', array(
                'label'	      => esc_html__( 'Post Elements Settings', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section'
            ))
        );

        // you may have missed post element show title
        $wp_customize->add_setting( 'you_may_have_missed_post_elements_show_title', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_post_elements_show_title' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'you_may_have_missed_post_elements_show_title', array(
                'label'	      => esc_html__( 'Show Title', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  =>  'you_may_have_missed_post_elements_show_title'
            ))
        );

        // you may have missed post title html tag
        $wp_customize->add_setting( 'you_may_have_missed_design_post_title_html_tag', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_design_post_title_html_tag' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control'
        ));
        
        $wp_customize->add_control( 'you_may_have_missed_design_post_title_html_tag', array(
            'label'	      => esc_html__( 'Title Tag', 'blogistic' ),
            'section'     => 'blogistic_customizer_you_may_have_missed_section',
            'settings'    => 'you_may_have_missed_design_post_title_html_tag',
            'tab'   =>  'design',
            'type'  =>  'select',
            'choices'   =>  [
                'h1'    =>  esc_html__( 'H1', 'blogistic' ),
                'h2'    =>  esc_html__( 'H2', 'blogistic' ),
                'h3'    =>  esc_html__( 'H3', 'blogistic' ),
                'h4'    =>  esc_html__( 'H4', 'blogistic' ),
                'h5'    =>  esc_html__( 'H5', 'blogistic' ),
                'h6'    =>  esc_html__( 'H6', 'blogistic' )
            ]
        ));

        // you may have missed post element show categories
        $wp_customize->add_setting( 'you_may_have_missed_post_elements_show_categories', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_post_elements_show_categories' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'you_may_have_missed_post_elements_show_categories', array(
                'label'	      => esc_html__( 'Show Categories', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  =>  'you_may_have_missed_post_elements_show_categories'
            ))
        );

        // you may have missed post element show date
        $wp_customize->add_setting( 'you_may_have_missed_post_elements_show_date', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_post_elements_show_date' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'you_may_have_missed_post_elements_show_date', array(
                'label'	      => esc_html__( 'Show Date', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  =>  'you_may_have_missed_post_elements_show_date'
            ))
        );

        // you may have missed post element show author
        $wp_customize->add_setting( 'you_may_have_missed_post_elements_show_author', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_post_elements_show_author' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'you_may_have_missed_post_elements_show_author', array(
                'label'	      => esc_html__( 'Show Author', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  =>  'you_may_have_missed_post_elements_show_author'
            ))
        );

        // you may have missed date icon
        $wp_customize->add_setting( 'you_may_have_missed_date_icon', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_date_icon' ),
            'sanitize_callback' => 'blogistic_sanitize_icon_picker_control'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Icon_Picker_Control( $wp_customize, 'you_may_have_missed_date_icon', array(
                'label'	      => esc_html__( 'Choose Date Icon', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'  =>  'you_may_have_missed_date_icon'
            ))
        );

        // you may have missed post element alignment
        $wp_customize->add_setting( 'you_may_have_missed_post_elements_alignment', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_post_elements_alignment' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport' =>  'postMessage'
        ));
        $wp_customize->add_control(
            new Blogistic_WP_Radio_Tab_Control( $wp_customize, 'you_may_have_missed_post_elements_alignment', array(
                'label'	      => esc_html__( 'Elements Alignment', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'choices' => array(
                    array(
                        'value' => 'left',
                        'label' => esc_html__('Left', 'blogistic' )
                    ),
                    array(
                        'value' => 'center',
                        'label' => esc_html__('Center', 'blogistic' )
                    ),
                    array(
                        'value' => 'right',
                        'label' => esc_html__('Right', 'blogistic' )
                    )
                )
            ))
        );

        // you may have missed image settings
        $wp_customize->add_setting( 'you_may_have_missed_image_setting_heading', [
            'sanitize_callback' =>  'sanitize_text_field'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'you_may_have_missed_image_setting_heading', [
                'label' =>  esc_html__( 'Image Settings', 'blogistic' ),
                'settings'  =>  'you_may_have_missed_image_setting_heading',
                'section'   =>  'blogistic_customizer_you_may_have_missed_section'
            ])
        );

        // you may have missed image sizes
        $wp_customize->add_setting( 'you_may_have_missed_image_sizes', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_image_sizes' ),
            'sanitize_callback' =>  'blogistic_sanitize_select_control'
        ]);

        $wp_customize->add_control( 'you_may_have_missed_image_sizes', [
            'label' =>  esc_html__( 'Image Sizes', 'blogistic' ),
            'type'  =>  'select',
            'settings'  =>  'you_may_have_missed_image_sizes',
            'section'   =>  'blogistic_customizer_you_may_have_missed_section',
            'choices'   =>  blogistic_get_image_sizes_option_array_for_customizer()
        ]);

        // you may have missed image ratio
        $wp_customize->add_setting( 'you_may_have_missed_responsive_image_ratio', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_responsive_image_ratio' ),
            'sanitize_callback' =>  'blogistic_sanitize_responsive_range',
            'transport' => 'postMessage'
        ]);

        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'you_may_have_missed_responsive_image_ratio', [
                'label' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'settings'  =>  'you_may_have_missed_responsive_image_ratio',
                'section'   =>  'blogistic_customizer_you_may_have_missed_section',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'min'   =>  0,
                    'max'   =>  2,
                    'step'  =>  0.1,
                    'reset'    =>  true
                ],
                'responsive'    =>  true
            ])
        );

        // animation object color
        $wp_customize->add_setting( 'you_may_have_missed_title_color', [
            'default'   => BIT\blogistic_get_customizer_default( 'you_may_have_missed_title_color' ),
            'transport' => 'postMessage',
            'sanitize_callback' => 'blogistic_sanitize_color_picker_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Color_Picker_Control( $wp_customize, 'you_may_have_missed_title_color', [
                'label'	      => esc_html__( 'Section Title color', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'    => 'you_may_have_missed_title_color',
                'tab'   =>  'design'
            ])
        );
        
        // you may have missed -> design tab -> typography
        $wp_customize->add_setting( 'you_may_have_missed_design_typography', array(
            'sanitize_callback' => 'sanitize_text_field'
        ));
        
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'you_may_have_missed_design_typography', array(
                'label'	      => esc_html__( 'Typography', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'    => 'you_may_have_missed_design_typography',
                'tab'   =>  'design'
            ))
        );

        // you may have missed section title typography
        $wp_customize->add_setting( 'you_may_have_missed_design_section_title_typography', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_design_section_title_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'you_may_have_missed_design_section_title_typography', array(
                'label'	      => esc_html__( 'Section Title Typo', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'tab'   =>  'design'
            ))
        );

        // you may have missed post title typography
        $wp_customize->add_setting( 'you_may_have_missed_design_post_title_typography', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_design_post_title_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'you_may_have_missed_design_post_title_typography', array(
                'label'	      => esc_html__( 'Title Typo', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'    => 'you_may_have_missed_design_post_title_typography',
                'tab'   =>  'design'
            ))
        );


        // you may have missed post categories typography
        $wp_customize->add_setting( 'you_may_have_missed_design_post_categories_typography', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_design_post_categories_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'you_may_have_missed_design_post_categories_typography', array(
                'label'	      => esc_html__( 'Category Typo', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'    => 'you_may_have_missed_design_post_categories_typography',
                'tab'   =>  'design'
            ))
        );

         // you may have missed post date typography
         $wp_customize->add_setting( 'you_may_have_missed_design_post_date_typography', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_design_post_date_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'you_may_have_missed_design_post_date_typography', array(
                'label'	      => esc_html__( 'Date Typo', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'    => 'you_may_have_missed_design_post_date_typography',
                'tab'   =>  'design'
            ))
        );

         // you may have missed post date typography
         $wp_customize->add_setting( 'you_may_have_missed_design_post_author_typography', array(
            'default'   =>  BIT\blogistic_get_customizer_default( 'you_may_have_missed_design_post_author_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ));
        
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'you_may_have_missed_design_post_author_typography', array(
                'label'	      => esc_html__( 'Author Typo', 'blogistic' ),
                'section'     => 'blogistic_customizer_you_may_have_missed_section',
                'settings'    => 'you_may_have_missed_design_post_author_typography',
                'tab'   =>  'design'
            ))
        );
    }
add_action( 'customize_register', 'blogistic_customizer_you_may_have_missed_panel', 10 );
endif;

if( !function_exists( 'blogistic_customizer_footer_panel' ) ) :
    /**
     * Register footer options settings
     * 
     */
    function blogistic_customizer_footer_panel( $wp_customize ) {
        /**
         * Theme Footer Section
         */
        $wp_customize->add_section( 'footer_section', [
            'title' => esc_html__( 'Theme Footer', 'blogistic' ),
            'priority'  => 85
        ]);
        
        // section tab
        $wp_customize->add_setting( 'footer_section_tab', [
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'footer_section_tab', [
                'section'     => 'footer_section',
                'choices'  => [
                    [
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ])
        );

        // Footer Option
        $wp_customize->add_setting( 'footer_option', [
            'default'   => BIT\blogistic_get_customizer_default( 'footer_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'footer_option', [
                'label'	      => esc_html__( 'Enable footer section', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_option',
                'tab'   => 'general'
            ])
        );

        // Add the footer layout control.
        $wp_customize->add_setting( 'footer_widget_column', [
            'default'           => BIT\blogistic_get_customizer_default( 'footer_widget_column' ),
            'sanitize_callback' => 'blogistic_sanitize_select_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Radio_Image_Control( $wp_customize, 'footer_widget_column', [
                'section'  => 'footer_section',
                'tab'   => 'general',
                'choices'  => [
                    'column-one' => [
                        'label' => esc_html__( 'Column One', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/footer_column_one.png'
                    ],
                    'column-two' => [
                        'label' => esc_html__( 'Column Two', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/footer_column_two.png'
                    ],
                    'column-three' => [
                        'label' => esc_html__( 'Column Three', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/footer_column_three.png'
                    ],
                    'column-four' => [
                        'label' => esc_html__( 'Column Four', 'blogistic' ),
                        'url'   => '%s/assets/images/customizer/footer_column_four.png'
                    ]
                ]
            ]
        ));
        
        // Redirect widgets link
        $wp_customize->add_setting( 'footer_widgets_redirects', [
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Redirect_Control( $wp_customize, 'footer_widgets_redirects', [
                'label'	      => esc_html__( 'Widgets', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_widgets_redirects',
                'tab'   => 'general',
                'choices'     => [
                    'footer-column-one' => [
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar-column-one',
                        'label' => esc_html__( 'Manage footer widget one', 'blogistic' )
                    ]
                ],
                'active_callback'   =>  function( $control ) {
                    return ( $control->manager->get_setting( 'footer_option' )->value() );
                }
            ]
        ));
        // Redirect widgets link
        $wp_customize->add_setting( 'footer_widgets_redirects_two', [
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Redirect_Control( $wp_customize, 'footer_widgets_redirects_two', [
                'label'	      => esc_html__( 'Widgets 2', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_widgets_redirects_two',
                'tab'   => 'general',
                'choices'     => [
                    'footer-column-two' => [
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar-column-two',
                        'label' => esc_html__( 'Manage footer widget two', 'blogistic' )
                    ]
                    ],
                'active_callback'   =>  function( $control ) {
                    return ( $control->manager->get_setting( 'footer_option' )->value() && $control->manager->get_setting( 'footer_widget_column' )->value() != 'column-one' );
                }
            ]
        ));
        // Redirect widgets link
        $wp_customize->add_setting( 'footer_widgets_redirects_three', [
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Redirect_Control( $wp_customize, 'footer_widgets_redirects_three', [
                'label'	      => esc_html__( 'Widgets 3', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_widgets_redirects_three',
                'tab'   => 'general',
                'choices'     => [
                    'footer-column-three' => [
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar-column-three',
                        'label' => esc_html__( 'Manage footer widget three', 'blogistic' )
                    ]
                ],
                'active_callback'   =>  function( $control ) {
                    $footer_widget_column = $control->manager->get_setting( 'footer_widget_column' )->value();
                    return ( $control->manager->get_setting( 'footer_option' )->value() && in_array( $footer_widget_column, [ 'column-three', 'column-four' ] ) );
                }
            ]
        ));

        // Redirect widgets link
        $wp_customize->add_setting( 'footer_widgets_redirects_four', [
            'sanitize_callback' => 'blogistic_sanitize_toggle_control',
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Redirect_Control( $wp_customize, 'footer_widgets_redirects_four', [
                'label'	      => esc_html__( 'Widgets 4', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_widgets_redirects_four',
                'tab'   => 'general',
                'choices'     => [
                    'footer-column-four' => [
                        'type'  => 'section',
                        'id'    => 'sidebar-widgets-footer-sidebar-column-four',
                        'label' => esc_html__( 'Manage footer widget four', 'blogistic' )
                    ]
                ],
                'active_callback'   =>  function( $control ) {
                    return ( $control->manager->get_setting( 'footer_option' )->value() && $control->manager->get_setting( 'footer_widget_column' )->value() == 'column-four' );
                }
            ]
        ));

        // theme footer typography
        $wp_customize->add_setting( 'theme_footer_typography', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'theme_footer_typography', [
                'label'	      => esc_html__( 'Typography', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'theme_footer_typography',
                'tab'   =>  'design'
            ]
        ));

        // main banner post title typography
        $wp_customize->add_setting( 'footer_title_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'footer_title_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'footer_title_typography', [
                'label'	      => esc_html__( 'Block Title Typo', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_title_typography',
                'tab'   =>  'design'
            ]
        ));

        // main banner post title typography
        $wp_customize->add_setting( 'footer_text_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'footer_text_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'footer_text_typography', [
                'label'	      => esc_html__( 'Text Typo', 'blogistic' ),
                'section'     => 'footer_section',
                'settings'    => 'footer_text_typography',
                'tab'   =>  'design'
            ]
        ));
    }
    add_action( 'customize_register', 'blogistic_customizer_footer_panel', 10 );
endif;

if( !function_exists( 'blogistic_customizer_bottom_footer_panel' ) ) :
    /**
     * Register bottom footer options settings
     * 
     */
    function blogistic_customizer_bottom_footer_panel( $wp_customize ) {
        /**
         * Bottom Footer Section
         * 
         * panel - blogistic_footer_panel
         */
        $wp_customize->add_section( 'bottom_footer_section', [
            'title' => esc_html__( 'Bottom Footer', 'blogistic' ),
            'priority'  => 85
        ]);

        // section tab
        $wp_customize->add_setting( 'bottom_footer_section_tab', [
            'sanitize_callback' => 'sanitize_text_field',
            'default'   => 'general'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Tab_Control( $wp_customize, 'bottom_footer_section_tab', [
                'section'     => 'bottom_footer_section',
                'choices'  => [
                    [
                        'name'  => 'general',
                        'title'  => esc_html__( 'General', 'blogistic' )
                    ],
                    [
                        'name'  => 'design',
                        'title'  => esc_html__( 'Design', 'blogistic' )
                    ]
                ]
            ]
        ));

        // Bottom Footer Option
        $wp_customize->add_setting( 'bottom_footer_option', [
            'default'         => BIT\blogistic_get_customizer_default( 'bottom_footer_option' ),
            'sanitize_callback' => 'blogistic_sanitize_toggle_control'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Toggle_Control( $wp_customize, 'bottom_footer_option', [
                'label'	      => esc_html__( 'Enable bottom footer', 'blogistic' ),
                'section'     => 'bottom_footer_section',
                'settings'    => 'bottom_footer_option'
            ]
        ));

        // bottom footer copyright settings
         $wp_customize->add_setting( 'bottom_footer_copyright_setting_heading', [
            'sanitize_callback' =>  'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'bottom_footer_copyright_setting_heading', [
                'label' =>  esc_html__( 'Copyright Settings', 'blogistic' ),
                'settings'  =>  'bottom_footer_copyright_setting_heading',
                'section'   =>  'bottom_footer_section',
                'initial'   =>  false
            ]
        ));

        // Bottom footer site info
        $wp_customize->add_setting( 'bottom_footer_site_info', [
            'default'    => BIT\blogistic_get_customizer_default( 'bottom_footer_site_info' ),
            'sanitize_callback' => 'wp_kses_post'
        ]);
        $wp_customize->add_control( 'bottom_footer_site_info', [
            'label'	      => esc_html__( 'Copyright Text', 'blogistic' ),
            'section'     => 'bottom_footer_section',
            'description' => esc_html__( 'Add %year% to retrieve current year.', 'blogistic' ),
            'type'  =>  'textarea'
        ]);

        // footer logo show/hide option
        $wp_customize->add_setting( 'bottom_footer_show_social_icons', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'bottom_footer_show_social_icons' ),
            'sanitize_callback' =>  'blogistic_sanitize_toggle_control',
            'transport' =>  'refresh'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Simple_Toggle_Control( $wp_customize, 'bottom_footer_show_social_icons', [
                'label'	      => esc_html__( 'Show social icons', 'blogistic' ),
                'section'     => 'bottom_footer_section'
            ]
        ));

         // theme footer typography
         $wp_customize->add_setting( 'bottom_footer_typography', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'bottom_footer_typography', [
                'label'	      => esc_html__( 'Typography', 'blogistic' ),
                'section'     => 'bottom_footer_section',
                'settings'    => 'bottom_footer_typography',
                'tab'   =>  'design'
            ]
        ));

        // main banner post title typography
        $wp_customize->add_setting( 'bottom_footer_text_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'bottom_footer_text_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'bottom_footer_text_typography', [
                'label'	      => esc_html__( 'Text Typo', 'blogistic' ),
                'section'     => 'bottom_footer_section',
                'settings'    => 'bottom_footer_text_typography',
                'tab'   =>  'design'
            ]
        ));

        // main banner post title typography
        $wp_customize->add_setting( 'bottom_footer_link_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'bottom_footer_link_typography' ),
            'sanitize_callback' => 'blogistic_sanitize_typo_control',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control( 
            new Blogistic_WP_Typography_Control( $wp_customize, 'bottom_footer_link_typography', [
                'label'	      => esc_html__( 'Link Typo', 'blogistic' ),
                'section'     => 'bottom_footer_section',
                'settings'    => 'bottom_footer_link_typography',
                'tab'   =>  'design'
            ]
        ));
    }
    add_action( 'customize_register', 'blogistic_customizer_bottom_footer_panel', 10 );
endif;

if( ! function_exists( 'blogistic_typography_section' ) ) :
    /**
     * Register controls for typography section
     * 
     * @since 1.0.0
     */
    function blogistic_typography_section( $wp_customize ) {
        // typography
        $wp_customize->add_section( 'typography_section', [
            'title' => esc_html__( 'Typography', 'blogistic' ),
            'priority'  => 30
        ]);

        // heading one typo
        $wp_customize->add_setting( 'heading_one_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'heading_one_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'heading_one_typo', [
                'label' =>  esc_html__( 'Heading 1', 'blogistic' ),
                'section'   =>  'typography_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading two typo
        $wp_customize->add_setting( 'heading_two_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'heading_two_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'heading_two_typo', [
                'label' =>  esc_html__( 'Heading 2', 'blogistic' ),
                'section'   =>  'typography_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading three typo
        $wp_customize->add_setting( 'heading_three_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'heading_three_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'heading_three_typo', [
                'label' =>  esc_html__( 'Heading 3', 'blogistic' ),
                'section'   =>  'typography_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading four typo
        $wp_customize->add_setting( 'heading_four_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'heading_four_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'heading_four_typo', [
                'label' =>  esc_html__( 'Heading 4', 'blogistic' ),
                'section'   =>  'typography_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading five typo
        $wp_customize->add_setting( 'heading_five_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'heading_five_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'heading_five_typo', [
                'label' =>  esc_html__( 'Heading 5', 'blogistic' ),
                'section'   =>  'typography_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading six typo
        $wp_customize->add_setting( 'heading_six_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'heading_six_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'heading_six_typo', [
                'label' =>  esc_html__( 'Heading 6', 'blogistic' ),
                'section'   =>  'typography_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_typography_section' );
endif;

if( !function_exists( 'blogistic_customizer_widgets_panel' ) ) :
    /**
     * Register widgets styles settings
     * 
     */
    function blogistic_customizer_widgets_panel( $wp_customize ) {
        /**
         * Widget Styles Section
         * 
         * panel - blogistic_widget_styles_panel
         */
        $wp_customize->add_section( 'blogistic_widget_styles_section', [
            'title' => esc_html__( 'Widget Styles', 'blogistic' ),
            'priority'  => 30
        ]);

        // Widget styles settings heading
         $wp_customize->add_setting( 'widget_styles_general_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'widget_styles_general_settings_header', [
                'label'	      => esc_html__( 'General Settings', 'blogistic' ),
                'section'     => 'blogistic_widget_styles_section'
            ]
        ));

        // widget styles border radius
        $wp_customize->add_setting( 'sidebar_border_radius', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_border_radius' ),
            'sanitize_callback' =>  'absint',
            'transport' => 'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Number_Control( $wp_customize, 'sidebar_border_radius', [
                'label' =>  esc_html__( 'Border Radius (px)', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'settings'  =>  'sidebar_border_radius',
                'unit'  =>  'px',
                'input_attrs'   =>  [
                    'max'   =>  50,
                    'min'   =>  0,
                    'step'  =>  1,
                    'reset' =>  true
                ]
            ])
        );

        // Widget styles settings heading
        $wp_customize->add_setting( 'widget_styles_sidebar_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'widget_styles_sidebar_settings_header', [
                'label'	      => esc_html__( 'Sidebar Typography', 'blogistic' ),
                'section'     => 'blogistic_widget_styles_section'
            ]
        ));

        // block title typo
        $wp_customize->add_setting( 'sidebar_block_title_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_block_title_typography' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_block_title_typography', [
                'label' =>  esc_html__( 'Block Title', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // post title typo
        $wp_customize->add_setting( 'sidebar_post_title_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_post_title_typography' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_post_title_typography', [
                'label' =>  esc_html__( 'Post Title', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // post category typo
        $wp_customize->add_setting( 'sidebar_category_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_category_typography' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_category_typography', [
                'label' =>  esc_html__( 'Category', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // post category typo
        $wp_customize->add_setting( 'sidebar_date_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_date_typography' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_date_typography', [
                'label' =>  esc_html__( 'Date', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // widget pagination button typo
        $wp_customize->add_setting( 'sidebar_pagination_button_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_pagination_button_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_pagination_button_typo', [
                'label' =>  esc_html__( 'Pagination typo', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        $wp_customize->add_setting( 'widget_styles_headings_settings_header', [
            'sanitize_callback' => 'sanitize_text_field'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Section_Heading_Toggle_Control( $wp_customize, 'widget_styles_headings_settings_header', [
                'label'	      => esc_html__( 'Heading Typography', 'blogistic' ),
                'section'     => 'blogistic_widget_styles_section'
            ]
        ));

        // heading one typo
        $wp_customize->add_setting( 'sidebar_heading_one_typography', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_heading_one_typography' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_heading_one_typography', [
                'label' =>  esc_html__( 'Heading 1', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading two typo
        $wp_customize->add_setting( 'sidebar_heading_two_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_heading_two_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_heading_two_typo', [
                'label' =>  esc_html__( 'Heading 2', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading three typo
        $wp_customize->add_setting( 'sidebar_heading_three_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_heading_three_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_heading_three_typo', [
                'label' =>  esc_html__( 'Heading 3', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading four typo
        $wp_customize->add_setting( 'sidebar_heading_four_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_heading_four_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_heading_four_typo', [
                'label' =>  esc_html__( 'Heading 4', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading five typo
        $wp_customize->add_setting( 'sidebar_heading_five_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_heading_five_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_heading_five_typo', [
                'label' =>  esc_html__( 'Heading 5', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );

        // heading six typo
        $wp_customize->add_setting( 'sidebar_heading_six_typo', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'sidebar_heading_six_typo' ),
            'sanitize_callback' =>  'blogistic_sanitize_typo_control',
            'transport' =>  'postMessage'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Typography_Control( $wp_customize, 'sidebar_heading_six_typo', [
                'label' =>  esc_html__( 'Heading 6', 'blogistic' ),
                'section'   =>  'blogistic_widget_styles_section',
                'fields'    =>  [ 'font_family', 'font_weight', 'font_size', 'line_height', 'letter_spacing', 'text_transform', 'text_decoration' ]
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_customizer_widgets_panel', 10 );
endif;

if( !function_exists( 'blogistic_customizer_mobile_options_panel' ) ) :
    /**
     * Register mobile options settings
     * 
     */
    function blogistic_customizer_mobile_options_panel( $wp_customize ) {
        /**
         * Mobile Options Section
         * 
         * panel - blogistic_mobile_options_panel
         */
        $wp_customize->add_section( 'blogistic_mobile_options_section', [
            'title' => esc_html__( 'Mobile Options', 'blogistic' ),
            'priority'  => 30
        ]);

        $mobile_option_args = [
            'sub_menu_mobile_option'    =>  esc_html__( 'Show sub menu on mobile', 'blogistic' ),
            'show_custom_button_mobile_option'  =>  esc_html__( 'Show custom button on mobile', 'blogistic' ),
            'show_readmore_button_mobile_option'    =>  esc_html__( 'Show readmore button on mobile', 'blogistic' ),
            'scroll_to_top_mobile_option'   =>  esc_html__( 'Show scroll to top on mobile', 'blogistic' )
        ];
        if( ! empty( $mobile_option_args ) && is_array( $mobile_option_args ) ) :
            foreach( $mobile_option_args as $control => $label ) :
                $wp_customize->add_setting( $control, [
                    'default'   =>  BIT\blogistic_get_customizer_default( $control ),
                    'sanitize_callback' =>  'blogistic_sanitize_checkbox',
                    'transport' =>  'postMessage'
                ]);
                $wp_customize->add_control( $control, [
                    'label' =>  esc_html( $label ),
                    'type'  =>  'checkbox',
                    'section'   =>  'blogistic_mobile_options_section'
                ]);        
            endforeach;
        endif;
    }
    add_action( 'customize_register', 'blogistic_customizer_mobile_options_panel', 10 );
endif;

if( ! function_exists( 'blogistic_advertisement_section' ) ) :
    /**
     * Register controls for advertisement section
     * 
     * @since 1.0.0
     */
    function blogistic_advertisement_section( $wp_customize ){
        $wp_customize->add_section( 'advertisement_section', [
            'title' =>  esc_html__( 'Advertisement', 'blogistic' ),
            'priority'  =>  29
        ]);

        // advertisement - repeater
        $wp_customize->add_setting( 'advertisement_repeater', [
            'default'   =>  BIT\blogistic_get_customizer_default( 'advertisement_repeater' ),
            'sanitize_callback' =>  'blogistic_sanitize_repeater_control'
        ]);
        $wp_customize->add_control(
            new Blogistic_WP_Custom_Repeater( $wp_customize, 'advertisement_repeater', [
                'label'         => esc_html__( 'Advertisements', 'blogistic' ),
                'description'   => esc_html__( 'Hold and drag vertically to re-order the icons', 'blogistic' ),
                'section'       => 'advertisement_section',
                'settings'      => 'advertisement_repeater',
                'row_label'     => esc_html__( 'Advertisement', 'blogistic' ),
                'add_new_label' => esc_html__( 'Add New Advertisement', 'blogistic' ),
                'fields'        => [
                    'item_image'   => [
                        'type'          => 'image',
                        'label'         => esc_html__( 'Image', 'blogistic' ),
                        'default'       => 0
                    ],
                    'item_url'  => [
                        'type'      => 'url',
                        'label'     => esc_html__( 'URL', 'blogistic' ),
                        'default'   => ''
                    ],
                    'item_target'   =>  [
                        'type'  =>  'select',
                        'label' =>  esc_html__( 'Target', 'blogistic' ),
                        'default'   =>  '_self',
                        'options'   =>  [
                            '_blank'    =>  esc_html__( 'Show in new tab', 'blogistic' ),
                            '_self'    =>  esc_html__( 'Show in same tab', 'blogistic' )
                        ]
                    ],
                    'item_rel_attribute'    =>  [
                        'type'  =>  'select',
                        'label' =>  esc_html__( 'Rel', 'blogistic' ),
                        'default'   =>  'opener',
                        'options'   =>  [
                            'nofollow'  =>  esc_html__( 'No follow', 'blogistic' ),
                            'noopener'  =>  esc_html__( 'No opener', 'blogistic' ),
                            'noreferrer'  =>  esc_html__( 'No referrer', 'blogistic' )
                        ]
                    ],
                    'item_heading'  =>  [
                        'type'  =>  'heading',
                        'label' =>  esc_html__( 'Display Area', 'blogistic' )
                    ],
                    'item_checkbox_header' =>  [
                        'type'  =>  'checkbox',
                        'label' =>  esc_html__( 'After Header', 'blogistic' ),  
                        'default'   =>  false
                    ],
                    'item_checkbox_before_post_content' =>  [
                        'type'  =>  'checkbox',
                        'label' =>  esc_html__( 'Before post content', 'blogistic' ),  
                        'default'   =>  false
                    ],
                    'item_checkbox_after_post_content' =>  [
                        'type'  =>  'checkbox',
                        'label' =>  esc_html__( 'After post content', 'blogistic' ),  
                        'default'   =>  false
                    ],
                    'item_checkbox_random_post_archives' =>  [
                        'type'  =>  'checkbox',
                        'label' =>  esc_html__( 'Random post archives', 'blogistic' ),  
                        'default'   =>  false
                    ],
                    'item_checkbox_stick_with_footer' =>  [
                        'type'  =>  'checkbox',
                        'label' =>  esc_html__( 'Stick with footer', 'blogistic' ),  
                        'default'   =>  false
                    ],
                    'item_alignment'    =>   [
                        'type'  =>  'alignment',
                        'label' =>  esc_html__( 'Ad Alignment', 'blogistic' ),
                        'default'   =>  'left',
                        'options'   =>  [
                            'left'  =>  esc_html__( 'Left', 'blogistic' ),
                            'center'  =>  esc_html__( 'Center', 'blogistic' ),
                            'right'  =>  esc_html__( 'Right', 'blogistic' )
                        ]
                    ],
                    'item_image_option' =>  [
                        'type'  =>  'select',
                        'label' =>  esc_html__( 'Image Option', 'blogistic' ),
                        'default'   =>  'original',
                        'options'   =>  [
                            'full_width'  =>  esc_html__( 'Full Width', 'blogistic' ),
                            'original'  =>  esc_html__( 'Original', 'blogistic' )
                        ]
                    ],
                    'item_option'             => 'show'
                ]
            ])
        );
    }
    add_action( 'customize_register', 'blogistic_advertisement_section' );
endif;

// extract to the customizer js
$blogisticAddAction = function() {
    $action_prefix = "wp_ajax_" . "blogistic_";
    // retrieve posts with search key
    add_action( $action_prefix . 'get_multicheckbox_posts_simple_array', function() {
        check_ajax_referer( 'blogistic-customizer-controls-live-nonce', 'security' );
        $searchKey = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
        $post_args = [ 'numberposts' => 10, 's' => esc_html( $searchKey ) ];
        $posts_list = get_posts( apply_filters( 'blogistic_query_args_filter', $post_args ) );
        foreach( $posts_list as $postItem ) :
            $posts_array[] = [ 
                'value'	=> absint( $postItem->ID ),
                'label'	=> esc_html( str_replace( [ '\'', '"' ], '', $postItem->post_title ) )
            ];
        endforeach;
        wp_send_json_success( $posts_array );
        wp_die();
    });

    // retrieve categories with search key
    add_action( $action_prefix . 'get_multicheckbox_categories_simple_array', function() {
        check_ajax_referer( 'blogistic-customizer-controls-live-nonce', 'security' );
        $searchKey = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
        $categories_list = get_categories( [ 'number' => 10, 'search' => esc_html( $searchKey ) ] );
        $categories_array = [];
        foreach( $categories_list as $categoryItem ) :
            $categories_array[] = [
                'value'	=> absint( $categoryItem->term_id ),
                'label'	=> esc_html( str_replace( [ '\'', '"' ], '', $categoryItem->name ) ) . ' (' .absint( $categoryItem->count ) . ')'
            ];
        endforeach;
        wp_send_json_success( $categories_array );
        wp_die();
    });

    // retrieve tags with search key
    add_action( $action_prefix . 'get_multicheckbox_tags_simple_array', function() {
        check_ajax_referer( 'blogistic-customizer-controls-live-nonce', 'security' );
        $searchKey = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
        $tags_list = get_tags( [ 'number' => 10, 'search' => esc_html( $searchKey ) ] );
        $tags_array = [];
        foreach( $tags_list as $tagItem ) :
            $tags_array[] = [
                'value'	=> absint( $tagItem->term_id ),
                'label'	=> esc_html( str_replace( [ '\'', '"' ], '', $tagItem->name ) )
            ];
        endforeach;
        wp_send_json_success( $tags_array );
        wp_die();
    });

    // retrieve authors with search key
    add_action( $action_prefix . 'get_multicheckbox_authors_simple_array', function() {
        check_ajax_referer( 'blogistic-customizer-controls-live-nonce', 'security' );
        $searchKey = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';
        $users_list = get_users( [ 'number' => 10, 'search' => esc_html($searchKey ) ] );
        foreach( $users_list as $userItem ) :
            $users_array[] = [
                'value'	=> absint( $userItem->ID ),
                'label'	=> esc_html( str_replace( [ '\'', '"' ], '', $userItem->display_name ) )
            ];
        endforeach;
        wp_send_json_success( $users_array );
        wp_die();
    });

    // typography fonts url
    add_action( $action_prefix . 'typography_fonts_url', function() {
        check_ajax_referer( 'blogistic-customizer-nonce', 'security' );
		// enqueue inline style
		ob_start();
			echo esc_url( blogistic_typo_fonts_url() );
        $blogistic_typography_fonts_url = ob_get_clean();
		echo apply_filters( 'blogistic_typography_fonts_url', esc_url( $blogistic_typography_fonts_url ) );
		wp_die();
	});
};
$blogisticAddAction();

// Imports previous customizer settings on exists
add_action( "wp_ajax_blogistic_import_custmomizer_setting", function() {
    // check_ajax_referer( 'blogistic-customizer-controls-nonce', 'security' );
    $n_setting = wp_get_theme()->get_stylesheet();
    $old_setting = get_option( 'theme_mods_blogistic' );
    if( ! $old_setting ) return;
    $current_setting = get_option( 'theme_mods_' . $n_setting );
    if( update_option( 'theme_mods_' .$n_setting. '-old', $current_setting ) ) {
        if( update_option( 'theme_mods_' . $n_setting, $old_setting ) ) {
            return true;
        }
    }
    return;
    wp_die();
});

if( ! function_exists( 'blogistic_wp_query' ) ) :
    /**
     * Returns permalink
     * 
     * @param post_type
     * @since 1.0.0
     * @package Blogistic
     */
    function blogistic_wp_query( $type ) {
        $permalink = home_url();
        switch( $type ) :
            case ( in_array( $type, [ 'page', 'post' ] ) ):
                    $type_args = [
                        'post_type'	=>	$type,
                        'posts_per_page'	=>	1,
                        'orderby'	=>	'rand'	
                    ];
                    if( $type == 'search' ) $type_args['s'] = 'a';
                    $type_query = new \WP_Query( apply_filters( 'blogistic_query_args_filter', $type_args ) );
                    if( $type_query->have_posts() ) :
                        while( $type_query->have_posts() ):
                            $type_query->the_post();
                            $permalink = get_the_permalink();
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    return $permalink;
                break;
            case ( in_array( $type, [ 'tag', 'category' ] ) ):
                    $nexus_collective = function( $args ){
                        return get_terms( $args );
                    };
                    $taxonomy = ( $type == 'category' ) ? 'category' : 'post_tag';
                    $total = count( $nexus_collective([ 'taxonomy'  =>  $taxonomy, 'number' => 0 ]) );
                    $random_number = rand( 0, ( $total - 1 ) );
                    $taxonomy_args = [
                        'orderby'   =>  'rand',
                        'number'    =>  1,
                        'taxonomy'  =>  $taxonomy,
                        'offset'	=>	$random_number
                    ];
                    $get_taxonomies = $nexus_collective( $taxonomy_args );
                    if( ! empty( $get_taxonomies ) && is_array( $get_taxonomies ) ) :
                        foreach( $get_taxonomies as $taxonomy ) :
                            $permalink = get_term_link( $taxonomy->term_id );
                        endforeach;
                    endif;
                    return $permalink;
                break;
            case 'author':
                    $nexus_collective = function( $args ) {
                        return new \WP_User_Query( $args );
                    };
                    $total = $nexus_collective( [ 'number' => 0 ] )->get_total();
                    $random_number = rand( 0, ( $total - 1 ) );
                    $author_args = [
                        'number'    =>  1,
                        'offset'    =>  $random_number
                    ];
                    $user_query = $nexus_collective( $author_args );
                    if ( ! empty( $user_query->get_results() ) ) :
                        foreach ( $user_query->get_results() as $user ) :
                            $permalink = get_author_posts_url( $user->data->ID );
                        endforeach;
                    endif;
                    wp_reset_postdata();
                    return $permalink;
                break;
        endswitch;
    }
endif;

if( ! function_exists( 'blogistic_customizer_custom_callback' ) ) :
    function blogistic_customizer_custom_callback () {
        $nexus_collective = function( $type ) {
            return blogistic_wp_query( $type );
        };
        wp_localize_script( 
            'customizer-customizer-extras', 
            'customizerExtrasObject', [
                '_wpnonce'	=> wp_create_nonce( 'blogistic-customizer-controls-nonce' ),
                'ajaxUrl' => esc_url( admin_url('admin-ajax.php') ),
                'custom'    =>  [
                    'blog_single_section_panel'   =>  $nexus_collective( 'post' ),
                    'page_settings_section'   =>  $nexus_collective( 'page' ),
                    'archive_general_section'   =>  home_url(),
                    'category_archive_section'  =>  $nexus_collective( 'category' ),
                    'tag_archive_section'  =>  $nexus_collective( 'tag' ),
                    'author_archive_section'  =>  $nexus_collective( 'author' ),
                    'error_page_settings_section'   =>  home_url() . '/~~~hfieojfw',
                    'search_page_settings'  =>  home_url() . '?s=a',
                ],
                'custom_callback'   =>  [
                    'footer_widget_column'  =>  [
                        'column-one'    =>  [ 'footer_widgets_redirects' ],
                        'column-two'    =>  [ 'footer_widgets_redirects', 'footer_widgets_redirects_two' ],
                        'column-three'    =>  [ 'footer_widgets_redirects', 'footer_widgets_redirects_two', 'footer_widgets_redirects_three' ],
                        'column-four'    =>  [ 'footer_widgets_redirects', 'footer_widgets_redirects_two', 'footer_widgets_redirects_three', 'footer_widgets_redirects_four' ]
                    ],
                    'archive_pagination_type'   =>  [
                        'number'    =>  [ 'pagination_text_color' ],
                    ]
                ]
            ]
        );
    }
    add_action( 'customize_controls_enqueue_scripts', 'blogistic_customizer_custom_callback' );
endif;