/**
 * 2007-2017 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2017 PrestaShop SA
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
import $ from 'jquery';
import 'easyzoom/dist/easyzoom';
import prestashop from 'prestashop';
//import Swiper from "swiper";


$(document).ready(function () {
    var coverSwiper;
    var thumbsSwiper;

    createProductSpin();
    createInputFile();
    imageScrollBox();
    coverImage();
    createToolTip();
    accessoriesSidebarCarousel();
    let $main = $('#main');

    if (iqitTheme.pp_tabs == 'tabha') {
        getAccordion("#product-infos-tabs", 576);
    }



    $('body').on('click', '[data-button-action="add-to-cart"]', (event) => {
            event.preventDefault();
            $(event.target).addClass('processing-add');
        }
    );

    prestashop.on('updateCart', function (event) {
        $('.add-to-cart.processing-add').removeClass('processing-add');
    });

    prestashop.on('updateProduct', function (event) {
        if (typeof prestashop.page.page_name !== 'undefined') {

            if (prestashop.page.page_name == 'product'){
                $main.addClass('-combinations-loading');
            }
        }
    });

    prestashop.on('updatedProduct', function (event) {
        createInputFile();
        createToolTip();
        imageScrollBox();
        coverImage();


        if (event && event.product_minimal_quantity) {
            const minimalProductQuantity = parseInt(event.product_minimal_quantity, 10);
            const quantityInputSelector = '#quantity_wanted';
            let quantityInput = $(quantityInputSelector);

            quantityInput.trigger('touchspin.updatesettings', {min: minimalProductQuantity});
        }


        if (iqitTheme.pp_image_layout == 'column') {
            prestashop.iqitLazyLoad.update();
        }

        $($('.tabs .nav-link.active').attr('href')).addClass('active').removeClass('fade');
        $('.js-product-images-modal').replaceWith(event.product_images_modal);
        $main.removeClass('-combinations-loading');


    });


    function coverImage() {
        if ($('.modal.quickview').length){
            new Swiper('#product-images-large', {
                loop: false,
                effect: 'fade',
                preloadImages: false,
                lazy: {
                    loadPrevNext: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }
            });
        }else{
            if (coverSwiper !== undefined ) {
                coverSwiper.destroy();
            }
            if(iqitTheme.pp_image_layout == 'column'){
                const breakpoint = window.matchMedia( '(min-width:768px)' );
                const breakpointChecker = function() {
                    if ( breakpoint.matches === true ) {
                        if ( coverSwiper !== undefined ) {
                            coverSwiper.destroy();
                        }
                    } else if ( breakpoint.matches === false ) {
                        return enableSwiperOnColumn();
                    }
                };

                const enableSwiperOnColumn = function() {
                    coverSwiper = new Swiper('#product-images-large', {
                        loop: false,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        preloadImages: false,
                        lazy: {
                            loadPrevNext: true,
                        },
                        pagination: {
                            el: '.swiper-pagination-product',
                            clickable: true,
                        },
                    });
                };

                breakpoint.addEventListener('change', () => {
                    breakpointChecker();
                });
                breakpointChecker();
            }
            if (iqitTheme.pp_image_layout == 'carousel') {
                let thumbs;
                if ($('#product-images-thumbs').length) {
                    thumbs = {
                             swiper: thumbsSwiper,
                             autoScrollOffset: 1
                    }
                }
                coverSwiper = new Swiper('#product-images-large', {
                    loop: false,
                    effect: 'fade',
                    preloadImages: false,
                    lazy: {
                        loadPrevNext: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    thumbs
                });
            }
        }

        if (iqitTheme.pp_zoom == 'inner') {
            let $easyzoom = $('.easyzoom-product').easyZoom();
        } else if (iqitTheme.pp_zoom == 'modalzoom') {
            $('.js-easyzoom-trigger').on('click', (event) => {
                event.preventDefault();
            });
        }
    }

    function imageScrollBox() {
        if (iqitTheme.pp_image_layout == 'column' || $('.modal.quickview').length) {
            return;
        }
        if (thumbsSwiper !== undefined) {
            thumbsSwiper.destroy();
        }
        let direction = 'horizontal';
        let slides = 5;
        let breakpoints;
        let $thumbs = $('#product-images-thumbs');

        if (iqitTheme.pp_thumbs == 'left') {
            direction = 'vertical';
        }
        if (iqitTheme.pp_thumbs == 'leftd') {
            breakpoints = {
                768: {
                    direction: 'vertical',
                },
            }
        }
        if ($thumbs.length) {
            let defaultOptions = {
                loop: false,
                direction: direction,
                slidesPerView: slides,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                preloadImages: false,
                lazy: {
                    loadPrevNext: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints
            };

            let swiperOptions = $.extend({}, defaultOptions, $thumbs.data('swiper_options'));
            thumbsSwiper = new Swiper($thumbs[0], swiperOptions);
        }
    }

    function createInputFile() {
        let $input = $('.js-file-input');
        $input.filestyle({buttonText: $input.data('buttontext')});
        $input.on('change', (event) => {
            let target, file;

            if ((target = $(event.currentTarget)[0]) && (file = target.files[0])) {
                $(target).prev().text(file.name);
            }
        });
    }

    function createToolTip() {
        if(!('ontouchstart' in document.documentElement)) {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        }
    }

    function createProductSpin()
    {
        const $quantityInput = $('#quantity_wanted');

        $quantityInput.TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'fa fa-angle-up touchspin-up',
            verticaldownclass: 'fa fa-angle-down touchspin-down',
            buttondown_class: 'btn btn-touchspin js-touchspin',
            buttonup_class: 'btn btn-touchspin js-touchspin',
            min: parseInt($quantityInput.attr('min'), 10),
            max: 1000000
        });

        $('body').on('input touchspin.on.stopspin', '#quantity_wanted', (e) => {
            //$(e.currentTarget).trigger('touchspin.stopspin');
            prestashop.emit('updateProduct', {
                eventType: 'updatedProductQuantity',
                event: e
            });
        });
    }


    function accessoriesSidebarCarousel() {

        let autoplay;
        if(iqitTheme.pl_crsl_autoplay){
            autoplay = {
                delay: 4500,
                disableOnInteraction: true,
            };
        }
        let accessoriesSidebarCarousel = new Swiper('#product-accessories-sidebar', {
            pagination: {
                el: '.swiper-pagination-product',
                clickable: true,
            },
            autoplay,
            loop: false,
            speed: 600,
            watchOverflow: true,
            slidesPerView: 1,
            slidesPerColumn: 5,
            slidesPerColumnFill: 'row'
        });
    }

    function getAccordion($element_id, screen)
    {

        if ($(window).width() < screen)
        {
            let obj_tabs, obj_cont, $tabs_content;

            var concat = '';
            obj_tabs = $( $element_id + ' li').toArray();
            $tabs_content = $('#product-infos-tabs-content');
            obj_cont = $tabs_content.find('.tab-pane').toArray();

            concat = '<div class="card">';
            jQuery.each( obj_tabs, function( n, val )
            {
                concat += '<div class="nav-tabs" role="tab" >';
                if(n > 0) {
                    concat += '<a class="nav-link collapsed" id="ma-nav-link-' + n + '" data-toggle="collapse" data-parent="#product-infos-accordion-mobile" href="#product-infos-accordion-mobile-' + n + '">';
                } else {
                    concat += '<a class="nav-link" id="ma-nav-link-' + n + '" data-toggle="collapse" data-parent="#product-infos-accordion-mobile" href="#product-infos-accordion-mobile-' + n + '">';
                }

                concat += val.innerText + '' +
                    '<i class="fa fa-angle-down float-right angle-down" aria-hidden="true"></i><i class="fa fa-angle-up float-right angle-up" aria-hidden="true"></i>' +
                    '</a>';

                concat += '</div>';

                if(n > 0) {
                    concat += '<div id="product-infos-accordion-mobile-' + n + '" class="collapse tab-content" role="tabpanel">';
                } else {
                    concat += '<div id="product-infos-accordion-mobile-' + n + '" class="collapse tab-content show" role="tabpanel">';
                }
                concat += '<div id="ma-'+ obj_cont[n].id +'" class=""></div>';
                concat += '</div>';
            });
            concat += '</div></div>';
            let $accordion = $("#product-infos-accordion-mobile");
            $accordion.html(concat);

            jQuery.each( obj_tabs, function( n, val )
            {
                $(obj_cont[n]).appendTo( '#ma-'+ obj_cont[n].id  );
            });


            prestashop.iqitLazyLoad.update();
            $($element_id).remove();
            $tabs_content.remove();

        }
    }
});



