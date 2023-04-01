/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
    /*
    // check for css :hover supports and save in a variable
    var supportsTouch = (typeof Touch == "object");

    if(supportsTouch){ 
        // not supports :hover
        $('.items').on('click', function(){ });
    }
    */
    
    $(".items").rowGrid();

    var inProgress = false;
    $(window).on('touchmove', onScroll); // for mobile
    $(window).on('scroll', onScroll);
    
    function onScroll()
    {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
            var quantity = $('#quantity').attr('data-quantity');

            if (quantity !== '') {
                $.ajax({
                    type: 'GET',
                    url: '/items/previous',
                    data: {quantity: quantity},
                    dataType: 'html',
                    beforeSend: function () {
                        inProgress = true;
                        $('#quantity').html('<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>');
                    },
                    success: function (data) {
                        $('#quantity').html('');
                        
                        if (data !== '') {
                            $(".items").append(data);
                            $(".items").rowGrid("appended");

                            quantity = parseInt(quantity) + $(data).filter('.item').length;

                            $('#quantity').attr('data-quantity', quantity);

                            window.history.pushState(null, null, '?quantity=' + quantity);

                            inProgress = false;
                        } else {
                            $('#quantity').attr('data-quantity', '');
                            inProgress = true;
                        }
                    }
                });
            }
        }
    }
    
    $('.items').on('click', '.bookmark', function (e) {
        e.preventDefault();

        var item_id = $(this).closest('.item').attr('id');

        $.ajax({
            type: 'POST',
            context: this,
            url: '/bookmarks/action',
            data: 'item_id=' + item_id,
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                if (typeof data.action !== "undefined") {
                    $(this).attr('title', data.title);

                    switch (data.action) {
                        case 0:
                            $(this).removeClass('active');
                            break;
                        case 1:
                            $(this).addClass('active');
                            break;
                    }
                }

                notification(data.status, data.message);
            }
        });
    });
});

function itemDelete(options)
{
    (new PNotify({
        title: 'Важное предупреждение',
        text: options.text,
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {'dir1': 'down', 'dir2': 'right', 'modal': true}
    })).get().on('pnotify.confirm', function () {
        $.ajax({
            type: 'POST',
            url: options.url,
            data: 'item_id=' + options.item_id,
            dataType: 'json',
            beforeSend: function () {

            },
            success: function (data) {
                if (data.status === 'success') {
                    $('#' + options.item_id).remove();

                    var itemQuantity = $(".items").children('.item').length;
                    if (itemQuantity < 1) {
                        $('.text-empty').css('display', 'block');
                    }

                    $('#quantity').attr('data-quantity', itemQuantity);
                    $(".items").rowGrid();
                }

                notification(data.status, data.message);
            }
        });

    });
}
