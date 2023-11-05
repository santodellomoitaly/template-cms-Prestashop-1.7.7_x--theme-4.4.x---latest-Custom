{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
<div class="elementor-brands">
{if $view == 'grid'}
    <div class="row">
        {foreach from=$brands item=brand name=brand_list}
            <div class="col-{$slidesToShow.mobile} col-md-{$slidesToShow.tablet} col-lg-{$slidesToShow.desktop} col-xl-{$slidesToShow.desktop}">
                <a href="{$brand['link']}">
                    <img src="{$brand['image']}" alt="{$brand['name']}"
                         width="{$urls.no_picture_image.bySize.$imageFormat.width}"
                         height="{$urls.no_picture_image.bySize.$imageFormat.height}"
                    />
                </a>
            </div>
        {/foreach}
    </div>
    {else}
    <div class="elementor-brands-carousel-wrapper swiper-overflow swiper-arrows-{$arrows_position}"  >
        <div class="swiper-container elementor-brands-carousel {$cls_fix_classes}" data-slider_options='{$options|@json_encode nofilter}'>
        <div class="swiper-wrapper">
        {foreach from=$brands item=brand name=brand_list}
            <div class="swiper-slide">
                <a href="{$brand['link']}">
                    <img
                         src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {$urls.no_picture_image.bySize.$imageFormat.width} {$urls.no_picture_image.bySize.$imageFormat.height}'%3E%3C/svg%3E"
                         data-src="{$brand['image']}"
                         alt="{$brand['name']}"
                         width="{$urls.no_picture_image.bySize.$imageFormat.width}"
                         height="{$urls.no_picture_image.bySize.$imageFormat.height}"
                         class="swiper-lazy"
                    />
                </a>
            </div>
        {/foreach}
        </div>
            {if $options.dots}
                <div class="swiper-pagination elementor-swiper-pagination swiper-dots-outside"></div>
            {/if}
        </div>
            {if $options.arrows}
                <div class="swiper-button-prev swiper-button elementor-swiper-button elementor-swiper-button-prev"></div>
                <div class="swiper-button-next swiper-button elementor-swiper-button elementor-swiper-button-next"></div>
            {/if}
    </div>
{/if}
</div>









