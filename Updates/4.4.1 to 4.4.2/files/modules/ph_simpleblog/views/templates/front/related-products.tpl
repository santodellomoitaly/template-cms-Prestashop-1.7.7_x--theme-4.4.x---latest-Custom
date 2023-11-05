<div class="block-section simpleblog-related-products">
	<h4 class="section-title"><span>{l s='Related products' mod='ph_simpleblog'}</span></h4>

	<div class="block-content swiper-container-wrapper">
		<div class="products products-grid swiper-container swiper-default-carousel">
			<div class="swiper-wrapper">
				{foreach from=$related_products item="product"}
					<div class="swiper-slide"> {include file="catalog/_partials/miniatures/product.tpl" product=$product carousel=true}</div>
				{/foreach}
			</div>
			<div class="swiper-pagination swiper-pagination-product"></div>
			<div class="swiper-button-prev"></div>
			<div class="swiper-button-next"></div>
		</div>
	</div>
</div><!-- .simpleblog-related-products -->




