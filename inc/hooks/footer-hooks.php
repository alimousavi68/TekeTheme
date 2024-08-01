<?php
/**
 * Footer hooks and functions
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;
if( ! function_exists( 'blogistic_footer_widgets_area_part' ) ) :
   /**
    * Footer widgets area
    * 
    * @since 1.0.0
    */
   function blogistic_footer_widgets_area_part() {
        $footer_widget_column = BIT\blogistic_get_customizer_option( 'footer_widget_column' );
    ?>
            <div class="footer-widget <?php echo esc_attr( $footer_widget_column ); ?>">
                <?php dynamic_sidebar( 'footer-sidebar-column-1' ); ?>
            </div>
        <?php
            if( $footer_widget_column !== 'column-one' ) {
            ?>
                <div class="footer-widget <?php echo esc_attr( $footer_widget_column ); ?>">
                    <?php dynamic_sidebar( 'footer-sidebar-column-2' ); ?>
                </div>
        <?php
            }

            if( $footer_widget_column === 'column-four' || $footer_widget_column === 'column-three' ) {
            ?>
                <div class="footer-widget <?php echo esc_attr( $footer_widget_column ); ?>">
                    <?php dynamic_sidebar( 'footer-sidebar-column-3' ); ?>
                </div>
        <?php
            }

            if( $footer_widget_column === 'column-four' ) {
                ?>
                    <div class="footer-widget <?php echo esc_attr( $footer_widget_column ); ?>">
                        <?php dynamic_sidebar( 'footer-sidebar-column-4' ); ?>
                    </div>
        <?php
            }
   }
   add_action( 'blogistic_footer_hook', 'blogistic_footer_widgets_area_part', 10 );
endif;

if( ! function_exists( 'blogistic_bottom_footer_logo_part' ) ) :
    /**
     * Bottom Footer logo element
     * 
     * @since 1.0.0
     */
    function blogistic_bottom_footer_logo_part() {
        if( ! BIT\blogistic_get_customizer_option( 'bottom_footer_show_logo' ) ) return;
        $logo_from = BIT\blogistic_get_customizer_option( 'bottom_footer_header_or_custom' );
        if( $logo_from == 'header' ) :
            $footer_logo = get_theme_mod( 'custom_logo' );
        else:
            $footer_logo = BIT\blogistic_get_customizer_option( 'bottom_footer_logo_option' );
        endif;
        ?>
            <div class="footer-logo">
                <?php echo wp_get_attachment_image( $footer_logo, 'full' ); ?>     
            </div>
        <?php
    }
    add_action( 'blogistic_botttom_footer_hook', 'blogistic_bottom_footer_logo_part', 19 );
endif;

if( ! function_exists( 'blogistic_bottom_footer_social_icons' ) ) :
   /**
    * Bottom Footer copyright element
    * 
    * @since 1.0.0
    */
    function blogistic_bottom_footer_social_icons() {
        require get_template_directory() . '/inc/hooks/top-header-hooks.php'; // footer hooks.
        if( ! BIT\blogistic_get_customizer_option( 'bottom_footer_show_social_icons' ) ) return;
        blogistic_top_header_social_part();
    }
   add_action( 'blogistic_botttom_footer_hook', 'blogistic_bottom_footer_social_icons', 19 );
endif;

if( ! function_exists( 'blogistic_bottom_footer_copyright_part' ) ) :
   /**
    * Bottom Footer copyright element
    * 
    * @since 1.0.0
    */
    function blogistic_bottom_footer_copyright_part() {
      $bottom_footer_site_info = BIT\blogistic_get_customizer_option( 'bottom_footer_site_info' );
      if( ! $bottom_footer_site_info ) return;
     ?>
        <div class="site-info">
            <?php echo wp_kses_post( str_replace( '%year%', date('Y'), $bottom_footer_site_info ) ); ?>
        </div>
     <?php
   }
   add_action( 'blogistic_botttom_footer_hook', 'blogistic_bottom_footer_copyright_part', 20 );
endif;

if( ! function_exists( 'blogistic_bottom_footer_inner_wrapper_open' ) ) :
   /**
    * Bottom Footer inner wrapper open
    * 
    * @since 1.0.0
    */
   function blogistic_bottom_footer_inner_wrapper_open() {
      ?>
         <div class="bottom-inner-wrapper">
      <?php
   }
   add_action( 'blogistic_botttom_footer_hook', 'blogistic_bottom_footer_inner_wrapper_open', 15 );
endif;

if( ! function_exists( 'blogistic_bottom_footer_inner_wrapper_close' ) ) :
   /**
    * Bottom Footer inner wrapper close
    * 
    * @since 1.0.0
    */
   function blogistic_bottom_footer_inner_wrapper_close() {
      ?>
         </div><!-- .bottom-inner-wrapper -->
      <?php
   }
   add_action( 'blogistic_botttom_footer_hook', 'blogistic_bottom_footer_inner_wrapper_close', 40 );
endif;

if( ! function_exists( 'blogistic_you_may_have_missed_html' ) ) :
    /**
     * You May Have Missed Section html
     * 
     * @since 1.0.0
     */
    function blogistic_you_may_have_missed_html() {
        if( ! BIT\blogistic_get_customizer_option( 'you_may_have_missed_section_option' ) || is_paged() ) return;
        // post query
        $you_may_have_missed_post_categories = BIT\blogistic_get_customizer_option( 'you_may_have_missed_categories' );
        $you_may_have_missed_posts_to_include = BIT\blogistic_get_customizer_option( 'you_may_have_missed_posts_to_include' );
        $you_may_have_missed_post_order = BIT\blogistic_get_customizer_option( 'you_may_have_missed_post_order' );
        $you_may_have_missed_no_of_posts_to_show = BIT\blogistic_get_customizer_option( 'you_may_have_missed_no_of_posts_to_show' );
        $hide_posts_with_no_featured_image = BIT\blogistic_get_customizer_option( 'you_may_have_missed_hide_post_with_no_featured_image' );
        $post_categories_id_args = ( ! empty( $you_may_have_missed_post_categories ) ) ? implode( ",", array_column( json_decode( $you_may_have_missed_post_categories ), 'value' ) ) : '';
        $post_to_include_id_args = ( ! empty( $you_may_have_missed_posts_to_include ) ) ? array_column( json_decode( $you_may_have_missed_posts_to_include ), 'value' ) : '';

        // post elements
        $show_title = BIT\blogistic_get_customizer_option( 'you_may_have_missed_post_elements_show_title' );
        $show_categories = BIT\blogistic_get_customizer_option( 'you_may_have_missed_post_elements_show_categories' );
        $show_date = BIT\blogistic_get_customizer_option( 'you_may_have_missed_post_elements_show_date' );
        $show_author = BIT\blogistic_get_customizer_option( 'you_may_have_missed_post_elements_show_author' );
        // image settings and slider settings
        $you_may_have_missed_image_sizes = BIT\blogistic_get_customizer_option( 'you_may_have_missed_image_sizes' );

        // element class
        $elementClass = 'blogistic-you-may-have-missed-section no-of-columns--four';
        $you_may_have_missed_aligment = BIT\blogistic_get_customizer_option( 'you_may_have_missed_post_elements_alignment' );
        $elementClass .= ' you-may-have-missed-align--'.$you_may_have_missed_aligment;
        ?>
            <section class="<?php echo esc_attr( $elementClass ); ?>" id="blogistic-you-may-have-missed-section">
                <div class="blogistic-container">
                    <div class="row">
                        <div class="blogistic-you-may-missed-inner-wrap">
                            <?php
                                $you_may_have_missed_title_option = BIT\blogistic_get_customizer_option( 'you_may_have_missed_title_option' );
                                if( $you_may_have_missed_title_option ) :
                                    $you_may_have_missed_title = BIT\blogistic_get_customizer_option( 'you_may_have_missed_title' );
                                    ?>
                                        <div class="section-title"><?php echo esc_html( $you_may_have_missed_title ); ?></div>
                                    <?php
                                endif;
                            ?>
                            <div class="you-may-have-missed-wrap">
                                <?php
                                    $post_order = explode( '-', $you_may_have_missed_post_order );
                                    $post_query_args = [
                                        'post_type' =>  'post',
                                        'post_status'  =>  'publish',
                                        'posts_per_page'    =>  absint( $you_may_have_missed_no_of_posts_to_show ),
                                        'order' =>  $post_order[1],
                                        'order_by'  =>  $post_order[1],
                                        'ignore_sticky_posts'   =>  true
                                    ];
                                    if( isset( $you_may_have_missed_post_categories ) ) $post_query_args['cat'] = $post_categories_id_args;
                                    if( isset( $you_may_have_missed_posts_to_include ) ) $post_query_args['post__in'] = $post_to_include_id_args;
                                    if( $hide_posts_with_no_featured_image ) :
                                        $post_query_args['meta_query'] = [
                                            [
                                                'key'   =>  '_thumbnail_id',
                                                'compare'   =>  'EXISTS'
                                            ]
                                        ];
                                    endif;
                                    $post_query = new \WP_Query( $post_query_args );
                                    if( $post_query->have_posts() ) :
                                        while( $post_query->have_posts() ) :
                                            $post_query->the_post();
                                            ?>
                                                <article class="post-item">
                                                    <figure class="post-thumbnail-wrapper">
                                                        <div class="post-thumnail-inner-wrapper">
                                                            <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                                                                <?php if( has_post_thumbnail() ) the_post_thumbnail( $you_may_have_missed_image_sizes ); ?>
                                                            </a>
                                                        </div>
                                                    <div class="inner-content">
                                                        <div class="content-wrap">
                                                            <div class="blogistic-inner-content-wrap-fi">
                                                                <?php 
                                                                    if( $show_categories ) blogistic_get_post_categories( get_the_ID(), 2 );
                                                                    if( $show_title ) the_title( '<h2 class="entry-title"><a href="'. esc_url( get_the_permalink() ) .'">', '</a></h2>' );
                                                                ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="post-footer">
                                                            <?php
                                                                if( $show_author ) blogistic_posted_by( 'you-may-have-missed' );

                                                                if( $show_date ) blogistic_posted_on( get_the_ID(), 'you-may-have-missed' );
                                                            ?>
                                                        </div>
                                                    </div>

                                                    </figure>
                                                </article>
                                            <?php
                                        endwhile;
                                    endif;
                                    wp_reset_postdata();
                                ?>
                            </div>
                        </div> <!-- inner wrap -->
                    </div>
                </div>
            </section>
        <?php
    }
    add_action( 'blogistic_before_footer_hook', 'blogistic_you_may_have_missed_html', 100 );
endif;