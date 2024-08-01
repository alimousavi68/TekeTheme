<?php
/**
 * Includes the inline css
 * 
 * @package Blogistic
 * @since 1.0.0
 */
use Blogistic\CustomizerDefault as BIT;

if( ! function_exists( 'blogistic_assign_preset_var' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_assign_preset_var( $selector, $control) {
         $decoded_control =  BIT\blogistic_get_customizer_option( $control );
         if( ! $decoded_control ) return;
         echo " body { " . $selector . ": ".esc_html( $decoded_control ).  ";}\n";
   }
endif;

// Value change single
if( ! function_exists( 'blogistic_value_change' ) ) :
   /**
   * Generate css code for variable change with responsive
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_value_change ( $selector, $control, $property ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      // if( ! $decoded_control ) return;
      echo $selector . "{ ".esc_html( $property ) ." : ".esc_html($decoded_control) .  "px; }";
   }
endif;

// Value change with responsive
if( ! function_exists( 'blogistic_value_change_responsive' ) ) :
   /**
   * Generate css code for variable change with responsive
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_value_change_responsive ( $selector, $control, $property, $unit = 'px' ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      // if( ! $decoded_control ) return;
      if( isset( $decoded_control['desktop'] ) ) :
         $desktop = $decoded_control['desktop'];
            echo $selector . "{ " . esc_html( $property ). ": ".esc_html( $desktop . $unit ) . "; }";
         endif;
         if( isset( $decoded_control['tablet'] ) ) :
            $tablet = $decoded_control['tablet'];
            echo "@media(max-width: 940px) { " .$selector . "{ " . esc_html( $property ). ": ".esc_html( $tablet . $unit ).  "; } }\n";
         endif;
         if( isset( $decoded_control['smartphone'] ) ) :
            $smartphone = $decoded_control['smartphone'];
            echo "@media(max-width: 610px) { " .$selector . "{ " . esc_html( $property ). ": ".esc_html( $smartphone . $unit ).  "; } }\n";
      endif;
   }
endif;

// Value change with responsive percentage
if( ! function_exists( 'blogistic_value_change_responsive_percentage' ) ) :
   /**
   * Generate css code for variable change with responsive
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_value_change_responsive_percentage ( $selector, $control, $property ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['desktop'] ) ) :
         $desktop = $decoded_control['desktop'];
         echo $selector . "{ " . esc_html( $property ). ": ".esc_html( $desktop ).  "%; }";
         endif;
         if( isset( $decoded_control['tablet'] ) ) :
         $tablet = $decoded_control['tablet'];
         echo "@media(max-width: 940px) { " .$selector . "{ " . esc_html( $property ). ": ".esc_html( $tablet ).  "%; } }\n";
         endif;
         if( isset( $decoded_control['smartphone'] ) ) :
         $smartphone = $decoded_control['smartphone'];
         echo "@media(max-width: 610px) { " .$selector . "{ " . esc_html( $property ). ": ".esc_html($smartphone).  "%; } }\n";
      endif;
   }
endif;

// Variable change with responsive
if( ! function_exists( 'blogistic_assign_preset_var_responsive' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_assign_preset_var_responsive( $selector, $control) {
         $decoded_control =  BIT\blogistic_get_customizer_option( $control );
         if( ! $decoded_control ) return;
         echo " body { " . $selector . ": ".esc_html( $decoded_control ).  ";}\n";
   }
endif;

// Typography
if( ! function_exists( 'blogistic_get_typo_style' ) ) :
   /**
   * Generate css code for typography control.
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_get_typo_style( $selector, $control ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['font_family'] ) ) :
         echo ".blogistic_font_typography { ".$selector."-family : " .esc_html( $decoded_control['font_family']['value'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['font_weight'] ) ) :
         echo ".blogistic_font_typography { ".$selector."-weight : " .esc_html( $decoded_control['font_weight']['value'] ).  "; ".$selector."-style : ". esc_html( $decoded_control['font_weight']['variant'] ) ."}\n";
      endif;

      if( isset( $decoded_control['text_transform'] ) ) :
         echo ".blogistic_font_typography { ".$selector."-texttransform : " .esc_html( $decoded_control['text_transform'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['text_decoration'] ) ) :
         echo ".blogistic_font_typography { ".$selector."-textdecoration : " .esc_html( $decoded_control['text_decoration'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['font_size'] ) ) :
         if( isset( $decoded_control['font_size']['desktop'] ) ) echo ".blogistic_font_typography { ".$selector."-size : " .absint( $decoded_control['font_size']['desktop'] ).  "px; }\n";
         if( isset( $decoded_control['font_size']['tablet'] ) ) echo ".blogistic_font_typography { ".$selector."-size-tab : " .absint( $decoded_control['font_size']['tablet'] ).  "px; }\n";
         if( isset( $decoded_control['font_size']['smartphone'] ) ) echo ".blogistic_font_typography { ".$selector."-size-mobile : " .absint( $decoded_control['font_size']['smartphone'] ).  "px; }\n";
      endif;
      if( isset( $decoded_control['line_height'] ) ) :
         if( isset( $decoded_control['line_height']['desktop'] ) ) echo ".blogistic_font_typography { ".$selector."-lineheight : " .absint( $decoded_control['line_height']['desktop'] ).  "px; }\n";
         if( isset( $decoded_control['line_height']['tablet'] ) ) echo ".blogistic_font_typography { ".$selector."-lineheight-tab : " .absint( $decoded_control['line_height']['tablet'] ).  "px; }\n";
         if( isset( $decoded_control['line_height']['smartphone'] ) ) echo ".blogistic_font_typography { ".$selector."-lineheight-mobile : " .absint( $decoded_control['line_height']['smartphone'] ).  "px; }\n";
      endif;
      if( isset( $decoded_control['letter_spacing'] ) ) :
         if( isset( $decoded_control['letter_spacing']['desktop'] ) ) echo ".blogistic_font_typography { ".$selector."-letterspacing : " . $decoded_control['letter_spacing']['desktop'] .  "px; }\n";
         if( isset( $decoded_control['letter_spacing']['tablet'] ) ) echo ".blogistic_font_typography { ".$selector."-letterspacing-tab : " . $decoded_control['letter_spacing']['tablet'] .  "px; }\n";
         if( isset( $decoded_control['letter_spacing']['smartphone'] ) ) echo ".blogistic_font_typography { ".$selector."-letterspacing-mobile : " . $decoded_control['letter_spacing']['smartphone'] .  "px; }\n";
      endif;
   }
endif;

// Typography Value
if( ! function_exists( 'blogistic_get_typo_style_value' ) ) :
   /**
   * Generate css code for typography control.
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_get_typo_style_value( $selector, $control ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['font_family'] ) ) :
         echo ".blogistic_font_typography ".$selector. "{ font-family : " .esc_html( $decoded_control['font_family']['value'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['font_weight'] ) ) :
         echo ".blogistic_font_typography ".$selector."{ font-weight : " .esc_html( $decoded_control['font_weight']['value'] ).  "; font-style : ". esc_html( $decoded_control['font_weight']['variant'] ) ." }\n";
      endif;

      if( isset( $decoded_control['text_transform'] ) ) :
         echo ".blogistic_font_typography ".$selector."{ text-transform : " .esc_html( $decoded_control['text_transform'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['text_decoration'] ) ) :
         echo ".blogistic_font_typography ".$selector."{ text-decoration : " .esc_html( $decoded_control['text_decoration'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['font_size'] ) ) :
         if( isset( $decoded_control['font_size']['desktop'] ) ) echo ".blogistic_font_typography ".$selector." { font-size : " .absint( $decoded_control['font_size']['desktop'] ).  "px; }\n";
         if( isset( $decoded_control['font_size']['tablet'] ) ) echo "@media(max-width: 940px) { .blogistic_font_typography " .$selector . "{ font-size : " .absint( $decoded_control['font_size']['tablet'] ).  "px; } }\n";
         if( isset( $decoded_control['font_size']['smartphone'] ) ) echo "@media(max-width: 610px) { .blogistic_font_typography " .$selector . "{ font-size : " .absint( $decoded_control['font_size']['smartphone'] ).  "px; } }\n";
      endif;

      if( isset( $decoded_control['line_height'] ) ) :
         if( isset( $decoded_control['line_height']['desktop'] ) ) echo ".blogistic_font_typography ".$selector." { line-height : " .absint( $decoded_control['line_height']['desktop'] ).  "px; }\n";
         if( isset( $decoded_control['line_height']['tablet'] ) ) echo "@media(max-width: 940px) { .blogistic_font_typography " .$selector . "{ line-height : " .absint( $decoded_control['line_height']['tablet'] ).  "px; } }\n";
         if( isset( $decoded_control['line_height']['smartphone'] ) ) echo "@media(max-width: 610px) { .blogistic_font_typography " .$selector . "{ line-height : " .absint( $decoded_control['line_height']['smartphone'] ).  "px; } }\n";
      endif;

      if( isset( $decoded_control['letter_spacing'] ) ) :
         if( isset( $decoded_control['letter_spacing']['desktop'] ) ) echo ".blogistic_font_typography ".$selector." { letter-spacing : " .$decoded_control['letter_spacing']['desktop'] .  "px; }\n";
         if( isset( $decoded_control['letter_spacing']['tablet'] ) ) echo "@media(max-width: 940px) { .blogistic_font_typography " .$selector . "{ letter-spacing : " . $decoded_control['letter_spacing']['tablet'] .  "px; } }\n";
         if( isset( $decoded_control['letter_spacing']['smartphone'] ) ) echo "@media(max-width: 610px) { .blogistic_font_typography " .$selector . "{ letter-spacing : " . $decoded_control['letter_spacing']['smartphone'] .  "px; } }\n";
      endif;
   }
endif;

// Typography Value Body
if( ! function_exists( 'blogistic_get_typo_style_body_value' ) ) :
   /**
   * Generate css code for typography control.
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_get_typo_style_body_value( $selector, $control ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['font_family'] ) ) :
         echo $selector. "{ font-family : " .esc_html( $decoded_control['font_family']['value'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['font_weight'] ) ) :
         echo $selector."{ font-weight : " .esc_html( $decoded_control['font_weight']['value'] ).  "; font-style : ". esc_html( $decoded_control['font_weight']['variant'] ) ."}\n";
      endif;

      if( isset( $decoded_control['text_transform'] ) ) :
         echo $selector."{ text-transform : " .esc_html( $decoded_control['text_transform'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['text_decoration'] ) ) :
         echo $selector."{ text-decoration : " .esc_html( $decoded_control['text_decoration'] ).  "; }\n";
      endif;

      if( isset( $decoded_control['font_size'] ) ) :
         if( isset( $decoded_control['font_size']['desktop'] ) ) echo $selector." { font-size : " .absint( $decoded_control['font_size']['desktop'] ).  "px; }\n";
         if( isset( $decoded_control['font_size']['tablet'] ) ) echo "@media(max-width: 940px) { ".$selector . "{ font-size : " .absint( $decoded_control['font_size']['tablet'] ).  "px; } }\n";
         if( isset( $decoded_control['font_size']['smartphone'] ) ) echo "@media(max-width: 610px) { .blogistic_font_typography " .$selector . "{ font-size : " .absint( $decoded_control['font_size']['smartphone'] ).  "px; } }\n";
      endif;

      if( isset( $decoded_control['line_height'] ) ) :
         if( isset( $decoded_control['line_height']['desktop'] ) ) echo $selector." { line-height : " .absint( $decoded_control['line_height']['desktop'] ).  "px; }\n";
         if( isset( $decoded_control['line_height']['tablet'] ) ) echo "@media(max-width: 940px) { " .$selector . "{ line-height : " .absint( $decoded_control['line_height']['tablet'] ).  "px; } }\n";
         if( isset( $decoded_control['line_height']['smartphone'] ) ) echo "@media(max-width: 610px) { " .$selector . "{ line-height : " .absint( $decoded_control['line_height']['smartphone'] ).  "px; } }\n";
      endif;

      if( isset( $decoded_control['letter_spacing'] ) ) :
         if( isset( $decoded_control['letter_spacing']['desktop'] ) ) echo $selector." { letter-spacing : " . $decoded_control['letter_spacing']['desktop'].  "px; }\n";
         if( isset( $decoded_control['letter_spacing']['tablet'] ) ) echo "@media(max-width: 940px) { " .$selector . "{ letter-spacing : " . $decoded_control['letter_spacing']['tablet'] .  "px; } }\n";
         if( isset( $decoded_control['letter_spacing']['smartphone'] ) ) echo "@media(max-width: 610px) { " .$selector . "{ letter-spacing : " . $decoded_control['letter_spacing']['smartphone'] .  "px; } }\n";
      endif;
   }
endif;

// Assign Variable
if( ! function_exists( 'blogistic_assign_var' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_assign_var( $selector, $control) {
      $decoded_control =  BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      echo " body { " . $selector . ": ".esc_html( $decoded_control ).  ";}\n";
   }
endif;

// Text Color ( Variable Change Single )
if( ! function_exists( 'blogistic_variable_color_single' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_variable_color_single( $selector, $control) {
      $decoded_control =  BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
         echo "body  { " . $selector . ": ".blogistic_get_color_format($decoded_control).  ";}";
   }
endif;

// Text Color ( Variable Change )
if( ! function_exists( 'blogistic_variable_color' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_variable_color( $selector, $control) {
      $decoded_control =  BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['color'] ) ) :
         $color = $decoded_control['color'];
         echo "body  { " . $selector . ": ".blogistic_get_color_format($color).  ";}";
      endif;
      if( isset( $decoded_control['hover'] ) ) :
         $color_hover = $decoded_control['hover'];
         echo "body  { " . $selector . "-hover : ".blogistic_get_color_format($color_hover).  "; }";
      endif;
   }
endif;

// Color Group ( Variable Change )
if( ! function_exists( 'blogistic_variable_bk_color' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_variable_bk_color( $selector, $control, $var = '' ) {
      $decoded_control = json_decode( BIT\blogistic_get_customizer_option( $control ), true );
      if( ! $decoded_control ) return;
      if(isset($decoded_control['initial'] )):
         if( isset( $decoded_control['initial']['type'] ) ) :
            $type = $decoded_control['initial']['type'];
            if( isset( $decoded_control['initial'][$type] ) ) echo "body { ".$selector.": " .blogistic_get_color_format( $decoded_control['initial'][$type] ). "}\n";
         endif;
      endif;

      if(isset($decoded_control['hover'])):
         if( isset( $decoded_control['hover']['type'] ) ) :
            $type = $decoded_control['hover']['type'];
            if( isset( $decoded_control['hover'][$type] ) ) echo "body { ".$selector."-hover: " .blogistic_get_color_format( $decoded_control['hover'][$type] ). "}\n";
         endif;
      endif;
   }
endif;

// Category colors
if( ! function_exists( 'blogistic_category_bk_colors_styles' ) ) :
   /**
    * Generates css code for font size
    * MARK: Category
   *
   * @package blogistic
   * @since 1.0.0
   */
   function blogistic_category_bk_colors_styles() {
      $totalCats = get_categories();
      if( $totalCats ) :
         foreach( $totalCats as $singleCat ) :
            $category_color = BIT\blogistic_get_customizer_option( 'category_' .absint($singleCat->term_id). '_color' );
            echo "body .post-categories .cat-item.cat-" . absint($singleCat->term_id) . " a{ color : " .blogistic_get_color_format( $category_color['color'] ). "} \n";
            echo "body .post-categories .cat-item.cat-" . absint($singleCat->term_id) . " a:hover { color : " .blogistic_get_color_format( $category_color['hover'] ). "} \n";
            echo "body.archive.category.category-" . absint($singleCat->term_id) . " { color : " .blogistic_get_color_format( $category_color['color'] ). "} \n";
            echo "body.archive.category.category-" . absint($singleCat->term_id) . " { color : " .blogistic_get_color_format( $category_color['hover'] ). "} \n";
            $category_color_bk = json_decode( BIT\blogistic_get_customizer_option( 'category_background_' .absint($singleCat->term_id). '_color' ), true );
            if(isset($category_color_bk['initial'] )):
               if( isset( $category_color_bk['initial']['type'] ) ) :
                  $type = $category_color_bk['initial']['type'];
                  if( isset( $category_color_bk['initial'][$type] ) ) {
                     echo "body .post-categories .cat-item.cat-" . absint($singleCat->term_id) . " a{ background : " .blogistic_get_color_format( $category_color_bk['initial'][$type]   ). "} \n";
                     echo "body.archive.category.category-". absint($singleCat->term_id) . " .archive-title i { color : " .blogistic_get_color_format( $category_color_bk['initial'][$type]   ). "}\n";
                  }
               endif;
            endif;

            if(isset($category_color_bk['hover'] )) :
               if( isset( $category_color_bk['hover']['type'] ) ) :
                  $type = $category_color_bk['hover']['type'];
                  if( isset( $category_color_bk['hover'][$type] ) ) {
                     echo "body .post-categories .cat-item.cat-" . absint($singleCat->term_id) . " a:hover{ background : " .blogistic_get_color_format( $category_color_bk['hover'][$type] ). "} \n";
                  }
               endif;
            endif;
         endforeach;
      endif;
   }
endif;

// tags colors
if( ! function_exists( 'blogistic_tags_bk_colors_styles' ) ) :
   /**
    * Generates css code for font size
   *
   * @package blogistic
   * @since 1.0.0
   */
   function blogistic_tags_bk_colors_styles() {
      $totalTags = get_tags();
      if( $totalTags ) :
         foreach( $totalTags as $singleTag ) :
            $tag_color = BIT\blogistic_get_customizer_option( 'tag_' .absint($singleTag->term_id). '_color' );
            echo "body .tags-wrap .tags-item.tag-" . absint($singleTag->term_id) . " span{ color : " .blogistic_get_color_format( $tag_color['color'] ). "} \n";
            echo "body .tags-wrap .tags-item.tag-" . absint($singleTag->term_id) . ":hover span { color : " .blogistic_get_color_format( $tag_color['hover'] ). "} \n";
            echo "body.archive.tag.tag-" . absint($singleTag->term_id) . " { color : " .blogistic_get_color_format( $tag_color['color'] ). "} \n";
            echo "body.archive.tag.tag-" . absint($singleTag->term_id) . " { color : " .blogistic_get_color_format( $tag_color['hover'] ). "} \n";
            $tag_color_bk = json_decode( BIT\blogistic_get_customizer_option( 'tag_background_' .absint($singleTag->term_id). '_color' ), true );
            if(isset($tag_color_bk['initial'] )) :
               if( isset( $tag_color_bk['initial']['type'] ) ) :
                  $type = $tag_color_bk['initial']['type'];
                  if( isset( $tag_color_bk['initial'][$type] ) ){
                     echo "body .tags-wrap .tags-item.tag-" . absint($singleTag->term_id) . "{ background : " .blogistic_get_color_format( $tag_color_bk['initial'][$type]   ). "} \n";
                     echo "body.archive.tag.tag-" . absint($singleTag->term_id) . " { background : " .blogistic_get_color_format( $tag_color_bk['initial'][$type]   ). "} \n";
                  }
               endif;
            endif;

            if(isset($tag_color_bk['hover'] )) :
               if( isset( $tag_color_bk['hover']['type'] ) ) :
                  $type = $tag_color_bk['hover']['type'];
                  if( isset( $tag_color_bk['hover'][$type] ) ) {
                     echo "body .tags-wrap .tags-item.tag-" . absint($singleTag->term_id) . ":hover { background : " .blogistic_get_color_format( $tag_color_bk['hover'][$type] ). "} \n";
                     echo "body.archive.tag.tag-" . absint($singleTag->term_id) . "{ background : " .blogistic_get_color_format( $tag_color_bk['hover'][$type]   ). "} \n";
                  }
               endif;
            endif;
         endforeach;
      endif;
   }
endif;

// Border Options
if( ! function_exists( 'blogistic_border_option' ) ) :
   /**
   * Generate css code for Top header Text Color
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_border_option( $selector, $control, $property="border" ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['type'] ) || isset( $decoded_control['width'] ) || isset( $decoded_control['color'] ) ) :
      echo $selector. "{ ".$property.": ". $decoded_control['width'] ."px ".$decoded_control['type']." ". blogistic_get_color_format($decoded_control['color']) .";}";
      endif;
   }
endif;

// Box Shadow
if( ! function_exists( 'blogistic_box_shadow_styles' ) ) :
   /**
    * Generates css code for block box shadow size
    *
    * @package Blogistic
    * @since 1.0.0
    */
   function blogistic_box_shadow_styles($selector,$value) {
      $blogistic_box_shadow = BIT\blogistic_get_customizer_option($value);
      if( $blogistic_box_shadow['option'] == 'none' ) {
         echo $selector."{ box-shadow: 0px 0px 0px 0px;
         }\n";
      } else {
         if( $blogistic_box_shadow['type'] == 'outset') $blogistic_box_shadow['type'] = '';
         echo $selector."{ box-shadow : ".esc_html( $blogistic_box_shadow['type'] ) ." ".esc_html( $blogistic_box_shadow['hoffset'] ).  "px ". esc_html( $blogistic_box_shadow['voffset'] ). "px ".esc_html( $blogistic_box_shadow['blur'] ).  "px ".esc_html( $blogistic_box_shadow['spread'] ).  "px ".blogistic_get_color_format( $blogistic_box_shadow['color'] ).  ";
         }\n";
      }
   }
endif;

// Image ratio change
if( ! function_exists( 'blogistic_image_ratio' ) ) :
   /**
   * Generate css code for variable change with responsive
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_image_ratio( $selector, $control ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      $value = ( $control == 'category_collection_image_ratio' ) ? '500px' : '100%';
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['desktop'] ) && $decoded_control['desktop'] > 0 ) :
         $desktop = $decoded_control['desktop'];
         echo $selector . "{ padding-bottom : calc(".esc_html( $desktop ).  " * ". esc_html( $value ) ."); }";
      endif;
      if( isset( $decoded_control['tablet'] ) && $decoded_control['tablet'] > 0 ) :
         $tablet = $decoded_control['tablet'];
         echo "@media(max-width: 940px) { " .$selector . "{ padding-bottom : calc(".esc_html( $tablet ).  "* ". esc_html( $value ) ."); } }\n";
      endif;
      if( isset( $decoded_control['smartphone'] ) && $decoded_control['smartphone'] > 0 ) :
         $smartphone = $decoded_control['smartphone'];
         echo "@media(max-width: 610px) { " .$selector . "{ padding-bottom : calc(".esc_html($smartphone).  " * ". esc_html( $value ) ."); } }\n";
      endif;
   }
endif;

// Image ratio Variable change
if( ! function_exists( 'blogistic_image_ratio_variable' ) ) :
   /**
   * Generate css code for variable change with responsive
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_image_ratio_variable( $selector, $control ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['desktop'] ) && $decoded_control['desktop'] > 0 ) :
         $desktop = $decoded_control['desktop'];
         echo "body { ". $selector . " : ".$desktop."}\n";
         endif;
         if( isset( $decoded_control['tablet'] ) && $decoded_control['tablet'] > 0 ) :
         $tablet = $decoded_control['tablet'];
         echo "body { " .$selector . "-tab : ".$tablet. " } \n";
         endif;
         if( isset( $decoded_control['smartphone'] ) && $decoded_control['smartphone'] > 0 ) :
         $smartphone = $decoded_control['smartphone'];
         echo "body { " .$selector . "-mobile : ".$smartphone.  " } \n";
      endif;
   }
endif;

// Background Color (Initial)
if( ! function_exists( 'blogistic_initial_bk_color' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_initial_bk_color( $selector, $control) {
      $decoded_control = json_decode( BIT\blogistic_get_customizer_option( $control ), true);
      if( ! $decoded_control ) return;
      if( isset( $decoded_control[$decoded_control['type']] ) ) echo $selector. " { background: " .blogistic_get_color_format( $decoded_control[$decoded_control ['type']]). "}\n";
   }
endif;

// Background Color (Initial Variable)
if( ! function_exists( 'blogistic_initial_bk_color_variable' ) ) :
   /**
   * Generate css code for top header color options
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_initial_bk_color_variable( $selector, $control) {
      $decoded_control = json_decode( BIT\blogistic_get_customizer_option( $control ), true);
      if( ! $decoded_control ) return;
      if( array_key_exists( 'type', $decoded_control ) && isset( $decoded_control[$decoded_control['type']] ) ) echo "body { " . $selector. " : " .blogistic_get_color_format( $decoded_control[$decoded_control ['type']]). "}\n";
   }
endif;

// Site Background Color
if( ! function_exists( 'blogistic_get_background_style' ) ) :
   /**
    * Generate css code for background control.
    *
    * @package blogistic
    * @since 1.0.0 
    */
   function blogistic_get_background_style( $selector, $control, $var = '' ) {
      $decoded_control = json_decode( BIT\blogistic_get_customizer_option( $control ), true );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['type'] ) ) :
         $type = $decoded_control['type'];
         switch( $type ) {
            case 'image' : if( isset( $decoded_control[$type]['media_id'] ) ) echo $selector . " { background-image: url(" .esc_url( wp_get_attachment_url( $decoded_control[$type]['media_id'] ) ). ") }";
                  if( isset( $decoded_control['repeat'] ) ) echo $selector . "{ background-repeat: " .esc_html( $decoded_control['repeat'] ). "}";
                  if( isset( $decoded_control['position'] ) ) echo $selector . "{ background-position:" .esc_html( $decoded_control['position'] ). "}";
                  if( isset( $decoded_control['attachment'] ) ) echo $selector . "{ background-attachment: " .esc_html( $decoded_control['attachment'] ). "}";
                  if( isset( $decoded_control['size'] ) ) echo $selector . "{ background-size: " .esc_html( $decoded_control['size'] ). "}";
               break;
            default: if( isset( $decoded_control[$type] ) ) echo $selector . "{ background: " .blogistic_get_color_format( $decoded_control[$type] ). "}";
         }
      endif;
   }
endif;

// Border option
if( ! function_exists( 'blogistic_border_option' ) ) :
   /**
   * Generate css code for border option
   *
   * @package Blogistic
   * @since 1.0.0 
   */
   function blogistic_border_option( $selector, $control, $property="border" ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['type'] ) || isset( $decoded_control['width'] ) || isset( $decoded_control['color'] ) ) :
      echo $selector. "{ ".$property.": ". $decoded_control['width'] ."px ".$decoded_control['type']." ". blogistic_get_color_format($decoded_control['color']) .";}";
      endif;
   }
endif;

// spacing control
if( ! function_exists( 'blogistic_spacing_control' ) ) :
   /**
    * Generate css code for variable change with responsive for spacing controls
    *
    * @package Blogistic
    * @since 1.0.0
    */
    function blogistic_spacing_control( $selector, $control, $property ) {
      $decoded_control = BIT\blogistic_get_customizer_option( $control );
      if( ! $decoded_control ) return;
      if( isset( $decoded_control['desktop'] ) ) :
         $desktop = $decoded_control['desktop'];
         echo $selector . '{ '. esc_html( $property ) .' : '. esc_html( $desktop['top'] ) .'px '. esc_html( $desktop['right'] ) .'px '. esc_html( $desktop['bottom'] ) .'px '. esc_html( $desktop['left'] ) .'px }';
      endif;
      if( isset( $decoded_control['tablet'] ) ) :
         $tablet = $decoded_control['tablet'];
         echo '@media(max-width: 940px) {' .$selector . '{ '. esc_html( $property ) .' : '. esc_html( $tablet['top'] ) .'px '. esc_html( $tablet['right'] ) .'px '. esc_html( $tablet['bottom'] ) .'px '. esc_html( $tablet['left'] ) .'px } }';
      endif;
      if( isset( $decoded_control['smartphone'] ) ) :
         $smartphone = $decoded_control['smartphone'];
         echo '@media(max-width: 610px) { ' . $selector . '{ '. esc_html( $property ) .' : '. esc_html( $smartphone['top'] ) .'px '. esc_html( $smartphone['right'] ) .'px '. esc_html( $smartphone['bottom'] ) .'px '. esc_html( $smartphone['left'] ) .'px } }';
      endif;
    }
endif;