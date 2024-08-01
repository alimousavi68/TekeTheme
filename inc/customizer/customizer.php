<?php
/**
 * Blogistic Customizer
 *
 * @package Blogistic
 */
use Blogistic\CustomizerDefault as BIT;
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function blogistic_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->default = '000000';
	$wp_customize->get_section( 'background_image' )->title = esc_html__( 'Background', 'blogistic' );
	$wp_customize->get_section( 'header_image' )->panel = 'blogistic_theme_header_panel';
	$wp_customize->get_section( 'background_image' )->priority = 90;
    $wp_customize->remove_control( 'background_color' );

	$wp_customize->register_control_type( 'Blogistic_WP_Radio_Image_Control' );
	$wp_customize->register_control_type( 'Blogistic_WP_Editor_Control' );

	require get_template_directory() . '/inc/customizer/custom-controls/editor-control/editor-control.php'; // editor-control
	require get_template_directory() . '/inc/customizer/custom-controls/radio-image/radio-image.php'; // radio-image
	require get_template_directory() . '/inc/customizer/custom-controls/repeater/repeater.php'; // repeater
	require get_template_directory() . '/inc/customizer/custom-controls/redirect-control/redirect-control.php'; // redirect-control
	require get_template_directory() . '/inc/customizer/custom-controls/section-heading/section-heading.php'; // section-heading
	require get_template_directory() . '/inc/customizer/base.php'; // base
	require get_template_directory() . '/inc/customizer/custom-controls/section-heading-toggle/section-heading-toggle.php'; // section-heading-toggle
	require get_template_directory() . '/inc/customizer/custom-controls/icon-picker/icon-picker.php'; // icon picker

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'blogistic_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'blogistic_customize_partial_blogdescription',
			)
		);

		$wp_customize->selective_refresh->add_partial(
			'blogdescription_option',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'blogistic_customize_partial_blogdescription',
			)
		);

	}

	// preset color picker control
    class Blogistic_WP_Preset_Color_Picker_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'preset-color-picker';
        public $variable = '--blogistic-global-preset-color-1';

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            if( $this->variable ) {
                $this->json['variable'] = $this->variable;
            }
        }
    }

	// preset gradient picker control
    class Blogistic_WP_Preset_Gradient_Picker_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'preset-gradient-picker';
        public $variable = '--blogistic-global-preset-gradient-color-1';

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            if( $this->variable ) {
                $this->json['variable'] = $this->variable;
            }
        }
    }

	// color picker control
    class Blogistic_WP_Color_Picker_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'color-picker';
    }

	//section tab control = renders section tab control
	class Blogistic_WP_Section_Tab_Control extends Blogistic_WP_Base_Control {
		//control type
		public $type = 'section-tab';

		/**
		 * Add custom JSON parameters to use in the JS template
		 * 
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {
			parent::to_json();
			$this->json['choices'] = $this->choices;
		}
	}

	// tab group control
	class Blogistic_WP_Default_Color_Control extends WP_Customize_Color_Control {
		/**
		 * Additional variable
		 */
		public $tab = 'general';

		/**
		 * Add custom JSON parameters to use in the JS template
		 * 
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {
			parent::to_json();
			if( $this->tab && $this->type != 'section-tab' ) :
				$this->json['tab'] = $this->tab;
			endif;
		}
	}

	// Typography Control
	class Blogistic_WP_Typography_Control extends Blogistic_WP_Base_Control {
		//control type
		public $type = 'typography';
		public $fields;

		/**
		 * Add custom JSON parameters to use in the JS template
		 * 
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function to_json(){
			parent::to_json();
			$this->json['fields'] = $this->fields;
		}
	}

	// Toggle Control
	class Blogistic_WP_Toggle_Control extends Blogistic_WP_Base_Control {
		//conrol type
		public $type = 'toggle-button';
	}

	 // simple toggle control 
	 class Blogistic_WP_Simple_Toggle_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'simple-toggle';
    }
	
	// multiselect control
    class Blogistic_WP_Categories_Multiselect_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'categories-multiselect';
		
        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            $this->json['choices'] = $this->choices;
        }
    }

	// posts multiselect control
    class Blogistic_WP_Posts_Multiselect_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'posts-multiselect';

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            $this->json['choices'] = $this->choices;
        }
    }

	// color image group control
    class Blogistic_WP_Color_Image_Group_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'color-image-group';
    }

	// Color group picker control - renders color and hover color control
    class Blogistic_WP_Color_Group_Picker_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'color-group-picker';
    }

	// Color group picker control - renders color and hover color control
    class Blogistic_WP_Background_Color_Group_Picker_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'background-color-group-picker';
    }

	class Blogistic_WP_Spacing_Control extends Blogistic_WP_Base_Control {
		/**
		 * List of controls for this theme
		* 
		* @since 1.0.0
		*/
		protected $type_array = [];
		public $type = 'spacing';
		public $tab = 'general';

		/**
		 * Add custom JSON parameters to use in the JS template.
		* 
		* @since 1.0.0
		* @access public
		* @return void
		*/
		public function to_json() {
			parent::to_json();
			if( $this->tab && $this->type != 'section-tab' ) $this->json['tab'] = $this->tab;
			if( $this->input_attrs ) $this->json['input_attrs'] = $this->input_attrs;
		}
	}

	// Color Group Control
	class Blogistic_WP_Color_Group_Control extends Blogistic_WP_Base_Control {
		public $type = 'color-group';
	}

	// Radio Tab Control
	class Blogistic_WP_Radio_Tab_Control extends Blogistic_WP_Base_Control {
		// control type
		public $type = 'radio-tab';

		/**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            $this->json['choices'] = $this->choices;
        }
	}

	// info box control
    class Blogistic_WP_Info_Box_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'info-box';
        
        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            $this->json['choices'] = $this->choices;
        }
    }

	// Border Control
	class Blogistic_WP_Border_Control extends Blogistic_WP_Base_Control {
		// control type
		public $type = 'border';
		
	}

	// Box Shadow Control
	class Blogistic_WP_Box_Shadow_Control extends Blogistic_WP_Base_Control {
		// control type
		public $type = 'box-shadow';
	}

    // item sortable control 
    class Blogistic_WP_Item_Sortable_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'item-sortable';
        public $fields;

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            $this->json['fields'] = $this->fields;
        }
    }

    // number control
    class Blogistic_WP_Number_Control extends Blogistic_WP_Base_Control {
        // control type
        public $type = 'number';
        public $fields;
        public $responsive = false;
		public $tab = 'general';

        /**
         * Add custom JSON parameters to use in the JS template.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function to_json() {
            parent::to_json();
            $this->json['fields'] = $this->fields;
            $this->json['responsive'] = $this->responsive;
            $this->json['input_attrs'] = $this->input_attrs;
        }
    }

	// site background color
    $wp_customize->add_setting( 'site_background_color', array(
        'default'   => BIT\blogistic_get_customizer_default( 'site_background_color' ),
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 
        new Blogistic_WP_Color_Group_Control( $wp_customize, 'site_background_color', array(
            'label'	      => esc_html__( 'Background Color', 'blogistic' ),
            'section'     => 'background_image',
            'settings'    => 'site_background_color',
            'priority'  => 1
        ))
    );

	// site background color
    $wp_customize->add_setting( 'site_background_animation', array(
        'default'   => BIT\blogistic_get_customizer_default( 'site_background_animation' ),
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control( 'site_background_animation', array(
		'label'	      => esc_html__( 'Background animation', 'blogistic' ),
		'section'     => 'background_image',
		'settings'    => 'site_background_animation',
		'type'	=>	'select',
		'choices'	=>	[
			'none'	=>	esc_html__( 'None', 'blogistic' ),
			'three'	=>	esc_html__( 'Animation 1', 'blogistic' )
		],
		'priority'  => 1
	));
}
add_action( 'customize_register', 'blogistic_customize_register' );

add_filter( BLOGISTIC_PREFIX . 'unique_identifier', function($identifier) {
    $bc_delimeter = '-';
    $bc_prefix = 'customize';
    $bc_sufix = 'control';
    $identifier_id = [$bc_prefix,$identifier,$bc_sufix];
    return implode($bc_delimeter,$identifier_id);
});

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blogistic_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blogistic_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blogistic_customize_preview_js() {
	wp_enqueue_script( 'blogistic-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), BLOGISTIC_VERSION, true );
}
add_action( 'customize_preview_init', 'blogistic_customize_preview_js' );

// Get list of image sizes
function blogistic_get_image_sizes_option_array_for_customizer() {
	$sizes_lists = [];
	$images_sizes = get_intermediate_image_sizes();
	if( $images_sizes ) {
		foreach( $images_sizes as $size ) {
			$sizes_lists[$size] = $size;
		}
	}
	return $sizes_lists;
}

require get_template_directory() . '/inc/customizer/handlers.php';
require get_template_directory() . '/inc/customizer/customizer-up.php'; // customizer up
require get_template_directory() . '/inc/customizer/sanitize-functions.php';