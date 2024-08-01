<?php
/**
 * Top Header hooks and functions
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;

if( ! function_exists( 'blogistic_top_header_date_time_part' ) ) :
    /**
     * Top header menu element
     * 
    * @since 1.0.0
    */
    function blogistic_top_header_date_time_part() {
        $elementClass = 'top-date-time';
        ?>
            <div class="<?php echo esc_attr( $elementClass ); ?>">
                <?php if( BIT\blogistic_get_customizer_option( 'top_header_date_time_option' ) ) : ?>
                    <span class="top-date-time-inner">
                        <span class="time"></span>
                        <span class="date"><?php echo date_i18n( get_option( 'date_format' ), current_time( 'timestamp' )); ?></span>
                    </span>
                <?php endif; ?>
            </div>
        <?php
    }
    add_action( 'blogistic_top_header_hook', 'blogistic_top_header_date_time_part', 10 );
endif;

if( ! function_exists( 'blogistic_top_header_inner_wrapper_open' ) ) :
    /**
     * Top header inner wrapper open
     * 
     * @since 1.0.0
     */
    function blogistic_top_header_inner_wrapper_open() {
       ?>
          <div class="top-header-inner-wrapper">
       <?php
    }
    add_action( 'blogistic_top_header_hook', 'blogistic_top_header_inner_wrapper_open', 15 );
 endif;

if( ! function_exists( 'blogistic_top_header_social_part' ) ) :
    /**
     * Top header social element
     * 
     * @since 1.0.0
     */
    function blogistic_top_header_social_part() {
        if( ! BIT\blogistic_get_customizer_option( 'top_header_social_option' ) ) return;
        $elementClass = 'social-icons-wrap';
        ?>
            <div class="<?php echo esc_attr( $elementClass ); ?>">
                <?php blogistic_customizer_social_icons(); ?>
            </div>
        <?php
    }
    add_action( 'blogistic_top_header_hook', 'blogistic_top_header_social_part', 15 );
endif;

if( ! function_exists( 'blogistic_top_header_search_icon' ) ) :
    /**
     * Top header search element
     * 
     * @since 1.0.0
     */
    function blogistic_top_header_search_icon() {
        if( ! BIT\blogistic_get_customizer_option( 'top_header_show_search' ) ) return;
        $elementClass = 'top-header-search-wrap';
        ?>
            <div class="<?php echo esc_attr( $elementClass ); ?>">
                <?php get_search_form(); ?>
            </div>
        <?php
    }
    add_action( 'blogistic_top_header_hook', 'blogistic_top_header_search_icon', 15 );
 endif;

 if( ! function_exists( 'blogistic_top_header_inner_wrapper_close' ) ) :
    /**
     * Top header inner wrapper close
     * 
     * @since 1.0.0
     */
    function blogistic_top_header_inner_wrapper_close() {
       ?>
          </div><!-- .top--header-inner-wrapper -->
       <?php
    }
    add_action( 'blogistic_top_header_hook', 'blogistic_top_header_inner_wrapper_close', 15 );
 endif;