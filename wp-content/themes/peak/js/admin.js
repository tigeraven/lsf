jQuery.noConflict();

var MO_ADMIN;

(function ($) {
    MO_ADMIN = {

        post_data: function (data) {

            $('.spinner').css('visibility', 'visible');

            data['order'] = $("#sortable2").sortable("serialize", { attribute: "rel" });
            $.post(ajaxurl, data, function () {
                $('.spinner').css('visibility', 'hidden');
            });
        }

    };
})(jQuery);

jQuery(document).ready(function ($) {


    var data = {
        action: 'update-page-section-order',
        security: $('#mo_page_nonce').val(),
        page_id: $('#single_page_id').val()
    };


    $("#sortable1").children('li').draggable({
        'cursor': 'pointer',
        zIndex: 100,
        helper: 'clone',
        distance: 2,
        connectToSortable: "#sortable2",
        containment: '#order-post-type',
        start: function (event, ui) {
            var width = $('#order-post-type #sortable2 li').first().width();
            $('#sortable1 li.ui-draggable-dragging').css('max-width', width + 'px');
        }
    });

    $("#sortable2").sortable({
        'tolerance': 'intersect',
        'cursor': 'pointer',
        'items': 'li',
        'placeholder': 'placeholder',
        start: function (event, ui) {
            $('#sortable2 li.ui-draggable-dragging').css('width', '100%').css('max-width', '380px').css('height', 'auto');
        },
        stop: function (event, ui) {
            MO_ADMIN.post_data(data);
        },
        receive: function (event, ui) {
            MO_ADMIN.post_data(data);
        }
    });

    $("#sortable2").disableSelection();

    /*------- Open/close action -------*/

    $('#sortable2, #sortable1').on('click', 'a.block-edit, .block-control-actions a.close', function (event) {
        var block_element = $(this).closest("li");
        block_element.find('.block-settings').slideToggle('fast');
        if (block_element.hasClass('block-edit-active') == false) {
            block_element.addClass('block-edit-active');
        } else {
            block_element.removeClass('block-edit-active');
        }
        ;

        return false;

    });

    $('#sortable2').on('click', '.block-control-actions a.remove', function (event) {

        var block_element = $(this).closest("li");

        block_element.remove();

        MO_ADMIN.post_data(data);

        return false;

    });


}); // document ready