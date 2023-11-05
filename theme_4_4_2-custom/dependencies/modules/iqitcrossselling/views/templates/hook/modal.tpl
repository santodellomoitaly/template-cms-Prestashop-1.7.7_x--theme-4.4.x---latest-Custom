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

<section class="crossselling-products-modal">
  <p class="crossselling-products-modal-title">{l s='Customers who bought this product also bought:' d='Shop.Theme.Catalog'}</p>
  <div class="block-content swiper-container-wrapper">
    <div class="products products-grid swiper-container swiper-crossselling-products swiper-cls-fix desktop-swiper-cls-fix-5 swiper-cls-row-fix-1 tablet-swiper-cls-fix-3 mobile-swiper-cls-fix-2">
      <div class="swiper-wrapper">
        {foreach from=$products item="product"}
          <div class="swiper-slide"> {include file="catalog/_partials/miniatures/product.tpl" product=$product carousel=true}</div>
        {/foreach}
      </div>
      <div class="swiper-pagination swiper-pagination-product"></div>
    </div>
  </div>
</section>


