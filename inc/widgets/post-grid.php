<?php
/**
 * Post Grid widget
 * 
 * @since 1.0.0
 * @package Blogistic
 */

 class Blogistic_Post_Grid_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'blogistic_post_grid_widget',
            esc_html__( 'Blogistic: Post Grid', 'blogistic' ),
            [ 'description' => __( 'A collection of post in a grid', 'blogistic' ) ]
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $widget_title = ( isset( $instance['widget_title'] ) ) ? $instance['widget_title'] : '';
        $number_of_posts_to_show = ( isset( $instance['number_of_posts_to_show'] ) ) ? $instance['number_of_posts_to_show'] : '';
        $posts_categories = ( isset( $instance['post_catgories'] ) ) ? $instance['post_catgories'] : '';
        $post_tags = ( isset( $instance['post_tags'] ) ) ? $instance['post_tags'] : '';
        $post_authors = ( isset( $instance['post_authors'] ) ) ? $instance['post_authors'] : '';
        $post_to_include = ( isset( $instance['post_to_include'] ) ) ? $instance['post_to_include'] : '';
        $post_to_exclude = ( isset( $instance['post_to_exclude'] ) ) ? $instance['post_to_exclude'] : '';
        $image_size = ( isset( $instance['image_size'] ) ) ? $instance['image_size'] : '';
        $image_ratio = ( isset( $instance['image_ratio'] ) ) ? $instance['image_ratio'] : json_encode([ 'desktop' => 0.55, 'tablet' => 0.55, 'smartphone' => 0.55 ]);
        $ajax_load_more_option = ( isset( $instance['ajax_load_more_option'] ) ) ? $instance['ajax_load_more_option'] : '';
        $post_grid_query_args = [
            'post_type' =>  'post',
            'post_status'   =>  'publish',
            'posts_per_page'    =>  absint( $number_of_posts_to_show ),
            'ignore_sticky_posts'   =>  true
        ];
        if( isset( $posts_categories ) ) $post_grid_query_args['cat'] = $posts_categories;
        if( ! empty( $post_authors ) ) $post_grid_query_args['author'] = $post_authors;
        if( ! empty( $post_tags ) ) $post_grid_query_args['tag__in'] = explode( ',', $post_tags );
        if( ! empty( $post_to_include ) ) $post_grid_query_args['post__in'] = explode( ',', $post_to_include );
        if( ! empty( $post_to_exclude ) ) $post_grid_query_args['post__not_in'] = explode( ',', $post_to_exclude );

        echo wp_kses_post( $before_widget );
            if( isset( $widget_id ) ) :
                echo '<style id="'. esc_attr( $widget_id ) .'">';
                    $image_ratio = json_decode( $image_ratio );
                    echo "#". $widget_id ." .post-grid-wrap .post-thumb-image { padding-bottom: calc( ". $image_ratio->desktop ." * 100% ) }\n";
                    echo "@media (max-width: 994px){ #". $widget_id ." .tags-wrap .tags-item.post-thumb { padding-bottom: calc( ". $image_ratio->tablet ." * 100% ) } }\n";
                    echo "@media (max-width: 610px){ #". $widget_id ." .tags-wrap .tags-item.post-thumb { padding-bottom: calc( ". $image_ratio->smartphone ." * 100% ) } }\n";

                echo '</style>';
            endif;
            if( ! empty( $widget_title ) ) echo $before_title . $widget_title . $after_title;
            $post_grid_query = new \WP_Query( apply_filters( 'blogistic_query_args_filter', $post_grid_query_args ) );
            if( $post_grid_query->have_posts() ) :
                $elementClass = 'post-grid-wrap';
                $elementClass .= ( $ajax_load_more_option && $post_grid_query->max_num_pages > 1 ) ? ' load-more--active' : ' load-more--inactive';
                ?>
                    <div class="<?php echo esc_attr( $elementClass ); ?>">
                        <?php
                            while( $post_grid_query->have_posts() ) :
                                $post_grid_query->the_post();
                                ?>
                                    <div class="post-item format-standard">
                                        <div class="post-thumb-image<?php if( ! has_post_thumbnail() ) echo ' no-feat-img'?>">
                                            <figure class="post-thumb">
                                                <?php if( has_post_thumbnail() ) the_post_thumbnail( $image_size ); ?>
                                            </figure>
                                            <?php echo blogistic_get_post_categories( get_the_ID() ); ?>
                                        </div>
                                        <div class="post-content-wrap">
                                            <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <?php 
                                                echo '<div class="post-meta">';
                                                    blogistic_posted_on();
                                                echo '</div>';
                                            ?>
                                        </div>
                                    </div>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        ?>
                    </div>
                <?php
                if( $ajax_load_more_option && $post_grid_query->max_num_pages > 1 ) :
                    ?>
                    <div class="blogistic-widget-loader">
                            <button class="load-more" data-widget="blogistic_post_grid_widget" data-instance="<?php echo esc_attr( json_encode( $instance ) ); ?>"><?php echo esc_html__( 'Show more', 'blogistic' ); ?></button>
                        </div>
                    <?php
                endif;
            endif;
        echo wp_kses_post( $after_widget );
    }

    public function widget_fields() {
        // for category
        $post_categories_args = get_categories();
        foreach( $post_categories_args as $category ) :
            $category_list[$category->term_id] = $category->name .'('. $category->count .')';
        endforeach;
        $category_list['type'] = 'category';

        // for tag
        $post_tags_args = get_tags();
        foreach( $post_tags_args as $tag ) :
            $tag_list[$tag->term_id] = $tag->name .'('. $tag->count .')';
        endforeach;
        $tag_list['type'] = 'tag';

        // for user
        $post_authors_args = new \WP_User_Query( [ 'number' => -1 ] );
        if( ! empty( $post_authors_args->get_results() ) ) :
            foreach( $post_authors_args->get_results() as $user ) :
                $user_list[$user->ID] = $user->display_name;
            endforeach;
        endif;
        $user_list['type'] = 'user';

        // for posts
        $post_args = [
            'post_type' =>  'post',
            'post_status'=>  'publish',
            'posts_per_page'    =>  -1
        ];
        $posts_query = new \WP_Query( apply_filters( 'blogistic_query_args_filter', $post_args ) );
        if( $posts_query->have_posts() ) :
            while( $posts_query->have_posts() ) :
                $posts_query->the_post();
                $post_list[ get_the_ID() ] = get_the_title();
            endwhile;
        endif;
        $post_list['type'] = 'post';
        wp_reset_postdata();
        return [
            [
                'name'  =>  'widget_title',
                'type'  =>  'text',
                'title' =>  esc_html( 'Widget Title', 'blogistic' ),
                'description'   =>  esc_html__( 'Add the widget title here', 'blogistic' ),
                'default'   =>  esc_html__( 'Post Grid', 'blogistic' )
            ],
            [
                'name'  =>  'post_catgories',
                'type'  =>  'select-two',
                'title' =>  esc_html__( 'Post Categories', 'blogistic' ),
                'description'   =>  esc_html__( 'Choose the category to display list of posts', 'blogistic' ),
                'options'   =>  $category_list
            ],
            [
                'name'  =>  'post_tags',
                'type'  =>  'select-two',
                'title' =>  esc_html__( 'Post Tags', 'blogistic' ),
                'description'   =>  esc_html__( 'Choose the tag to display list of posts', 'blogistic' ),
                'options'   =>  $tag_list
            ],
            [
                'name'  =>  'post_authors',
                'type'  =>  'select-two',
                'title' =>  esc_html__( 'Post Authors', 'blogistic' ),
                'description'   =>  esc_html__( 'Choose the author to display list author posts', 'blogistic' ),
                'options'   =>  $user_list
            ],
            [
                'name'  =>  'post_to_include',
                'type'  =>  'select-two',
                'title' =>  esc_html__( 'Post to Include', 'blogistic' ),
                'description'   =>  esc_html__( 'Choose the posts to display in the list of posts', 'blogistic' ),
                'options'   =>  $post_list
            ],
            [
                'name'  =>  'post_to_exclude',
                'type'  =>  'select-two',
                'title' =>  esc_html__( 'Post to Exclude', 'blogistic' ),
                'description'   =>  esc_html__( 'Choose the posts to exclude from list of posts', 'blogistic' ),
                'options'   =>  $post_list
            ],
            [
                'name'  =>  'number_of_posts_to_show',
                'title' =>  esc_html__( 'Number of posts to show', 'blogistic' ),
                'type'  =>  'number',
                'default'   =>  4,
                'min'   => 1,
                'max'   =>  4,
                'step'  =>  1
            ],
            [
                'name'  =>  'image_settings_heading',
                'type'  =>  'heading',
                'label' =>  esc_html__( 'Image Settings', 'blogistic' )
            ],
            [
                'name'  =>  'image_size',
                'type'  =>  'select',
                'title' =>  esc_html__( 'Image Size', 'blogistic' ),
                'options'   =>  blogistic_get_image_sizes_option_array(),
                'default'   =>  'medium'
            ],
            [
                'name'  =>  'image_ratio',
                'type'  =>  'responsive-number',
                'title' =>  esc_html__( 'Image Ratio', 'blogistic' ),
                'min'   =>  0,
                'max'   =>  2,
                'step'  =>  0.1,
                'default'   =>  json_encode([
                    'desktop'    =>  0.55,
                    'tablet'    =>  0.55,
                    'smartphone'    =>  0.55
                ])
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