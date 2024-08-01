<?php
/**
 * Section Heading Control
 * 
 * @package Blogistic
 * @since 1.0.0
 */

 if( class_exists( 'WP_Customize_Control' ) ) :
    class Blogistic_WP_Section_Heading_Control extends \WP_Customize_Control {
        /**
         * Control Type
         */
        public $type = 'section-heading';
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
            if( $this->tab ) $this->json['tab'] = $this->tab;
        }

        /**
         * Enqueue styles and scripts
         */
        public function enqueue() {
            wp_enqueue_style( 'blogistic-customizer-section-heading', get_template_directory_uri() . '/inc/customizer/custom-controls/section-heading/section-heading.css', [], BLOGISTIC_VERSION, 'all' );
        }

        /**
         * Render the control's content
         */
        public function render_content() {
            ?>
                <div class="customize-section-heading">
                    <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <?php 
                        if( $this->description ) echo '< p class="customize-control-description">'. esc_html( $this->description ) .'</p>';
                    ?>
                </div>
            <?php
        }
    }
 endif;