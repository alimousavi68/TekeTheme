jQuery(document).ready(function($) {
    var ajaxUrl = blogisticObject.ajaxUrl, wpnonce = blogisticObject._wpnonce
    AOS.init();

    // top date time
    var timeElement = $( ".top-date-time .time" )
    if( timeElement.length > 0 ) {
        setInterval(function() {
            timeElement.html(new Date().toLocaleTimeString())
        },1000);
    }
    
    // handle preloader
    function blogisticPreloader( timeOut = 3000 ) {
        setTimeout(function() {
            $('body .blogistic_loading_box').hide();
        }, timeOut);
    }
    blogisticPreloader()

    // breadcrumb separator
    var breadcrumbSeparatorContainer = $('.blogistic-breadcrumb-element')
    if( breadcrumbSeparatorContainer.length > 0 ) {
        var separatorIconObject = blogisticObject.breadcrumbSeparatorIcon
        var separatorIcon = ( separatorIconObject.type == 'icon' ) ? '<i class="'+ separatorIconObject.value +'"></i>' : '<img src="'+  separatorIconObject.url +'">'
        var listElement = breadcrumbSeparatorContainer.find('li.trail-item')
        var elementToAppend = '<span class="item-separator">'+ separatorIcon +'</span>'
        listElement.append(elementToAppend)
    }

    // header - normal search
    var searchSectionContainer = $('.search-wrap')
    if( searchSectionContainer.length > 0 ) {
        searchSectionContainer.on( 'click', '.search-trigger', function(){
            var _this = $(this)
            _this.siblings().show()
            _this.parent().addClass('toggled')
            _this.siblings().find('.search-field').focus()
        })

        // close search popup
        var closeButton = searchSectionContainer.find('.search-form-wrap')
        if( closeButton.length > 0 ) {
            closeButton.on('click', '.search-form-close', function(){
                var _thisButton = $(this), parentElement = _thisButton.parents('.search-wrap')
                parentElement.removeClass('toggled')
                _thisButton.parent().hide()
            })
        }

        // on ESC button click
        $(document).on('keydown', function( event ){
            if( event.keyCode == 27 ) {
                closeButton.hide()
                closeButton.parent().removeClass('toggled')
            }
        })
    }

    // check for dark mode drafts
    if( localStorage.getItem( "themeMode" ) != null ) {
        if( localStorage.getItem("themeMode") == "dark" ) {
            $('body').addClass( 'blogistic-dark-mode' ).removeClass('blogistic-light-mode')
        } else {
            $('body').addClass( 'blogistic-light-mode' ).removeClass('blogistic-dark-mode')
        }
    }
    
    // header - theme mode
    var themeModeContainer = $('.mode-toggle-wrap')
    if( themeModeContainer.length > 0 ) {
        themeModeContainer.on( 'click', '.mode-toggle', function(){
            var _this = $(this), bodyElement = _this.parents('body')
            if( bodyElement.hasClass('blogistic-dark-mode') ) {
                localStorage.setItem( 'themeMode', 'light' )
                bodyElement.removeClass('blogistic-dark-mode').addClass('blogistic-light-mode')
            } else {
                localStorage.setItem( 'themeMode', 'dark' )
                bodyElement.removeClass('blogistic-light-mode').addClass('blogistic-dark-mode')
            }
        })
    }

    // header - canvas menu
    var canvasMenuContainer = $('.blogistic-canvas-menu')
    if( canvasMenuContainer.length > 0 ) {
        canvasMenuContainer.on( 'click', '.canvas-menu-icon', function() {
            var _this = $(this), bodyElement = _this.parents('body')
            bodyElement.toggleClass('blogistic-model-open');
            onElementOutsideClick( _this.siblings(), function(){
                bodyElement.removeClass( 'blogistic-model-open' )
            })
        })
    }

    // on element outside click function
    function onElementOutsideClick( currentElement, callback ) {
        $(document).mouseup(function( e ) {
            var container = $(currentElement);
            if ( !container.is(e.target) && container.has(e.target).length === 0) callback();
        })
    }

    // full-width banner
    var fullWidthBannerContainer = $('#blogistic-main-banner-section')
    if( fullWidthBannerContainer.length > 0 ) {
        var mainBannerWrapper = fullWidthBannerContainer.find('.main-banner-wrap')
        mainBannerWrapper.slick({
            arrows: true,
            fade: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 3000,
            speed: 500,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-arrow-left-long"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-arrow-right-long"></i></button>',
            rtl: $(  'body' ).hasClass( 'rtl' ) ? true : false,
            responsive: [
              {
                breakpoint: 800
              }
            ]
        })
    }

    // carousel
    var carouselContainer = $('.blogistic-carousel-section')
    if( carouselContainer.length > 0 ) {
        var carouselWrapper = carouselContainer.find('.carousel-wrap')
        var prevIcon = ( blogisticObject.carouselPrevIcon.type == 'icon' ) ? '<i class="'+ blogisticObject.carouselPrevIcon.value +'"></i>' : '<img src="'+ blogisticObject.carouselPrevIcon.url +'">'
        var nextIcon = ( blogisticObject.carouselNextIcon.type == 'icon' ) ? '<i class="'+ blogisticObject.carouselNextIcon.value +'"></i>' : '<img src="'+ blogisticObject.carouselNextIcon.url +'">'
        carouselWrapper.slick({
            arrows: (blogisticObject.carouselArrows == 1 ),
            fade: (blogisticObject.carouselFade == 1),
            infinite: (blogisticObject.carouselInfiniteLoop == 1),
            autoplay: (blogisticObject.carouselAutoplay == 1),
            autoplaySpeed: parseInt( blogisticObject.carouselAutoplaySpeed ),
            slidesToShow: parseInt( blogisticObject.carouselSlideToShow ),
            slidesToScroll: parseInt( blogisticObject.slidesToScroll ),
            speed: parseInt( blogisticObject.carouselSpeed ),
            prevArrow: '<button type="button" class="slick-prev">'+ prevIcon +'</button>',
            nextArrow: '<button type="button" class="slick-next">'+ nextIcon +'</button>',
            rtl: $(  'body' ).hasClass( 'rtl' ) ? true : false,
            responsive: [
              {
                breakpoint: 1100,
                settings: {
                  slidesToShow: 3,
                },
              },
              {
                breakpoint: 940,
                settings: {
                  slidesToShow: 2,
                },
              },
              {
                breakpoint: 700,
                settings: {
                  slidesToShow: 1,
                },
              }
            ]
        
        })
    }

    // scripts for archive pages
    if( blogisticObject.isArchive ) {
        // archive masonry layout 
        var masonryContainer = $("body.archive--masonry-layout #primary .blogistic-inner-content-wrap")
        masonryContainer.masonry({
            // options
            // itemSelector: 'article, div.blogistic-advertisement-block',
            gutter: 30,
        })

        // handle the post gallery post format
        var postGalleryElems = $("body #primary article.format-gallery .post-thumbnail-wrapper .thumbnail-gallery-slider")
        if( postGalleryElems.length > 0 ) {
            postGalleryElems.each(function() {
                var thisGallery = $(this)
                thisGallery.slick(blogisticGalleryFormatSlickSliderObject())
            })
        }
    }

    function blogisticGalleryFormatSlickSliderObject() {
        return {
            arrows: true,
            fade: true,
            infinite: true,
            autoplay: false,
            prevArrow: '<button type="button" class="slick-prev"><i class="fa-solid fa-arrow-left-long"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fa-solid fa-arrow-right-long"></i></button>'
        }
    }

    // back to top script
    if( $( "#blogistic-scroll-to-top" ).length ) {
        var scrollContainer = $( "#blogistic-scroll-to-top" );
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 800 ) {
                scrollContainer.addClass('show');
            } else {
                scrollContainer.removeClass('show');
            }
        });
        scrollContainer.click(function(event) {
            event.preventDefault();
            // Animate the scrolling motion.
            $("html, body").animate({scrollTop:0},"slow");
        });
    }

    // main header sticky
    if( blogisticObject.headerSticky ) {
        $(window).on('scroll', function(){
            var scroll = $(window).scrollTop()
            var mainHeaderContainer = $('.main-header')
            if( scroll >= 200 ) {
                mainHeaderContainer.addClass('header-sticky--enabled').removeClass('header-sticky--disabled')
            } else {
                mainHeaderContainer.addClass('header-sticky--disabled').removeClass('header-sticky--enabled')
            }
        })
    }

    var blogisticArchiveElement = $(document).find("body.archive--masonry-layout #primary .blogistic-inner-content-wrap")
    blogisticArchiveElement.on('layoutComplete', function(){
        $(this).masonry()
    })

    // instagram slider
    var instagramContainer = $('.blogistic-instagram-section.slider-enabled, .widget.widget_blogistic_instagram_widget .instagram-container.slider-enabled')
    instagramContainer.each(function(){
        var _this = $(this)
        if( _this.length > 0 ) {
            var instaContainer = _this.find( '.instagram-content' ), nextIconObject = blogisticObject.instagramNextArrow, previousIconObject = blogisticObject.instagramPrevArrow
            var previousIcon = ( previousIconObject.type == 'icon' ) ? '<i class="'+ previousIconObject.value +'"></i>' : '<img src="'+ previousIconObject.url +'">'
            var nextIcon = ( nextIconObject.type == 'icon' ) ? '<i class="'+ nextIconObject.value +'"></i>' : '<img src="'+ nextIconObject.url +'">'
            var instaObject = {
                arrows: ( blogisticObject.instagramSliderArrow == 1 ),
                nextArrow: `<button type="button" class="slick-next">`+ nextIcon +`</button>`,
                prevArrow: `<button type="button" class="slick-prev">`+ previousIcon +`</button>`,
                autoplay: ( blogisticObject.instagramAutoplayOption == 1 ),
                autoplaySpeed: parseInt( blogisticObject.instagramAutoplaySpeed ),
                infinite: ( blogisticObject.instagramSliderInfinite == 1 ),
                speed: parseInt( blogisticObject.instagramSliderSpeed ),
                slidesToShow: ( _this.is( '.blogistic-instagram-section' ) ) ? parseInt( blogisticObject.instagramSlidesToShow ) : 1,
                slidesToScroll: parseInt( blogisticObject.instagramSlidesToScroll ),
                responsive: [
                    {
                      breakpoint: 940,
                      settings: {
                        slidesToShow: 2
                      },
                    },
                    {
                      breakpoint: 700,
                      settings: {
                        slidesToShow: 1
                      },
                    }
                ]
            }
            if( nextIconObject.type == 'none' ) instaObject = { ...instaObject, nextArrow: '' }
            if( previousIconObject.type == 'none' ) instaObject = { ...instaObject, prevArrow: '' }
            instaContainer.slick( instaObject )
        }
    })

    var instaContainer = $('.blogistic-instagram-section, .widget.widget_blogistic_instagram_widget .instagram-container' )
    instaContainer.each(function(){
        var _thisContainer = $(this)
        if( _thisContainer.length > 0 ) {
            var instaContainerClass = _thisContainer.find('.instagram-content')
            _thisContainer.on( 'click', '.insta-image a', function( event ){
                if( instaContainerClass.hasClass( 'url-disabled' ) ) event.preventDefault()
            })
    
            if( instaContainerClass.hasClass( 'url-disabled' ) && instaContainerClass.hasClass( 'lightbox-enabled' ) ) {
                instaContainerClass.each(function(){
                    var _this = $(this), findImageSrc
                    if( _this.hasClass( 'slick-initialized' ) ) {
                        var test = _this.find('.instagram-item.slick-slide').not('.slick-cloned')
                        findImageSrc = test.find('.insta-image img')
                    } else {
                        findImageSrc = _this.find('.insta-image img')
                    }
                    var srcArgs = []
                    findImageSrc.each(function(){
                        srcArgs.push({
                            src: $(this).attr('src'),
                            type: 'image'
                        })
                    })
                    _this.find('.instagram-item').magnificPopup({
                        items: srcArgs,
                        gallery: {
                            enabled: true
                        },
                        type: 'image'
                    })
                })
            }
        }
    })

    // category collection slider
    var categoryCollectionContainer = $('#blogistic-category-collection-section.slider-enabled')
    if( categoryCollectionContainer.length > 0 ) {
        var catCollContainer = categoryCollectionContainer.find( '.category-collection-wrap' ), nextIconObject = blogisticObject.catCollNextArrow, previousIconObject = blogisticObject.catCollPrevArrow
        var previousIcon = ( previousIconObject.type == 'icon' ) ? '<i class="'+ previousIconObject.value +'"></i>' : '<img src="'+ previousIconObject.url +'">'
        var nextIcon = ( nextIconObject.type == 'icon' ) ? '<i class="'+ nextIconObject.value +'"></i>' : '<img src="'+ nextIconObject.url +'">'
        catCollContainer.slick({
            arrows: ( blogisticObject.catCollSliderArrow == 1 ),
            nextArrow: `<button type="button" class="slick-next">`+ nextIcon +`</button>`,
            prevArrow: `<button type="button" class="slick-prev">`+ previousIcon +`</button>`,
            autoplay: ( blogisticObject.catCollAutoplayOption == 1 ),
            autoplaySpeed: parseInt( blogisticObject.catCollAutoplaySpeed ),
            infinite: ( blogisticObject.catCollSliderInfinite == 1 ),
            speed: parseInt( blogisticObject.catCollSliderSpeed ),
            slidesToShow: parseInt( blogisticObject.catCollSlidesToShow ),
            slidesToScroll: parseInt( blogisticObject.catCollSlidesToScroll ),
            responsive: [
                {
                  breakpoint: 940,
                  settings: {
                    slidesToShow: 2
                  },
                },
                {
                  breakpoint: 700,
                  settings: {
                    slidesToShow: 1
                  },
                }
            ]
        })
    }

    // carousel widget
    var cpWidgets = $( ".blogistic-widget-carousel-posts" )
    cpWidgets.each(function() {
        var _this = $(this), parentWidgetContainerId = _this.parents( ".widget.widget_blogistic_carousel_widget" ).attr( "id" ), parentWidgetContainer
        if( typeof parentWidgetContainerId != 'undefined' ) {
            parentWidgetContainer = $( "#" + parentWidgetContainerId )
            var ppWidget = parentWidgetContainer.find( ".carousel-posts-wrap" );
        } else {
            var ppWidget = _this;
        }
        if( ppWidget.length > 0 ) {
            var ppWidgetAuto = ppWidget.data( "auto" )
            var ppWidgetArrows = ppWidget.data( "arrows" )
            var ppWidgetLoop = ppWidget.data( "loop" )
            var ppWidgetVertical = ppWidget.data( "vertical" )
            if( ppWidgetVertical == 'vertical' ) {
                ppWidget.slick({
                    vertical: true,
                    dots: false,
                    adaptiveHeight: true,
                    infinite: ppWidgetLoop,
                    arrows: ppWidgetArrows,
                    autoplay: ppWidgetAuto,
                    nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                    prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
                    rtl: $(  'body' ).hasClass( 'rtl' ) ? true : false,
                })
            } else {
                ppWidget.slick({
                    dots: false,
                    infinite: ppWidgetLoop,
                    arrows: ppWidgetArrows,
                    autoplay: ppWidgetAuto,
                    adaptiveHeight: true,
                    nextArrow: `<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>`,
                    prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>`,
                    rtl: $(  'body' ).hasClass( 'rtl' ) ? true : false,
                })
            }  
        }
    })

    // cursor animation
    var cursorContainer = $('.blogistic-cursor')
    if( cursorContainer.length > 0 ) {
        $(document).on( 'mousemove', function( event ){
            cursorContainer[0].style.top = 'calc('+ event.pageY +'px - 15px)'
            cursorContainer[0].style.left = 'calc('+ event.pageX +'px - 15px)'
        })
        var selector = 'a, button, input[type="submit"], #blogistic-scroll-to-top .icon-text, #blogistic-scroll-to-top .icon-holder, .video-playlist-wrap .playlist-items-wrap .video-item, .thumb-video-highlight-text .thumb-controller, .pagination.pagination-type--ajax-load-more, .blogistic-widget-loader .load-more, .mode-toggle-wrap .mode-toggle, .blogistic-canvas-menu .canvas-menu-icon, .blogistic-table-of-content .toc-fixed-icon'
        $( selector ).on( 'mouseover', function(){
            $( cursorContainer ).addClass( 'isActive' )
        })
        $( selector ).on( 'mouseout', function(){
            $( cursorContainer ).removeClass( 'isActive' )
        })
    }

    // social share
    var socialShareContainer = $( '.blogistic-social-share' )
    if( socialShareContainer.length > 0 ) {
        // for print
        var printButton = socialShareContainer.find( '.print' )
        printButton.each(function(){
            $(this).on( 'click', function(){ 
                $(this).find( 'a' ).removeAttr( 'href' )
                window.print()
            })
        })
        // for copy link
        var copyLinkButton = socialShareContainer.find( '.copy_link' )
        copyLinkButton.each(function(){
            $(this).on( 'click', function( event ) { 
                event.preventDefault()
                var copyLinkButtonAnchor = $(this).find( 'a' )
                var linkToCopy = copyLinkButtonAnchor.attr( 'href' )
                navigator.clipboard.writeText( linkToCopy )
            })
        })
    }

    // post format - gallery
    var gallery = $('.wp-block-gallery')
    if( gallery.length > 0 ) {
        if( blogisticObject.singleGalleryLightbox != 1 ) return
        gallery.each(function(){
            var _this = $(this)
            var findImageSrc = _this.find('.wp-block-image img')
            var srcArgs = []
            findImageSrc.each(function(){
                srcArgs.push({
                    src: $(this).attr('src'),
                    type: 'image'
                })
            })
            _this.magnificPopup({
                items: srcArgs,
                gallery: {
                    enabled: true
                },
                type: 'image'
            })
        })
    }
})