<?php
/**
 * Frontpage section hooks and function for the theme
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;
 
 if( ! function_exists( 'blogistic_article_masonry' ) ) :
    /**
     * Masonry articles element
     * 
     * @package Blogistic
     * @since 1.0.0
     */
    function blogistic_article_masonry() {
        $query_args = [
            'post_type' =>  'post',
            'post_status'   =>  'publish'
        ];
        $post_query = new \WP_Query( apply_filters( 'blogistic_query_args_filter', $query_args ) );
        if( $post_query->have_posts() ) :
            while( $post_query->have_posts() ) :
                $post_query->the_post();
            endwhile;
        endif;
    }
    add_action( 'blogistic_masonry_articles_hook', 'blogistic_article_masonry' );
 endif;
