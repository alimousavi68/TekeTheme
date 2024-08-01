<?php
/**
 * Adds post meta and title in single
 * 
 * @since 1.0.0
 * @package Blogistic
*/

use Blogistic\CustomizerDefault as BIT;
$single_category_option = BIT\blogistic_get_customizer_option( 'single_category_option' );
$single_post_layout = BIT\blogistic_get_customizer_option( 'single_post_layout' );

if( $single_category_option && $single_post_layout != 'layout-one' ) blogistic_get_post_categories( get_the_ID(), 20 );

// title section
if( BIT\blogistic_get_customizer_option( 'single_title_option' ) ) :
    $single_title_tag = BIT\blogistic_get_customizer_option( 'single_title_tag' );
    the_title( '<' .esc_html( $single_title_tag ). ' class="entry-title" ' .blogistic_schema_article_name_attributes(). '>', '</' .esc_html( $single_title_tag ). '>' );
endif;

$single_author_option = BIT\blogistic_get_customizer_option( 'single_author_option' );
$single_date_option = BIT\blogistic_get_customizer_option( 'single_date_option' );
$single_read_time_option = BIT\blogistic_get_customizer_option( 'single_read_time_option' );
$single_comments_option = BIT\blogistic_get_customizer_option( 'single_comments_option' );
if( $single_author_option || $single_date_option || $single_read_time_option || $single_comments_option ) :
    ?>
        <div class="post-meta-wrap">
            <?php 
                if( BIT\blogistic_get_customizer_option( 'single_author_option' ) ) blogistic_posted_by( 'single-layout-two', get_the_ID() ); 
                if( $single_date_option || $single_read_time_option || $single_comments_option ) : ?>
                    <span class="post-meta">
                        <?php
                            if( BIT\blogistic_get_customizer_option( 'single_date_option' ) ) blogistic_posted_on();

                            if( BIT\blogistic_get_customizer_option( 'single_read_time_option' ) ) :
                                $read_time = '<span class="time-context">' . blogistic_post_read_time( get_the_content() ) . '</span>';
                                if( BIT\blogistic_get_customizer_option( 'single_read_time_icon' ) ) {
                                    $single_read_time_icon = BIT\blogistic_get_customizer_option( 'single_read_time_icon' );
                                    $icon_html = blogistic_get_icon_control_html($single_read_time_icon);
                                    if( $icon_html ) $read_time = $icon_html . $read_time;
                                }
                                echo '<span class="post-read-time">' .$read_time. '</span>';
                            endif;

                            if( BIT\blogistic_get_customizer_option( 'single_comments_option' ) ) :
                                $comments_num = '<span class="comments-context">' .get_comments_number( get_the_ID() ). '</span>';
                                if( BIT\blogistic_get_customizer_option( 'single_comments_icon' ) ) {
                                    $single_comments_icon = BIT\blogistic_get_customizer_option( 'single_comments_icon' );
                                    $icon_html = blogistic_get_icon_control_html($single_comments_icon);
                                    if( $icon_html ) $comments_num = $icon_html . $comments_num ;
                                }
                                echo '<a class="post-comments-num" href="'. esc_url(get_the_permalink()) .'#commentform">' .$comments_num. '</a>';
                            endif;
                        ?>
                    </span>
                <?php
                endif;
            ?>
        </div>
    <?php
endif;