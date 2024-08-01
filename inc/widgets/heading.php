<?php
/**
 * Blogistic heading widget
 * 
 * @since 1.0.0
 * @package Blogistic
 */

 class Blgocast_WP_Heading_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'blogistic_heading_widget',
            esc_html( 'Blogistic: Heading', 'blogistic' ),
            [ 'description' =>  __( 'Heading for a section.', 'blogistic' ) ]
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $heading = isset( $instance['heading'] ) ? $instance['heading'] : '';
        $layouts = isset( $instance['layouts'] ) ? $instance['layouts'] : 'one';
        $elementClass = 'blogistic-heading';
        $elementClass .= ' widget-layout--' . $layouts;
        echo wp_kses_post( $before_widget );
            echo '<div class="'. esc_attr( $elementClass ) .'">';
                if( ! empty( $heading ) ) echo wp_kses_post( $before_title ) . esc_html( $heading ) . wp_kses_post( $after_title );
            echo '</div>';
        echo wp_kses_post( $after_widget );
    }

    public function widget_fields() {
        return [
            [
                'title' =>  esc_html__( 'Heading', 'blogistic' ),
                'default'   =>  esc_html__( 'Heading', 'blogistic' ),
                'name'  =>  'heading',
                'type'  =>  'text'
            ]
        ];
    }

    public function form( $instance ) {
        $widget_fields = $this->widget_fields();
        foreach( $widget_fields as $widget_field ) :
            if ( isset( $instance[ $widget_field['name'] ] ) ) {
                $field_value = $instance[ $widget_field['name'] ];
            } else if( isset( $widget_field['default'] ) ) {
                $field_value = $widget_field['default'];
            } else {
                $field_value = '';
            }
            blogistic_widget_fields( $this, $widget_field, $field_value );
        endforeach;
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $widget_fields = $this->widget_fields();
        if( ! is_array( $widget_fields ) ) return $instance;
        foreach( $widget_fields as $widget_field ) :
            $instance[ $widget_field['name'] ] = blogistic_sanitize_widget_fields( $widget_field, $new_instance );
        endforeach;
        return $instance;
    }
 }