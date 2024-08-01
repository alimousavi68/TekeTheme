/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	const themeContstants = {
		prefix: 'blogistic_'
	}
	const themeCalls = {
		blogisticAjaxCall: function( action, id ) {
			$.ajax({
				method: "GET",
				url: blogisticPreviewObject.ajaxUrl,
				data: ({
					action: action,
					_wpnonce: blogisticPreviewObject._wpnonce
				}),
				success: function(response) {
					if( response ) {
						if( $( "head #" + id ).length > 0 ) {
							$( "head #" + id ).html( response )
						} else {
							$( "head" ).append( '<style id="' + id + '">' + response + '</style>' )
						}
					}
				}
			})
		},
		blogisticGenerateTypoCss: function(selector,value) {
			var cssCode = ''
			if( value.font_family ) {
				cssCode += '.blogistic_font_typography { ' + selector + '-family: ' + value.font_family.value + '; } '
			}
			if( value.font_weight ) {
				cssCode += '.blogistic_font_typography { ' + selector + '-weight: ' + value.font_weight.value + '; ' + selector + '-style: ' + value.font_weight.variant + '; } '
			}
			if( value.text_transform ) {
				cssCode += '.blogistic_font_typography { ' + selector + '-texttransform: ' + value.text_transform + '; } '
			}
			if( value.text_decoration ) {
				cssCode += '.blogistic_font_typography { ' + selector + '-textdecoration: ' + value.text_decoration + '; } '
			}
			if( value.font_size ) {
				if( value.font_size.desktop ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-size: ' + value.font_size.desktop + 'px; } '
				}
				if( value.font_size.tablet ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-size-tab: ' + value.font_size.tablet + 'px; } '
				}
				if( value.font_size.smartphone ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-size-mobile: ' + value.font_size.smartphone + 'px; } '
				}
			}
			if( value.line_height ) {
				if( value.line_height.desktop ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-lineheight: ' + value.line_height.desktop + 'px; } '
				}
				if( value.line_height.tablet ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-lineheight-tab: ' + value.line_height.tablet + 'px; } '
				}
				if( value.line_height.smartphone ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-lineheight-mobile: ' + value.line_height.smartphone + 'px; } '
				}
			}
			if( value.letter_spacing ) {
				if( value.letter_spacing.desktop ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-letterspacing: ' + value.letter_spacing.desktop + 'px; } '
				}
				if( value.letter_spacing.tablet ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-letterspacing-tab: ' + value.letter_spacing.tablet + 'px; } '
				}
				if( value.letter_spacing.smartphone ) {
					cssCode += '.blogistic_font_typography { ' + selector + '-letterspacing-mobile: ' + value.letter_spacing.smartphone + 'px; } '
				}
			}
			return cssCode
		},
		blogisticGenerateTypoCssWithSelector: function(selector,value) {
			var cssCode = ''
			if( value.font_family ) {
				cssCode += selector + ' { font-family: ' + value.font_family.value + '; } '
			}
			if( value.font_weight ) {
				cssCode += selector + ' { font-weight: ' + value.font_weight.value + ';  font-style: ' + value.font_weight.variant + '; } '
			}
			if( value.text_transform ) {
				cssCode += selector + ' { text-transform: ' + value.text_transform + '; } '
			}
			if( value.text_decoration ) {
				cssCode += selector + ' { text-decoration: ' + value.text_decoration + '; } '
			}
			if( value.font_size ) {
				if( value.font_size.desktop ) {
					cssCode += selector + ' { font-size: ' + value.font_size.desktop + 'px; } '
				}
				if( value.font_size.tablet ) {
					cssCode += '@media(max-width: 940px) { ' + selector + ' { font-size: ' + value.font_size.tablet + 'px; } } '
				}
				if( value.font_size.smartphone ) {
					cssCode += '@media(max-width: 610px) { ' + selector + ' { font-size: ' + value.font_size.smartphone + 'px; } } '
				}
			}
			if( value.line_height ) {
				if( value.line_height.desktop ) {
					cssCode += selector + ' { line-height: ' + value.line_height.desktop + 'px; } '
				}
				if( value.line_height.tablet ) {
					cssCode += '@media(max-width: 940px) { ' + selector + ' { line-height: ' + value.line_height.tablet + 'px; } } '
				}
				if( value.line_height.smartphone ) {
					cssCode += '@media(max-width: 610px) { ' + selector + ' { line-height: ' + value.line_height.smartphone + 'px; } } '
				}
			}
			if( value.letter_spacing ) {
				if( value.letter_spacing.desktop ) {
					cssCode += selector + ' { letter-spacing: ' + value.letter_spacing.desktop + 'px; } '
				}
				if( value.letter_spacing.tablet ) {
					cssCode += '@media(max-width: 940px) { ' + selector + ' { letter-spacing: ' + value.letter_spacing.tablet + 'px; } } '
				}
				if( value.letter_spacing.smartphone ) {
					cssCode += '@media(max-width: 610px) { ' + selector + ' { letter-spacing: ' + value.letter_spacing.smartphone + 'px; } } '
				}
			}
			return cssCode
		},
		blogisticGenerateStyleTag: function( code, id ) {
			if( code ) {
				if( $( "head #" + id ).length > 0 ) {
					$( "head #" + id ).html( code )
				} else {
					$( "head" ).append( '<style id="' + id + '">' + code + '</style>' )
				}
			} else {
				$( "head #" + id ).remove()
			}
		},
		blogisticGenerateLinkTag: function( action, id ) {
			$.ajax({
				method: "GET",
				url: blogisticPreviewObject.ajaxUrl,
				data: ({
					action: action,
					_wpnonce: blogisticPreviewObject._wpnonce
				}),
				success: function(response) {
					if( response ) {
						var decodedReponse = decodeURIComponent( response )
						var cleanedUrl = decodedReponse.split( '#038;' ).join('')
						if( $( "head #" + id ).length > 0 ) {
							$( "head #" + id ).attr( "href", cleanedUrl )
						} else {
							$( "head" ).append( '<link rel="stylesheet" id="' + id + '" href="' + cleanedUrl + '"></link>' )
						}
					}
				}
			})
		}
	}

	// background color
	wp.customize( 'site_background_color', function( value ) {
		value.bind( function(to) {
			var value = JSON.parse( to )
			if( value ) {
				var cssCode = ''
				if( value.type == 'solid' ) {
					cssCode += 'body.boxed--layout.blogistic_font_typography:before, body.blogistic_font_typography:before, body.blogistic_font_typography .main-header.header-sticky--enabled { background: ' + blogistic_get_color_format(value[value.type]) + '}'
				} else {
					cssCode += 'body.boxed--layout.blogistic_font_typography:before, body.blogistic_font_typography:before, body.blogistic_font_typography .main-header.header-sticky--enabled { background: ' + blogistic_get_color_format(value[value.type]) + '}'
				}
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-body-background' )
			} else {
				themeCalls.blogisticGenerateStyleTag( '', 'blogistic-body-background' )
			}
		});
	});

	// background animation
	wp.customize( 'site_background_animation', function( value ) {
		value.bind( function( to ) {
			$('body').removeClass( 'background-animation--none background-animation--one background-animation--two background-animation--three' ).addClass( 'background-animation--' + to )
		});
	});

	// background color
	wp.customize( 'background_image', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			if( to ) {
				cssCode += 'body:before{ display: none; }';
			} else {
				cssCode += 'body:before{ display: block; }';
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-body-image-background' )
		});
	});

	// post title hover class
	wp.customize( 'post_title_hover_effects', function( value ) {
		value.bind( function(to) {
			$( "body" ).removeClass( "title-hover--none title-hover--one title-hover--two" )
			$( "body" ).addClass( "title-hover--" + to )
		});
	});

	// image hover class
	wp.customize( 'site_image_hover_effects', function( value ) {
		value.bind( function(to) {
			$( "body" ).removeClass( "image-hover--none image-hover--one image-hover--two" )
			$( "body" ).addClass( "image-hover--" + to )
		});
	});

	// global buttons typography
	wp.customize( 'global_button_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-readmore-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-global-button-typo' )
		})
	})

	// theme color bind changes
	wp.customize( 'theme_color', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-color-style', '--blogistic-global-preset-theme-color')
		});
	});

	// gradient theme color bind changes
	wp.customize( 'gradient_theme_color', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-1-style', '--blogistic-global-preset-gradient-theme-color')
		});
	});

	// preset 1 bind changes
	wp.customize( 'preset_color_1', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-1-style', '--blogistic-global-preset-color-1')
		});
	});

	// preset 2 bind changes
	wp.customize( 'preset_color_2', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-2-style', '--blogistic-global-preset-color-2')
		});
	});

	// preset 3 bind changes
	wp.customize( 'preset_color_3', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-3-style', '--blogistic-global-preset-color-3')
		});
	});

	// preset 4 bind changes
	wp.customize( 'preset_color_4', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-4-style', '--blogistic-global-preset-color-4')
		});
	});

	// preset 5 bind changes
	wp.customize( 'preset_color_5', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-5-style', '--blogistic-global-preset-color-5')
		});
	});

	// preset 6 bind changes
	wp.customize( 'preset_color_6', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-6-style', '--blogistic-global-preset-color-6')
		});
	});

	// preset 7 bind changes
	wp.customize( 'preset_color_7', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-7-style', '--blogistic-global-preset-color-7')
		});
	});

	// preset 8 bind changes
	wp.customize( 'preset_color_8', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-8-style', '--blogistic-global-preset-color-8')
		});
	});

	// preset 9 bind changes
	wp.customize( 'preset_color_9', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-9-style', '--blogistic-global-preset-color-9')
		});
	});

	// preset 10 bind changes
	wp.customize( 'preset_color_10', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-10-style', '--blogistic-global-preset-color-10')
		});
	});

	// preset 11 bind changes
	wp.customize( 'preset_color_11', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-11-style', '--blogistic-global-preset-color-11')
		});
	});

	// preset 12 bind changes
	wp.customize( 'preset_color_12', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-color-12-style', '--blogistic-global-preset-color-12')
		});
	});

	// preset gradient 1 bind changes
	wp.customize( 'preset_gradient_1', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-1-style', '--blogistic-global-preset-gradient-color-1')
		});
	});

	// preset gradient 2 bind changes
	wp.customize( 'preset_gradient_2', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-2-style', '--blogistic-global-preset-gradient-color-2')
		});
	});

	// preset gradient 3 bind changes
	wp.customize( 'preset_gradient_3', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-3-style', '--blogistic-global-preset-gradient-color-3')
		});
	});

	// preset gradient 4 bind changes
	wp.customize( 'preset_gradient_4', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-4-style', '--blogistic-global-preset-gradient-color-4')
		});
	});

	// preset gradient 5 bind changes
	wp.customize( 'preset_gradient_5', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-5-style', '--blogistic-global-preset-gradient-color-5')
		});
	});

	// preset gradient 6 bind changes
	wp.customize( 'preset_gradient_6', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-6-style', '--blogistic-global-preset-gradient-color-6')
		});
	});

	// preset gradient 7 bind changes
	wp.customize( 'preset_gradient_7', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-7-style', '--blogistic-global-preset-gradient-color-7')
		});
	});

	// preset gradient 8 bind changes
	wp.customize( 'preset_gradient_8', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-8-style', '--blogistic-global-preset-gradient-color-8')
		});
	});

	// preset gradient 9 bind changes
	wp.customize( 'preset_gradient_9', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-9-style', '--blogistic-global-preset-gradient-color-9')
		});
	});

	// preset gradient 10 bind changes
	wp.customize( 'preset_gradient_10', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-10-style', '--blogistic-global-preset-gradient-color-10')
		});
	});

	// preset gradient 11 bind changes
	wp.customize( 'preset_gradient_11', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-11-style', '--blogistic-global-preset-gradient-color-11')
		});
	});

	// preset gradient 12 bind changes
	wp.customize( 'preset_gradient_12', function( value ) {
		value.bind( function( to ) {
			helperFunctions.generateStyle(to, 'theme-preset-gradient-color-12-style', '--blogistic-global-preset-gradient-color-12')
		});
	});

	// mobile option sub menu option
	wp.customize( 'sub_menu_mobile_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$( "#site-navigation" ).removeClass( "sub-menu-hide-on-mobile" )
			} else {
				$( "#site-navigation" ).addClass( "sub-menu-hide-on-mobile" )
			}
		});
	});

	// mobile option scroll to top option
	wp.customize( 'scroll_to_top_mobile_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$( "#blogistic-scroll-to-top" ).removeClass( "hide-on-mobile" )
			} else {
				$( "#blogistic-scroll-to-top" ).addClass( "hide-on-mobile" )
			}
		});
	});

	// mobile option show custom button option
	wp.customize( 'show_custom_button_mobile_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$( ".header-custom-button" ).removeClass( "hide-on-mobile" )
			} else {
				$( ".header-custom-button" ).addClass( "hide-on-mobile" )
			}
		});
	});

	// mobile option archive readmore button option
	wp.customize( 'show_readmore_button_mobile_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$( "body.blog .blogistic-article-inner .post-button, body.archive .blogistic-article-inner .post-button, body.home .blogistic-article-inner .post-button, body.search .blogistic-article-inner .post-button" ).removeClass( "hide-on-mobile" )
			} else {
				$( "body.blog .blogistic-article-inner .post-button, body.archive .blogistic-article-inner .post-button, body.home .blogistic-article-inner .post-button, body.search .blogistic-article-inner .post-button" ).addClass( "hide-on-mobile" )
			}
		});
	});

	// website layout
	wp.customize( 'website_layout', function( value ) {
		value.bind( function( to ) {
            $('body').removeClass('boxed--layout full-width--layout').addClass( to )
		});
	});

	// single post related articles title option
	wp.customize( 'single_post_related_posts_title', function( value ) {
		value.bind( function(to) {
			if( $( ".single-related-posts-section-wrap" ).find('.blogistic-block-title span').length > 0 ) {
				$( ".single-related-posts-section-wrap" ).find('.blogistic-block-title span').text( to )
			} else {
				$( ".single-related-posts-section-wrap .single-related-posts-section" ).prepend('<h2 class="blogistic-block-title"><span>'+ to +'</span></h2>')
			}
		});
	});

	// single post image ratio
	wp.customize( 'single_responsive_image_ratio', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			if( to.desktop ) {
				cssCode += 'body { --blogistic-single-post-image-ratio: ' + to.desktop + ' }';
			}
			if( to.tablet ) {
				cssCode += 'body { --blogistic-single-post-image-ratio-tab: ' + to.tablet + ' }';
			}
			if( to.smartphone ) {
				cssCode += 'body { --blogistic-single-post-image-ratio-mobile: ' + to.smartphone + ' }';
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-post-image-ratio' )
		});
	});

	// global sidebar sticky option
	wp.customize( 'sidebar_sticky_option', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$("body").addClass( "blogistic-sidebar--enabled" ).removeClass( "blogistic-sidebar--disabled" )
			} else {
				$("body").removeClass( "blogistic-sidebar--enabled" ).addClass( "blogistic-sidebar--disabled" )
			}
		});
	});

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	});
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	});
	// blog description
	wp.customize( 'blogdescription_option', function( value ) {
		value.bind(function(to) {
			if( to ) {
				$( '.site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
			} else {
				$( '.site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			}
		})
	});

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			var cssCode = '.blogistic-light-mode .site-header .site-title a { color: '+ to +' }'
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-site-title' )
		} );
	});

	// site title hover color
	wp.customize( 'site_title_hover_textcolor', function( value ) {
		value.bind( function( to ) {
			var cssCode = '.blogistic-light-mode .site-header .site-title a:hover { color: '+ to +' }'
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-site-title-hover' )
		} );
	});

	// site description color
	wp.customize( 'site_description_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).css( {
				color: to,
			});
		} );
	});

	// site title typo
	wp.customize( 'site_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-site-title'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-site-title-typo' )
		})
	})
	// site tagline typo
	wp.customize( 'site_description_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-site-description'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-site-tagline-typo' )
		})
	})

	// site logo width
	wp.customize( 'blogistic_site_logo_width', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			if( to.desktop ) {
				cssCode += 'body .site-branding img{ width: ' + to.desktop +  'px} '
			}
			if( to.tablet ) {
				cssCode += '@media(max-width: 994px) { body .site-branding img{ width: ' + to.tablet +  'px} } '
			}
			if( to.smartphone ) {
				cssCode += '@media(max-width: 610px) { body .site-branding img{ width: ' + to.smartphone +  'px} } '
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-site-logo-width' )
		});
	});

	var parsedCats = blogisticPreviewObject.totalCats
	if( parsedCats ) {
		parsedCats = Object.keys( parsedCats ).map(( key ) => { return parsedCats[key] })
		parsedCats.forEach(function(item) {
			wp.customize( 'category_' + item.term_id + '_color', function( value ) {
				value.bind( function(to) {
					var cssCode = ''
					if( to.color ) {
						cssCode += "body .post-categories .cat-item.cat-" + item.term_id + " a, body.archive.category.category-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i { color : " + blogistic_get_color_format( to.color ) + " } "
					}
					if( to.hover ) {
						cssCode += "body .post-categories .cat-item.cat-" + item.term_id + " a:hover, body.archive.category.category-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i:hover { color : " + blogistic_get_color_format( to.hover ) + " } "
					}
					themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-category-' + item.term_id + '-style' )
				})
			})
			wp.customize( 'category_background_' + item.term_id + '_color', function( value ) {
				value.bind( function(to) {
					var parsedValue = JSON.parse( to )
					var cssCode = ''
					if( parsedValue ) {
						if( parsedValue.initial[parsedValue.initial.type] ) {
							cssCode += "body .post-categories .cat-item.cat-" + item.term_id + " a, body.archive.category.category-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i { background : " + blogistic_get_color_format( parsedValue.initial[parsedValue.initial.type] ) + " } "
						}
						if( parsedValue.hover[parsedValue.hover.type] ) {
							cssCode += "body .post-categories .cat-item.cat-" + item.term_id + " a:hover, body.archive.category.category-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i:hover { background : " + blogistic_get_color_format( parsedValue.hover[parsedValue.hover.type] ) + " } "
						}
						themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-category-background-' + item.term_id + '-style' )
					} else {
						themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-category-background-' + item.term_id + '-style' )
					}
				})
			})
		})
	}
	
	var parsedTags = blogisticPreviewObject.totalTags
	if( parsedTags ) {
		parsedTags = Object.keys( parsedTags ).map(( key ) => { return parsedTags[key] })
		parsedTags.forEach(function(item) {
			wp.customize( 'tag_' + item.term_id + '_color', function( value ) {
				value.bind( function(to) {
					var cssCode = ''
					if( to.color ) {
						cssCode += "body .tags-wrap .tags-item.tag-" + item.term_id + " span, body.archive.tag.tag-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i { color : " + blogistic_get_color_format( to.color ) + " } "
					}
					if( to.hover ) {
						cssCode += "body .tags-wrap .tags-item.tag-" + item.term_id + ":hover span, body.archive.tag.tag-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i:hover { color : " + blogistic_get_color_format( to.hover ) + " } "
					}
					themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-tag-' + item.term_id + '-style' )
				})
			})
			wp.customize( 'tag_background_' + item.term_id + '_color', function( value ) {
				value.bind( function(to) {
					var parsedValue = JSON.parse( to )
					var cssCode = ''
					if( parsedValue ) {
						if( parsedValue.initial[parsedValue.initial.type] ) {
							cssCode += "body .tags-wrap .tags-item.tag-" + item.term_id + ", body.archive.tag.tag-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i { background : " + blogistic_get_color_format( parsedValue.initial[parsedValue.initial.type] ) + " } "
						}
						if( parsedValue.hover[parsedValue.hover.type] ) {
							cssCode += "body .tags-wrap .tags-item.tag-" + item.term_id + ":hover, body.archive.tag.tag-" + item.term_id + " #blogistic-main-wrap .page-header .blogistic-container i:hover { background : " + blogistic_get_color_format( parsedValue.hover[parsedValue.hover.type] ) + " } "
						}
						themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-tag-background-' + item.term_id + '-style' )
					} else {
						themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-tag-background-' + item.term_id + '-style' )
					}
				})
			})
		})
	}

	// header menu alignment
	wp.customize( 'menu_options_menu_alignment', function( value ) {
		value.bind( function(to) {
			$(".main-header").removeClass( "menu-alignment--right menu-alignment--center menu-alignment--left" )
			$(".main-header").addClass( "menu-alignment--" + to )
		})
	})

	// menu hover effects
	wp.customize( 'blogistic_header_menu_hover_effect', function( value ) {
		value.bind( function(to) {
			$("#site-navigation").removeClass( "hover-effect--none hover-effect--one hover-effect--two hover-effect--three hover-effect--four hover-effect--five" )
			$("#site-navigation").addClass( "hover-effect--" + to )
		})
	})

	// header menu color
	wp.customize( 'header_menu_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-menu-color'
			if( to.color ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to.color ) + " } "
			}
			if( to.hover ) {
				cssCode += "body { " + selector + "-hover : " + blogistic_get_color_format( to.hover ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-menu-style' )
		})
	})

	// main menu typo
	wp.customize( 'main_menu_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-menu'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-main-menu-typo' )
		})
	})

	// sub menu typo
	wp.customize( 'main_menu_sub_menu_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-submenu'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-main-sub-menu-typo' )
		})
	})

	// custom button label
	wp.customize( 'blogistic_custom_button_label', function( value ) {
		value.bind( function( to ) {
			if( $( "#masthead .header-custom-button-wrapper" ).find('.custom-button-label').length > 0 ) {
				$( "#masthead .header-custom-button-wrapper" ).find('.custom-button-label').text( to )
			} else {
				$( "#masthead .header-custom-button-wrapper .header-custom-button" ).append('<span class="custom-button-label">'+ to +'</span>')
			}
		})
	})

	// custom button typography
	wp.customize( 'blogistic_custom_button_text_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-custom-button'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-custom-button-typo' )
		})
	})

	// custom button text color
	wp.customize( 'blogistic_custom_button_text_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-custom-button-color'
			if( to.color ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to.color ) + " } "
			}
			if( to.hover ) {
				cssCode += "body { " + selector + "-hover : " + blogistic_get_color_format( to.hover ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-custom-button-text-color-style' )
		})
	})

	// banner elements alignment
	wp.customize( 'main_banner_post_elements_alignment', function( value ) {
		value.bind( function( to ) {
			$(".blogistic-main-banner-section").removeClass("banner-align--right banner-align--center banner-align--left")
			$(".blogistic-main-banner-section").addClass("banner-align--" + to)
		})
	})

	// banner image ratio
	wp.customize( 'main_banner_responsive_image_ratio', function( value ) {
		value.bind( function( to ) {
			var cssCode = ''
			if( to.desktop && to.desktop > 0 ) {
				cssCode += "body .blogistic-main-banner-section article.post-item .post-thumb { padding-bottom : calc(" + to.desktop +  " * 100%) } "
			}
			if( to.tablet && to.tablet > 0) {
				cssCode += "@media(max-width: 940px) { body .blogistic-main-banner-section article.post-item .post-thumb { padding-bottom : calc(" + to.tablet +  " * 100%) } } "
			}
			if( to.smartphone && to.smartphone > 0  ) {
				cssCode += "@media(max-width: 610px) { body .blogistic-main-banner-section article.post-item .post-thumb { padding-bottom : calc(" + to.smartphone +  " * 100%) } } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-banner-image-ratio' )
		})
	})

	// banner title typography
	wp.customize( 'main_banner_design_post_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-main-banner-section .main-banner-wrap .post-elements .post-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-banner-title-typo' )
		})
	})

	// banner excerpt typography
	wp.customize( 'main_banner_design_post_excerpt_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-main-banner-section .main-banner-wrap .post-elements .post-excerpt'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-banner-excerpt-typo' )
		})
	})

	// banner categories typography
	wp.customize( 'main_banner_design_post_categories_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-main-banner-section .post-categories .cat-item a'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-banner-categories-typo' )
		})
	})
	
	// banner date typography
	wp.customize( 'main_banner_design_post_date_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-main-banner-section .main-banner-wrap .post-elements .post-date'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-banner-date-typo' )
		})
	})

	// banner date typography
	wp.customize( 'main_banner_design_post_author_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-main-banner-section .main-banner-wrap .post-elements .author'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-banner-author-typo' )
		})
	})

	// carousel elements alignment
	wp.customize( 'carousel_post_elements_alignment', function( value ) {
		value.bind( function( to ) {
			$('#blogistic-carousel-section').removeClass('carousel-align--center carousel-align--right carousel-align--left').addClass( 'carousel-align--' + to )
		})
	})

	// carousel image ratio
	wp.customize( 'carousel_responsive_image_ratio', function( value ) {
		value.bind( function( to ) {
			var cssCode = ''
			if( to.desktop && to.desktop > 0 ) {
				cssCode += "body .blogistic-carousel-section article.post-item .post-thumb, body .blogistic-carousel-section.carousel-layout--two article.post-item .post-thumb { padding-bottom : calc(" + to.desktop +  " * 100%) } "
			}
			if( to.tablet && to.tablet > 0 ) {
				cssCode += "@media(max-width: 940px) { body .blogistic-carousel-section article.post-item .post-thumb, body .blogistic-carousel-section.carousel-layout--two article.post-item .post-thumb { padding-bottom : calc(" + to.tablet +  " * 100%) } } "
			}
			if( to.smartphone && to.smartphone > 0 ) {
				cssCode += "@media(max-width: 610px) { body .blogistic-carousel-section article.post-item .post-thumb, body .blogistic-carousel-section.carousel-layout--two article.post-item .post-thumb { padding-bottom : calc(" + to.smartphone +  " * 100%) } } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-carousel-image-ratio' )
		})
	})

	// carousel title typography
	wp.customize( 'carousel_design_post_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-carousel-section .carousel-wrap .post-elements .post-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-carousel-title-typo' )
		})
	})

	// carousel excerpt typography
	wp.customize( 'carousel_design_post_excerpt_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-carousel-section .carousel-wrap .post-elements .post-excerpt'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-carousel-excerpt-typo' )
		})
	})

	// carousel categories typography
	wp.customize( 'carousel_design_post_categories_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-carousel-section .carousel-wrap .post-categories .cat-item a'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-carousel-categories-typo' )
		})
	})

	// carousel date typography
	wp.customize( 'carousel_design_post_date_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-carousel-section .carousel-wrap .post-elements .post-date'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-carousel-date-typo' )
		})
	})

	// carousel author typography
	wp.customize( 'carousel_design_post_author_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '.blogistic_font_typography .blogistic-carousel-section .carousel-wrap .post-elements .author'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-carousel-date-typo' )
		})
	})

	// archive posts column
	wp.customize( 'archive_post_column', function( value ) {
		value.bind( function( to ) {
			if( to.desktop ) {
				$("body").removeClass( "archive-desktop-column--one archive-desktop-column--two archive-desktop-column--three archive-desktop-column--four" )
				$("body").addClass( "archive-desktop-column--" + blogistic_get_numeric_string( to.desktop ) )
			}
			if( to.tablet ) {
				$("body").removeClass( "archive-tablet-column--one archive-tablet-column--two archive-tablet-column--three archive-tablet-column--four" )
				$("body").addClass( "archive-tablet-column--" + blogistic_get_numeric_string( to.tablet ) )
			}
			if( to.smartphone ) {
				$("body").removeClass( "archive-mobile-column--one archive-mobile-column--two archive-mobile-column--three archive-mobile-column--four" )
				$("body").addClass( "archive-mobile-column--" + blogistic_get_numeric_string( to.smartphone ) )
			}
		})
	})

	// archive posts elements alignment
	wp.customize( 'archive_post_elements_alignment', function( value ) {
		value.bind( function( to ) {
			if( to ) {
				$("body.archive .blogistic-inner-content-wrap, body.blog .blogistic-inner-content-wrap, body.home .blogistic-inner-content-wrap, body.search .blogistic-inner-content-wrap").removeClass( "archive-align--left archive-align--center archive-align--right" )
				$("body.archive .blogistic-inner-content-wrap, body.blog .blogistic-inner-content-wrap, body.home .blogistic-inner-content-wrap, body.search .blogistic-inner-content-wrap").addClass( "archive-align--" + to )
			}
		})
	})

	// archive posts image ratio
	wp.customize( 'archive_responsive_image_ratio', function( value ) {
		value.bind( function( to ) {
			var cssCode = ''
			var selector = '--blogistic-post-image-ratio'
			var listSelector = '--blogistic-list-post-image-ratio'
			if( to.desktop && to.desktop > 0 ) {
				cssCode += 'body { ' + selector + ': ' + to.desktop + ' }'
				cssCode += 'body { ' + listSelector + ': ' + to.desktop + ' }'
			}
			if( to.tablet && to.tablet > 0) {
				cssCode += '@media(max-width: 940px) { body { ' + selector + '-tab: ' + to.tablet + ' } }'
				cssCode += '@media(max-width: 940px) { body { ' + listSelector + '-tab: ' + to.tablet + ' } }'
			}
			if( to.smartphone && to.smartphone > 0  ) {
				cssCode += '@media(max-width: 610px) { body { ' + selector + '-mobile: ' + to.smartphone + ' } }'
				cssCode += '@media(max-width: 610px) { body { ' + listSelector + '-mobile: ' + to.smartphone + ' } }'
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-posts-image-ratio' )
		})
	})

	// archive title typo
	wp.customize( 'archive_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-post-title-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-title-typo' )
		})
	})

	// archive excerpt typo
	wp.customize( 'archive_excerpt_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-post-content-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-excerpt-typo' )
		})
	})

	// archive category typo
	wp.customize( 'archive_category_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-category-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-category-typo' )
		})
	})

	// archive date typo
	wp.customize( 'archive_date_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-date-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-date-typo' )
		})
	})

	// archive author typo
	wp.customize( 'archive_author_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-author-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-author-typo' )
		})
	})

	// archive read time typo
	wp.customize( 'archive_read_time_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-readtime-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-read-time-typo' )
		})
	})

	// archive comment typo
	wp.customize( 'archive_comment_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-comment-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-comment-typo' )
		})
	})

	// archive category box typo
	wp.customize( 'archive_category_info_box_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.blogistic_font_typography.archive.category .page-header .page-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-category-page-title-typo' )
		})
	})

	// archive category description typo
	wp.customize( 'archive_category_info_box_description_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.blogistic_font_typography.archive.category .page-header .archive-description'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-category-page-description-typo' )
		})
	})

	// archive tag page title typo
	wp.customize( 'archive_tag_info_box_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.blogistic_font_typography.archive.tag .page-header .page-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-tag-page-title-typo' )
		})
	})

	// archive tag page description typo
	wp.customize( 'archive_tag_info_box_description_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.blogistic_font_typography.archive.tag .page-header .archive-description'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-tag-page-description-typo' )
		})
	})

	// archive author page title typo
	wp.customize( 'archive_author_info_box_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.blogistic_font_typography.archive.author .page-header .page-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-author-page-title-typo' )
		})
	})

	// archive author page description typo
	wp.customize( 'archive_author_info_box_description_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.blogistic_font_typography.archive.author .page-header .archive-description'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-author-page-description-typo' )
		})
	})

	// single title typo
	wp.customize( 'single_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.single-post.blogistic_font_typography .site-main article .entry-title, body.single-post.blogistic_font_typography .single-header-content-wrap .entry-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-title-typo' )
		})
	})

	// single content typo
	wp.customize( 'single_content_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.single-post.blogistic_font_typography .site-main article .entry-content'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-content-typo' )
		})
	})

	// single category typo
	wp.customize( 'single_category_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.single-post.blogistic_font_typography #primary article .post-categories .cat-item a, body.single-post.blogistic_font_typography .single-header-content-wrap .post-categories .cat-item a'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-category-typo' )
		})
	})

	// single date typo
	wp.customize( 'single_date_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.single-post.blogistic_font_typography .post-meta-wrap .post-date, body.single-post.blogistic_font_typography .single-header-content-wrap.post-meta .post-date'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-date-typo' )
		})
	})

	// single author typo
	wp.customize( 'single_author_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.single-post.blogistic_font_typography .site-main article .post-meta-wrap .byline, body.single-post.blogistic_font_typography .single-header-content-wrap .post-meta-wrap .byline'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-author-typo' )
		})
	})

	// single read time typo
	wp.customize( 'single_read_time_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.single-post.blogistic_font_typography #primary .blogistic-inner-content-wrap .post-meta  .post-read-time, body.single-post.blogistic_font_typography .single-header-content-wrap .post-meta  .post-read-time, body.single-post.blogistic_font_typography .single-header-content-wrap .post-meta  .post-comments-num, body.single-post.blogistic_font_typography #primary .blogistic-inner-content-wrap .post-meta  .post-comments-num'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-read-time-typo' )
		})
	})

	// page title typo
	wp.customize( 'page_title_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.page.blogistic_font_typography #blogistic-main-wrap #primary article .entry-title'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-page-title-typo' )
		})
	})

	// page content typo
	wp.customize( 'page_content_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body.page.blogistic_font_typography article .entry-content'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-page-content-typo' )
		})
	})

	// heading one typo
	wp.customize( 'heading_one_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body article h1'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-heading-one-typo' )
		})
	})

	// heading two typo
	wp.customize( 'heading_two_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body article h2'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-heading-two-typo' )
		})
	})

	// heading three typo
	wp.customize( 'heading_three_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body article h3'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-heading-three-typo' )
		})
	})

	// heading four typo
	wp.customize( 'heading_four_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body article h4'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-heading-four-typo' )
		})
	})

	// heading five typo
	wp.customize( 'heading_five_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body article h5'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-heading-five-typo' )
		})
	})

	// heading six typo
	wp.customize( 'heading_six_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body article h6'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-heading-six-typo' )
		})
	})

	// sidebar block title typo
	wp.customize( 'sidebar_block_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-widget-block-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-block-title-typo' )
		})
	})

	// sidebar post title typo
	wp.customize( 'sidebar_post_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-widget-title-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-post-title-typo' )
		})
	})

	// sidebar post category typo
	wp.customize( 'sidebar_category_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-widget-category-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-post-category-typo' )
		})
	})

	// sidebar post date typo
	wp.customize( 'sidebar_date_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-widget-date-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-post-date-typo' )
		})
	})

	// sidebar heading one
	wp.customize( 'sidebar_heading_one_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body aside h1.wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-heading-one-typo' )
		})
	})

	// sidebar heading two
	wp.customize( 'sidebar_heading_two_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body aside h2.wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-heading-two-typo' )
		})
	})

	// sidebar heading three
	wp.customize( 'sidebar_heading_three_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body aside h3.wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-heading-three-typo' )
		})
	})

	// sidebar heading four
	wp.customize( 'sidebar_heading_four_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body aside h4.wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-heading-four-typo' )
		})
	})

	// sidebar heading five
	wp.customize( 'sidebar_heading_five_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body aside h5.wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-heading-five-typo' )
		})
	})

	// sidebar heading six
	wp.customize( 'sidebar_heading_six_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body aside h6.wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-heading-six-typo' )
		})
	})

	// breadcrumb typography
	wp.customize( 'breadcrumb_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body .blogistic-breadcrumb-wrap ul li'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-breadcrumb-typo' )
		})
	})

	// header general settings background color
	wp.customize( 'header_background', function( value ) {
		value.bind( function(to) {
			var value = JSON.parse( to )
			if( value ) {
				var cssCode = ''
				cssCode += 'header.site-header .main-header {' + blogistic_get_background_style( value ) + '}'
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-header-background-style' )
			} else {
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-header-background-style' )
			}
		});
	});

	// theme header general setting vertical padding
	wp.customize( 'header_vertical_padding', function( value ) {
		value.bind(function( to ){
			var cssCode = ''
			// for desktop
			cssCode += '.main-header .blogistic-container .row{ padding-top: ' + to.desktop + 'px }';
			cssCode += ' .main-header .blogistic-container .row{ padding-bottom: ' + to.desktop + 'px }';
			// for tablet
			cssCode += ' @media(max-width: 940px) { .main-header .blogistic-container .row{ padding-top: ' + to.tablet + 'px } }';
			cssCode += ' @media(max-width: 940px) { .main-header .blogistic-container .row{ padding-bottom: ' + to.tablet + 'px } }';
			// for smartphone
			cssCode += ' @media(max-width: 610px) { .main-header .blogistic-container .row{ padding-top: ' + to.smartphone + 'px } }';
			cssCode += ' @media(max-width: 610px) { .main-header .blogistic-container .row{ padding-bottom: ' + to.smartphone + 'px } }';
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-header-vertical-padding' )
		})
	})

	// menu options sub menu text color
	wp.customize( 'header_sub_menu_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-menu-color-submenu'
			if( to.color ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to.color ) + " } "
			}
			if( to.hover ) {
				cssCode += "body { " + selector + "-hover : " + blogistic_get_color_format( to.hover ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-menu-options-sub-menu-text-color' )
		})
	})

	// search icon color
	wp.customize( 'blogistic_search_icon_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-search-icon-color'
			if( to.color ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to.color ) + " } "
			}
			if( to.hover ) {
				cssCode += "body { " + selector + "-hover : " + blogistic_get_color_format( to.hover ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-search-icon-color' )
		})
	})

	// canvas menu icon color
	wp.customize( 'canvas_menu_icon_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-canvas-icon-color'
			if( to.color ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to.color ) + " } "
			}
			if( to.hover ) {
				cssCode += "body { " + selector + "-hover : " + blogistic_get_color_format( to.hover ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-canvas-menu-icon-color-style' )
		})
	})

	// archive inner background color
	wp.customize( 'archive_inner_background_color', function( value ) {
		value.bind( function(to) {
			var value = JSON.parse( to )
			if( value ) {
				var cssCode = ''
				if( value.type == 'solid' ) {
					cssCode += 'body #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inner, body.archive--block-layout #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inner, body.search-results.blogistic_font_typography #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inne, body.search.search-results #blogistic-main-wrap .blogistic-container .page-header { background: ' + blogistic_get_color_format(value[value.type]) + '}'
				} else {
					cssCode += 'body #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inner, body.archive--block-layout #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inner, body.search-results.blogistic_font_typography #blogistic-main-wrap > .blogistic-container > .row#primary article .blogistic-article-inne, body.search.search-results #blogistic-main-wrap .blogistic-container .page-header { background: ' + blogistic_get_color_format(value[value.type]) + '}'
				}
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-inner-background-style' )
			} else {
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-archive-inner-background-style' )
			}
		});
	});

	// pagination text color
	wp.customize( 'pagination_text_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-pagination-color'
			if( to.color ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to.color ) + " } "
			}
			if( to.hover ) {
				cssCode += "body { " + selector + "-hover : " + blogistic_get_color_format( to.hover ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-pagination-text-color' )
		})
	})

	// widgets border radius
	wp.customize( 'sidebar_border_radius', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			cssCode += "body .widget, body #widget_block { border-radius: " + to + "px } "
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-button-radius' )
		})
	})

	// footer title typography
	wp.customize( 'footer_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body footer .footer-inner .widget_block .wp-block-group__inner-container .wp-block-heading, body footer .footer-inner section.widget .widget-title, body footer .footer-inner .wp-block-heading'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-footer-title-typo' )
		})
	})

	// footer text typography
	wp.customize( 'footer_text_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body footer .footer-inner ul.wp-block-latest-posts a, body footer .footer-inner ol.wp-block-latest-comments li footer, body footer .footer-inner ul.wp-block-archives a, body footer .footer-inner ul.wp-block-categories a, body footer .footer-inner ul.wp-block-page-list a, body footer .footer-inner .widget_blogistic_post_grid_widget .post-grid-wrap .post-title, body footer .footer-inner .menu .menu-item a, body footer .footer-inner .widget_blogistic_category_collection_widget .categories-wrap .category-item .category-name, body footer .widget_blogistic_post_list_widget .post-list-wrap .post-title a'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-footer-text-typo' )
		})
	})

	// bottom footer title typography
	wp.customize( 'bottom_footer_text_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body .bottom-inner-wrapper .site-info'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-footer-title-typo' )
		})
	})

	// bottom footer text typography
	wp.customize( 'bottom_footer_link_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body .bottom-inner-wrapper .site-info a'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-footer-text-typo' )
		})
	})

	// page background color
	wp.customize( 'page_background_color', function( value ) {
		value.bind( function(to) {
			var value = JSON.parse( to )
			if( value ) {
				var cssCode = ''
				cssCode += 'body.page #blogistic-main-wrap #primary article.page {' +  blogistic_get_background_style( value ) + '}'
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-page-background-style' )
			} else {
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-page-background-style' )
			}
		});
	});

	// single post background color
	wp.customize( 'single_page_background_color', function( value ) {
		value.bind( function(to) {
			var value = JSON.parse( to )
			if( value ) {
				var cssCode = ''
				var selector = 'body.single-post #blogistic-main-wrap .blogistic-container .row#primary .post-inner, body.single-post #blogistic-main-wrap .blogistic-container .row#primary .comments-area, body.single-post #primary article .post-card .bmm-author-thumb-wrap, body.single-post #blogistic-main-wrap .blogistic-container .row#primary nav.navigation, body.single-post #blogistic-main-wrap .blogistic-container .row#primary .single-related-posts-section-wrap'
				if( value.type == 'solid' ) {
					cssCode += selector +' { background: ' + blogistic_get_color_format(value[value.type]) + '}'
				} else {
					cssCode += selector + ' { background: ' + blogistic_get_color_format(value[value.type]) + '}'
				}
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-single-background-style' )
			} else {
				themeCalls.blogisticGenerateStyleTag( '', 'blogistic-single-background-style' )
			}
		});
	});
	
	// single post content alignment
	wp.customize( 'single_post_content_alignment', function( value ) {
		value.bind( function(to) {
			$('body.single #primary .blogistic-inner-content-wrap .entry-content').removeClass( 'content-alignment--left content-alignment--center content-alignment--right' ).addClass( 'content-alignment--' + to )
		})
	})
	
	// page image ratio
	wp.customize( 'page_responsive_image_ratio', function( value ) {
		value.bind( function( to ) {
			var cssCode = ''
			var selector = '--blogistic-single-page-image-ratio'
			if( to.desktop && to.desktop > 0 ) {
				cssCode += 'body { ' + selector + ': ' + to.desktop + ' }'
			}
			if( to.tablet && to.tablet > 0) {
				cssCode += 'body { ' + selector + '-tablet: ' + to.tablet + ' }'
			}
			if( to.smartphone && to.smartphone > 0  ) {
				cssCode += 'body { ' + selector + '-mobile: ' + to.smartphone + ' }'
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-page-image-ratio' )
		})
	})

	// category collection image ratio
	wp.customize( 'category_collection_image_ratio', function( value ) {
		value.bind( function( to ) {
			var cssCode = ''
			if( to.desktop && to.desktop > 0 ) {
				cssCode += "body .blogistic-category-collection-section .category-wrap:before { padding-bottom : calc(" + to.desktop +  " * 500px) } "
			}
			if( to.tablet && to.tablet > 0) {
				cssCode += "@media(max-width: 940px) { body .blogistic-category-collection-section .category-wrap:before { padding-bottom : calc(" + to.tablet +  " * 500px) } } "
			}
			if( to.smartphone && to.smartphone > 0  ) {
				cssCode += "@media(max-width: 610px) { body .blogistic-category-collection-section .category-wrap:before { padding-bottom : calc(" + to.smartphone +  " * 500px) } } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-category-collection-image-ratio' )
		})
	})

	// category collection hover effects
	wp.customize( 'category_collection_hover_effects', function( value ) {
		value.bind( function( to ) {
			$( "#blogistic-category-collection-section" ).removeClass( 'hover-effect--none hover-effect--one' ).addClass( 'hover-effect--' + to )
		})
	})

	// category collection button typo
	wp.customize( 'category_collection_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-category-collection-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-category-collection-typo' )
		})
	})

	// top header section background
	wp.customize( 'top_header_section_background', function( value ) {
		value.bind( function(to) {
			var value = JSON.parse( to )
			if( value ) {
				var cssCode = ''
				var selector = '--blogistic-top-header-bk-color'
				if( value.type == 'solid' ) {
					cssCode += 'body {' + selector + ': ' + blogistic_get_color_format( value[value.type] ) + '}'
				} else {
					cssCode += 'body {' + selector + ': ' + blogistic_get_color_format( value[value.type] ) + '}'
				}
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-top-header-section-background' )
			} else {
				themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-top-header-section-background' )
			}
		});
	});

	// sidebar button typography
	wp.customize( 'sidebar_pagination_button_typo', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = 'body .blogistic-widget-loader .load-more'
			cssCode = themeCalls.blogisticGenerateTypoCssWithSelector( selector, to )
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-sidebar-pagination-button-typo' )
		})
	})

	// cursor animation
	wp.customize( 'cursor_animation', function( value ) {
		value.bind( function(to) {
			if( to != 'none' ) {
				$('body .blogistic-cursor').removeClass( 'type--one' ).addClass( 'type--' + to )
			} else {
				$('body .blogistic-cursor').removeClass( 'type--one' )
			}
		});
	});

	// social icons inherit global color
	wp.customize( 'social_icon_official_color_inherit', function( value ) {
		value.bind( function(to) {
			if( to ) {
				$('body .blogistic-social-icon').addClass( 'official-color--enabled' )
			} else {
				$('body .blogistic-social-icon').removeClass( 'official-color--enabled' )
			}
		});
	});

	// you may have missed section title option
	wp.customize( 'you_may_have_missed_title_option', function( value ) {
		value.bind( function(to) {
			if( $( "#blogistic-you-may-have-missed-section" ).find('.section-title').length > 0 ) {
				if( to ){
					$('#blogistic-you-may-have-missed-section .section-title').show()
				} else {
					$('#blogistic-you-may-have-missed-section .section-title').hide()
				}
			} else {
				var sectionTitleControl = wp.customize.instance('you_may_have_missed_title').get();
				$( "#blogistic-you-may-have-missed-section .blogistic-you-may-missed-inner-wrap" ).prepend('<div class="blogistic-block-title">'+ sectionTitleControl +'</div>')
			}
		});
	});

	// you may have missed section title
	wp.customize( 'you_may_have_missed_title', function( value ) {
		value.bind( function(to) {
			if( $( "#blogistic-you-may-have-missed-section" ).find('.section-title').length > 0 ) {
				$( "#blogistic-you-may-have-missed-section" ).find('.section-title').text( to )
			} else {
				$( "#blogistic-you-may-have-missed-section .blogistic-you-may-missed-inner-wrap" ).prepend('<div class="section-title">'+ to +'</div>')
			}
			const { icons, colors, backgrounds } = to
			var cssCode = ''
			$('.blogistic-social-share').each(function(){
				// add item
				if( $(this).find( '.social-share' ).length < icons.length && $(this).parents('body').hasClass( 'single' ) ) {
					let lastChild = $(this).find( '.social-share:last-child' )
					let addToList = lastChild.clone()
					let lastChildClassCount = lastChild.attr( 'class' ).split( ' ' )
					if( lastChildClassCount.length > 1 ) {
						addToList.addClass( 'social-item--' + icons.length )
					}
					$(this).find( '.social-shares' ).append( addToList )
				}
				$(this).find( '.social-share' ).each(function( index ){
					var _this = $(this)
					if( ( index + 1 ) > icons.length ) _this.remove()
					if( ( index + 1 ) <= icons.length ) {
						// for icons
						_this.find( 'i' ).removeClass().addClass( icons[index].value )
						if( _this.hasClass( 'social-item--' + ( index + 1 ) ) ) {
							// for colors
							if( 'initial' in colors[index] ) {
								const initial = colors[index].initial
								const hover = colors[index].hover
								cssCode += "body .blogistic-social-share .social-share.social-item--"+ ( index + 1 ) +" i { color : " + blogistic_get_color_format( initial[ initial.type ] ) + " } "
								cssCode += "body .blogistic-social-share .social-share.social-item--"+ ( index + 1 ) +" a:hover i { color : " + blogistic_get_color_format( hover[ hover.type ] ) + " } "
							} else {
								cssCode += "body .blogistic-social-share .social-share.social-item--"+ ( index + 1 ) +" i { color : " + blogistic_get_color_format( initial[ initial.type ] ) + " } "
							}
		
							// for backgrounds
							if( 'initial' in backgrounds[index] ) {
								const initial = backgrounds[index].initial
								const hover = backgrounds[index].hover
								cssCode += "body .blogistic-social-share .social-share.social-item--"+ ( index + 1 ) +" a i { background : " + blogistic_get_color_format( initial[ initial.type ] ) + " } "
								cssCode += "body .blogistic-social-share .social-share.social-item--"+ ( index + 1 ) +" a:hover i { background : " + blogistic_get_color_format( hover[ hover.type ] ) + " } "
							} else {
								cssCode += "body .blogistic-social-share .social-share.social-item--"+ ( index + 1 ) +" a i { background : " + blogistic_get_color_format( initial[ initial.type ] ) + " } "
							}
						}
					}
				})
			})
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-social-share-styles' )
		});
	});

	// you may have missed section elements alignments
	wp.customize( 'you_may_have_missed_post_elements_alignment', function( value ) {
		value.bind( function(to) {
			console.log( to )
			$('.blogistic-you-may-have-missed-section').removeClass( 'you-may-have-missed-align--center you-may-have-missed-align--left you-may-have-missed-align--right' ).addClass( 'you-may-have-missed-align--' + to )
		});
	});

	// you may have missed image ratio
	wp.customize( 'you_may_have_missed_responsive_image_ratio', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			if( to.desktop ) {
				cssCode += 'body { --blogistic-youmaymissed-image-ratio: ' + to.desktop + ' }';
			}
			if( to.tablet ) {
				cssCode += 'body { --blogistic-youmaymissed-image-ratio-tab: ' + to.tablet + ' }';
			}
			if( to.smartphone ) {
				cssCode += 'body { --blogistic-youmaymissed-image-ratio-mobile: ' + to.smartphone + ' }';
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-image-ratio' )
		});
	});

	// you may have missed section title color
	wp.customize( 'you_may_have_missed_title_color', function( value ) {
		value.bind( function(to) {
			var cssCode = ''
			var selector = '--blogistic-youmaymissed-block-title-color'
			if( to ) {
				cssCode += "body { " + selector + " : " + blogistic_get_color_format( to ) + " } "
			}
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-section-title-style' )
		})
	})

	// you may have missed section title typography
	wp.customize( 'you_may_have_missed_design_section_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-youmaymissed-block-title-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-section-title-typo' )
		})
	})

	// you may have missed post title typography
	wp.customize( 'you_may_have_missed_design_post_title_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-youmaymissed-title-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-post-title-typo' )
		})
	})

	// you may have missed post categories typography
	wp.customize( 'you_may_have_missed_design_post_categories_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-youmaymissed-category-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-post-categories-typo' )
		})
	})

	// you may have missed post author typography
	wp.customize( 'you_may_have_missed_design_post_author_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-youmaymissed-author-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-post-author-typo' )
		})
	})

	// you may have missed post date typography
	wp.customize( 'you_may_have_missed_design_post_date_typography', function( value ) {
		value.bind( function( to ) {
			ajaxFunctions.typoFontsEnqueue()
			var cssCode = ''
			var selector = '--blogistic-youmaymissed-date-font'
			cssCode = themeCalls.blogisticGenerateTypoCss(selector,to)
			themeCalls.blogisticGenerateStyleTag( cssCode, 'blogistic-you-may-have-missed-post-date-typo' )
		})
	})

	// check if string is variable and formats 
	function blogistic_get_color_format(color) {
		if( color.indexOf( '--blogistic-global-preset' ) != -1 ) {
			return( 'var( ' + color + ' )' );
		} else {
			return color;
		}
	}

	function blogistic_get_background_style( control ) {
	   	if( control ) {
			var cssCode = '', mediaUrl = '', repeat = '', position = '', attachment = '', size = ''
			switch( control.type ) {
			case 'image' : 
			 		if( 'media_id' in control.image ) mediaUrl = 'background-image: url(' + control.image.media_url + ');'
					if( 'repeat' in control ) repeat = " background-repeat: "+ control.repeat + ';'
					if( 'position' in control ) position = " background-position: "+ control.position + ';'
					if( 'attachment' in control ) attachment = " background-attachment: "+ control.attachment + ';'
					if( 'size' in control ) size = " background-size: "+ control.size + ';'
					return cssCode.concat( mediaUrl, repeat, position, attachment, size )
				break;
			default: 
			if( 'type' in control ) return "background: " + blogistic_get_color_format( control[control.type] )
		  }
		}
	}

	// converts integer to string for attibutes value 
	function blogistic_get_numeric_string(int) {
		switch( int ) {
			case 2:
				return "two";
				break;
			case 3:
				return "three";
				break;
			case 4:
				return "four";
				break;
			case 5:
				return "five";
				break;
			case 6:
				return "six";
				break;
			case 7:
				return "seven";
				break;
			case 8:
				return "eight";
				break;
			case 9:
				return "nine";
				break;
			case 10:
				return "ten";
				break;
			default:
				return "one";
		}
	}

	// constants
	const ajaxFunctions = {
		typoFontsEnqueue: function() {
			var action = themeContstants.prefix + "typography_fonts_url",id ="customizer-typo-fonts-css"
			themeCalls.blogisticGenerateLinkTag( action, id )
		}
	}

	// constants
	const helperFunctions = {
		generateStyle: function(color, id, variable) {
			if(color) {
				if( id == 'theme-color-style' ) {
					var styleText = 'body { ' + variable + ': ' + blogistic_get_color_format(color) + '}';
				} else {
					var styleText = 'body { ' + variable + ': ' + blogistic_get_color_format(color) + '}';
				}
				if( $( "head #" + id ).length > 0 ) {
					$( "head #" + id).text( styleText )
				} else {
					$( "head" ).append( '<style id="' + id + '">' + styleText + '</style>' )
				}
			}
		}
	}
}( jQuery ) );