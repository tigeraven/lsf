/* Super Simple Fancy Checkbox Plugin @Dave Macaulay, 2013

http://davemacaulay.com/jquery-simple-checkbox-replacement-jquery-simplecheckbox-js/

*/
(function( $ ) {
    $.fn.simpleCheckbox = function(options) {
        var defaults = {
            newElementClass: 'tog',
            activeElementClass: 'on'
        };
        var options = $.extend(defaults, options);
        this.each(function() {
            //Assign the current checkbox to obj
            var obj = $(this);
            //Create new element to be styled
            var newObj = $('<div/>', {
                'id': '#' + obj.attr('id'),
                'class': options.newElementClass,
                'style': 'display: block;'
            }).insertAfter(this);
            //Make sure pre-checked boxes are rendered as checked
            if(obj.is(':checked')) {
                newObj.addClass(options.activeElementClass);
            }
            obj.hide(); //Hide original checkbox
            //Labels can be painful, let's fix that
            if($('[for=' + obj.attr('id') + ']').length) {

                var label = $('[for=' + obj.attr('id') + ']');
                label.click(function() {
                    newObj.trigger('click'); //Force the label to fire our element
                    return false;
                });
            }
            //Attach a click handler
            newObj.click(function() {
                //Assign current clicked object
                var obj = $(this);
                //Check the current state of the checkbox
                if(obj.hasClass(options.activeElementClass)) {
                    obj.removeClass(options.activeElementClass);
                    $(obj.attr('id')).attr('checked',false);
                } else {
                    obj.addClass(options.activeElementClass);
                    $(obj.attr('id')).attr('checked',true);
                }
                //Kill the click function
                return false;
            });
        });
    };
})(jQuery);


jQuery(document).ready(function($){

// replace checkboxes with Toggles
    $('input:checkbox').not('#setting_mo_nivo_effect input:checkbox').simpleCheckbox();

});// end document.ready
