/* global $, prestashop */

/**
 * This module exposes an extension point in the form of the `showModal` function.
 *
 * If you want to override the way the modal window is displayed, simply define:
 *
 * prestashop.blockcart = prestashop.blockcart || {};
 * prestashop.blockcart.showModal = function myOwnShowModal (modalHTML) {
 *   // your own code
 *   // please not that it is your responsibility to handle closing the modal too
 * };
 *
 * Attention: your "override" JS needs to be included **before** this file.
 * The safest way to do so is to place your "override" inside the theme's main JS file.
 *
 */

jQuery.fn.tooltip = window._BStooltip;

$(document).ready(function () {
    prestashop.blockcart = prestashop.blockcart || {};

    var showModal = prestashop.blockcart.showModal || function (modal) {};

    $(document).ready(function () {

        $(document).on('click', '#js-cart-close', function (e) {
            $('#blockcart, #mobile-cart-wrapper, #_mobile_blockcart-content, #_desktop_blockcart-content').removeClass('show');
            e.stopPropagation();
        });

        $(document).on('click', '#blockcart-content', function (e) {
            e.stopPropagation();
        });


        prestashop.on(
            'updateCart',
            function (event) {
                var refreshURL = $('#blockcart').data('refresh-url');
                var requestData = {};

                if (event && event.reason && typeof event.resp !== 'undefined' && !event.resp.hasError) {

                    requestData = {
                        id_customization: event.reason.idCustomization,
                        id_product_attribute: event.reason.idProductAttribute,
                        id_product: event.reason.idProduct,
                        action: event.reason.linkAction
                    };

                      }
                    $.post(refreshURL, requestData).then(function (resp) {

                        if (event.reason && event.reason.linkPlace == 'cart-preview') {
                            $('#blockcart').replaceWith($(resp.preview).addClass('show'));
                        } else {
                            $('#blockcart').replaceWith($(resp.preview));
                        }

                        $('#mobile-cart-products-count').text($(resp.preview).find('.cart-products-count-btn').first().text());

                        prestashop.emit('responsive updateAjax', {
                            mobile: prestashop.responsive.mobile
                        });

                        prestashop.emit('updatedAjaxCart', {});

                        if (!iqitTheme.pl_infinity) {
                            prestashop.emit('updateFacets', window.location.href);
                        }

                        if (resp.modal) {
                            showModal(resp.modal);
                        }
                    }).fail(function (resp) {
                        prestashop.emit('handleError', {eventType: 'updateShoppingCart', resp: resp});
                    });
              
                if (event && event.resp && event.resp.hasError) {
                    prestashop.emit('showErrorNextToAddtoCartButton', { errorMessage: event.resp.errors.join('<br/>')});
                }
            }
        );
    });
});
