jQuery(document).ready(function( $ ) {
    // Use buttonset() for radio images
    $( '.customize-control-radio-image .buttonset' ).buttonset();

    // Handles setting the new value in the customier
    $( '.customize-control-radio-image input:radio' ).change(function(){
        // Get the name of the setting
        var _this = $(this), setting = _this.attr('data-customize-setting-link')
        // Get the value of the currently-checked radio input
        var image = _this.val();
        // Set the new value
        wp.customize(setting, function( obj ){
            obj.set(image)
        })
    })
});