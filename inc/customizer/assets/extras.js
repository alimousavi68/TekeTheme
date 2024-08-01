(function( api, $ ) {
    var ajaxurl = customizerExtrasObject.ajaxUrl, _wpnonce = customizerExtrasObject._wpnonce, custom = customizerExtrasObject.custom
    var customCallback = customizerExtrasObject.custom_callback
    // Change the previewed URL to the selected page when changing the page_for_posts.
    $.each( custom, function( key, val ) {
        if( key == 'blog_single_section_panel' ) {
            wp.customize.panel( key, function ( panel ) {
                panel.expanded.bind(function ( isExpanded ) {
                    if ( isExpanded ) {
                        wp.customize.previewer.previewUrl.set( val );
                    }
                });
            });
        } else {
            wp.customize.section( key, function ( section ) {
                section.expanded.bind(function ( isExpanded ) {
                    if ( isExpanded ) {
                        wp.customize.previewer.previewUrl.set( val );
                    }
                });
            });
        }
    })

    // contextual
    $.each( customCallback, function( controlId, controlValue ) {
        wp.customize( controlId, function( value ) {
            value.bind( function( to ) {
                $.each( controlValue, function( index, toToggle ){
                    if( JSON.stringify( to ) == index ) {
                        $.each( toToggle, function( key, val ){
                            wp.customize.control( val ).activate()
                        })
                    } else {
                        $.each( toToggle, function( key, val ){
                            wp.customize.control( val ).deactivate()
                        })
                    }
                })
                if( to in controlValue ) {
                    $.each( controlValue[to], function( key, val ){
                        wp.customize.control( val ).activate()
                    })
                }
            });
        });    
    })

    // ajax calls
    $(document).on( "click", ".customize-info-box-action-control .info-box-button", function() {
        var _this = $(this), action = _this.data("action"), html = _this.html();
        $.ajax({
            method: 'post',
            url: ajaxurl,
            data: ({
                'action': action,
                '_wpnonce': _wpnonce,
            }),
            beforeSend: function() {
                _this.html( 'Processing' )
                _this.attr( 'disabled', true )
            },
            success: function() {
                _this.html( html );
            },
            complete: function() {
                window.location.reload();
            }
        })
    })
})( wp.customize, jQuery )