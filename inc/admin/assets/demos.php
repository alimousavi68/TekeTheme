<?php
/**
 * List of demos json
 *
 * @package Blogistic
 * @since 1.0.0
 */
$demos_array = array(
    'blogistic-free-one' => [
        'name' => 'Default',
        'type' => 'free',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-free-one.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/free-one.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-free-one/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'free'  =>  esc_html__( 'Free', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-free-two' => [
        'name' => 'Two',
        'type' => 'free',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-free-two.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/free-two.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-free-two/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'free'  =>  esc_html__( 'Free', 'blogistic' ),
            'pets'  =>  esc_html__( 'Pets', 'blogistic' )
        ]
    ],
    'blogistic-free-three' => [
        'name' => 'Three',
        'type' => 'free',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-free-three.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/free-three.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-free-three/',
        'menu_array' => [
            'menu-1' => 'Menu 1'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'free'  =>  esc_html__( 'Free', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-elementor-one' => [
        'name' => 'Elementor One',
        'type' => 'free',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-elementor-one.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/06/free-one-elementor.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-elementor-one/',
        'menu_array' => [],
        'home_slug' => 'blogistic-elementor-free-home-one',
        'blog_slug' => '',
        'plugins' => [
            'elementor' => array(
                'name' => 'Elementor',
                'source' => 'wordpress',
                'required' => true,
                'file_path' => 'elementor/elementor.php'
            ),
            'news-kit-elementor-addons' => array(
                'name' => 'News Kit Elementor Addons',
                'source' => 'wordpress',
                'required' => true,
                'file_path' => 'news-kit-elementor-addons/news-kit-elementor-addons.php'
            )
        ],
        'pagebuilder' => array(
            'elementor' => 'Elementor'
        ),
        'tags' => [
            'free'  =>  esc_html__( 'Free', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' ),
            'elementor'  =>  esc_html__( 'Elementor', 'blogistic' )
        ]
    ],
    'blogistic-pro-one' => [
        'name' => 'Default',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-one.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-one.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-one/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-pro-two' => [
        'name' => 'Two',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-two.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-two.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-two/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-pro-three' => [
        'name' => 'Three',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-three.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-three.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-three/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' ),
            'food'  =>  esc_html__( 'Food', 'blogistic' )
        ]
    ],
    'blogistic-pro-four' => [
        'name' => 'Four',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-four.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-four.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-four/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' ),
            'gadgets'  =>  esc_html__( 'Gadgets', 'blogistic' )
        ]
    ],
    'blogistic-pro-five' => [
        'name' => 'Five',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-five.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-five.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-five/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-pro-six' => [
        'name' => 'Six',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-six.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-six.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-six/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-pro-seven' => [
        'name' => 'Seven',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-seven.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/05/pro-seven.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-seven/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'  =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' )
        ]
    ],
    'blogistic-pro-eight' => [
        'name' => 'RTL',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-pro-eight.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/06/pro-eight.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-pro-eight/',
        'menu_array' => [
            'menu-1' => 'Header Menu'
        ],
        'home_slug' => '',
        'blog_slug' => '',
        'plugins' => [],
        'tags' => [
            'pro'   =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' ),
            'rtl'   =>  esc_html__( 'RTL', 'blogistic' )
        ]
    ],
    'blogistic-elementor-pro-one' => [
        'name' => 'Elementor',
        'type' => 'pro',
        'buy_url'=> 'https://blazethemes.com/theme/blogistic-pro/',
        'external_url' => 'https://preview.blazethemes.com/import-files/blogistic/blogistic-elementor-pro-one.zip',
        'image' => 'https://blazethemes.com/wp-content/uploads/2024/06/pro-one-elementor.jpg',
        'preview_url' => 'https://preview.blazethemes.com/blogistic-elementor-pro-one/',
        'menu_array' => [],
        'home_slug' => 'blogistic-elementor-pro-home-one',
        'blog_slug' => '',
        'plugins' => [
            'elementor' => array(
                'name' => 'Elementor',
                'source' => 'wordpress',
                'file_path' => 'elementor/elementor.php'
            ),
            'news-kit-elementor-addons' => array(
                'name' => 'News Kit Elementor Addons',
                'source' => 'wordpress',
                'file_path' => 'news-kit-elementor-addons/news-kit-elementor-addons.php'
            )
        ],
        'pagebuilder' => array(
            'elementor' => 'Elementor'
        ),
        'tags' => [
            'pro'   =>  esc_html__( 'Pro', 'blogistic' ),
            'blog'  =>  esc_html__( 'Blog', 'blogistic' ),
            'elementor'  =>  esc_html__( 'Elementor', 'blogistic' )
        ]
    ]
);
return apply_filters( 'blogistic__demos_array_filter', $demos_array );