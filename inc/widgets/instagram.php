<?php
/**
 * Instagram Widget
 * 
 * @package Blogistic
 * @since 1.0.0
 */

 class Blogistic_Instagram_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'blogistic_instagram_widget',
            esc_html__( 'Blogistic: Instagram', 'blogistic' ),
            [ 'description' => __( 'Showcase your instagram profile', 'blogistic' ) ]
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $widget_title = isset( $instance['widget_title'] ) ? $instance['widget_title'] : '';
        $enable_instagram_slider = isset( $instance['enable_instagram_slider'] ) ? $instance['enable_instagram_slider'] : '';
        echo wp_kses_post( $before_widget );
            if( ! empty( $widget_title ) ) echo $before_title . $widget_title . $after_title;
            ?>
                <div class="instagram-widget">
                    <?php
                        $args = [
                            'widget'    =>  true,
                            'slider_enable' =>  $enable_instagram_slider
                        ];
                        get_template_part( 'template-parts/instagram/instagram', '', $args ); ?>
                </div>
            <?php
        echo wp_kses_post( $after_widget );
    }

    public function widget_fields() {
        return [
            [
                'name'  =>  'widget_title',
                'type'  =>  'text',
                'title' =>  esc_html__( 'Widget Title', 'blogistic' ),
                'description'   =>  esc_html__( 'Add the widget title here', 'blogistic' ),
                'default'   =>  esc_html__( 'Find Me On', 'blogistic' )
            ],
            [
                'name'      => 'slider_settings_heading',
                'type'      => 'heading',
                'label'     => esc_html__( 'Slider Settings', 'blogistic' )
            ],
            [
                'name'      => 'enable_instagram_slider',
                'type'      => 'checkbox',
                'title'     => esc_html__( 'Enable slider', 'blogistic' ),
                'default'   => true
            ]
        ];
    }

    public function form( $instance ) {
        $widget_fields = $this->widget_fields();
        foreach( $widget_fields as $widget_field ) :
            if( isset( $instance[ $widget_field['name'] ] ) ) :
                $field_value = $instance[ $widget_field['name'] ];
            elseif( isset( $widget_field['default'] ) ) :
                $field_value = $widget_field['default'];
            else:
                $field_value = '';
            endif;
            blogistic_widget_fields( $this, $widget_field, $field_value );
        endforeach;
        ?>
            <div class="refer-note">
                <p>
                    <?php echo esc_html__( 'Manage instagram from customizer ', 'blogistic' ); ?>
                    <a href="<?php echo admin_url( 'customize.php?autofocus[control]=instagram_section_tab' ); ?>" target="_blank"><?php echo esc_html__( 'go to manage instagram', 'blogistic' ); ?></a>
                </p>
            </div>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $widget_fields = $this->widget_fields();
        if( ! is_array( $widget_fields ) ) return;
        foreach( $widget_fields as $widget_field ) :
            $instance[ $widget_field['name'] ] = blogistic_sanitize_widget_fields( $widget_field, $new_instance );
        endforeach;
        return $instance;
    }
 }