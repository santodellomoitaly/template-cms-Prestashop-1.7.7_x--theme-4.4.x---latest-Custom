{*
* 2007-2014 PrestaShop
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
*  @copyright  2007-2014 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}
{extends file='page.tpl'}


{block name='head_og_tags'}
	{if isset($post->meta_title) && $post->meta_title != ''}
		<meta property="og:title" content="{$post->meta_title}">
	{else}
		<meta property="og:title" content="{$post->title} - {$page.meta.description}">
	{/if}
	<meta property="og:url" content="{$post_url|escape:'html':'UTF-8'}" />
	<meta property="og:site_name" content="{$shop.name}"/>
	<meta property="og:type" content="article"/>

	{if isset($post->banner_thumb) && $post->banner_thumb}
		<meta property="og:image" content="https://{$smarty.server.HTTP_HOST}{$post->banner_thumb|escape:'html':'UTF-8'}" />
	{else}
		{if isset($iqitTheme.sm_og_logo) == 1 && $iqitTheme.sm_og_logo != ''}
			<meta property="og:image" content="https://{$smarty.server.HTTP_HOST}{$iqitTheme.sm_og_logo }" />
		{else}
			<meta property="og:image" content="https://{$smarty.server.HTTP_HOST}{$shop.logo}" />
		{/if}
	{/if}

	{if isset($post->meta_description) && $post->meta_description != ''}
		<meta property="og:description" content="{$post->meta_description}">
	{else}
		<meta property="og:description" content="{$page.meta.description}">
	{/if}

	<meta property="fb:admins" content="{Configuration::get('PH_BLOG_FACEBOOK_MODERATOR')|intval}"/>
	<meta property="fb:app_id" content="{Configuration::get('PH_BLOG_FACEBOOK_APP_ID')|intval}"/>
{/block}


{block name='page_title'}
	{$post->title}
{/block}

{block name='hook_after_body_opening_tag' append}{strip}
    {if Configuration::get('PH_BLOG_FB_INIT')}
        <div id="fb-root"></div>
        <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/{$language.locale|replace:'-':'_'}/sdk.js#xfbml=1&version=v3.2&appId=&autoLogAppEvents=1';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    {/if}
{/strip}{/block}

{block name='head_seo' prepend}
<link rel="canonical" href="{$post->url}">
{/block}


{block name='head_hreflang'}
 {foreach from=$alternativePostLangsUrls item=pageUrl key=code}
      <link rel="alternate" href="{$pageUrl}" hreflang="{$code}">
    {/foreach}
{/block}

{block name='head_seo_title'}{strip}
	{if !empty($post->meta_title)}
		{$post->meta_title} - {$page.meta.title}
	{else}
		{$post->title} - {$page.meta.title}
	{/if}
{/strip}{/block}

{if !empty($post->meta_description)}
    {block name='head_seo_description'}{$post->meta_description}{/block}
{/if}

{if !empty($post->meta_keywords)}
	{block name='head_seo_keywords'}{$post->meta_keywords}{/block}
{/if}

{block name='page_content'}
{assign var='post_type' value=$post->post_type}
<div class="simpleblog__postInfo text-muted">
    <ul>
    	{if Configuration::get('PH_BLOG_DISPLAY_DATE')}
        <li>
			<i class="fa fa-calendar"></i>
        	<span>
        		<time>
        			{$post->date_add|date_format:Configuration::get('PH_BLOG_DATEFORMAT')}
        		</time>
        	</span>
        </li>
        {/if}
        {if isset($post->author) && !empty($post->author) && Configuration::get('PH_BLOG_DISPLAY_AUTHOR')}
        <li>
			<i class="fa fa-user"></i>
			<span>
	        	{$post->author}
	        </span>
        </li>
        {/if}
        {if Configuration::get('PH_BLOG_DISPLAY_CATEGORY')}
        <li>
			<i class="fa fa-tags"></i>
        	<span>
	        	<a
	        		href="{$link->getModuleLink('ph_simpleblog', 'category', ['sb_category' => $post->category_rewrite])}"
	        		title="{$post->category}"
	        	>
	        		{$post->category}
	        	</a>
	        </span>

        </li>
        {/if}
        {if Configuration::get('PH_BLOG_DISPLAY_LIKES')}
        <li>
        	<a href="#" data-guest="{$guest}" data-post="{$post->id_simpleblog_post}" class="simpleblog-like-button">
				<i class="fa fa-heart"></i>
				<span class="likes-count">
	        		{$post->likes}
	        	</span>
	        	<span>
		        	{l s='likes'  mod='ph_simpleblog'}
		        </span>
	        </a>
        </li>
        {/if}
        {if Configuration::get('PH_BLOG_DISPLAY_VIEWS')}
        <li>
			<i class="fa fa-eye"></i>
        	<span>
	        	{$post->views} {l s='views'  mod='ph_simpleblog'}
	        </span>
        </li>
        {/if}
        {if $allow_comments eq true && Configuration::get('PH_BLOG_COMMENTS_SYSTEM') == 'native'}
        <li>
			<i class="fa fa-comments"></i>
        	<span>
        		<a href="{$post->url}#phsimpleblog_comments">{$post->comments} {l s='comments'  mod='ph_simpleblog'}</a>
        	</span>
        </li>
        {/if}



		{if $post->tags && Configuration::get('PH_BLOG_DISPLAY_TAGS') && isset($post->tags_list)}
		<li><i class="fa fa-tags"></i>
			<span class="post-tags clear">
				{l s='Tags:' mod='ph_simpleblog'}
				{foreach from=$post->tags_list item=tag name='tagsLoop'}
					{$tag|escape:'html':'UTF-8'}{if !$smarty.foreach.tagsLoop.last}, {/if}
				{/foreach}
				</span>
		</li>
		{/if}


    </ul>
</div>
<div class="simpleblog__post">
	{if $post->featured_image}
		<a href="{$post->featured_image}" title="{$post->title}" class="fancybox simpleblog__post-featured">
			<img src="{$post->featured_image}" alt="{$post->title}" class="img-fluid" />
		</a>
	{/if}
    <div class="simpleblog__post__content">
		{block name='hook_blog_elementor'}
			{hook h='displayBlogElementor'}
		{/block}

    </div>
    <div class="simpleblog__post__after-content" id="displayPrestaHomeBlogAfterPostContent">
		{hook h='displayPrestaHomeBlogAfterPostContent'}
	</div><!-- #displayPrestaHomeBlogAfterPostContent -->


	<div class="row mt-5 align-items-center">
		{if Configuration::get('PH_BLOG_DISPLAY_SHARER')}
			<div class="col">
			<div class="simpleblog__share">
				<ul>
					<li>
						<a
								data-type="twitter"
								href="#"
								class="btn btn-twitter"
						>
							<i class="fa fa-twitter"></i> Twitter
						</a>
					</li>
					<li>
						<a
								data-type="facebook"
								href="#"
								class="btn btn-facebook"
						>
							<i class="fa fa-facebook"></i> Facebook
						</a>
					</li>
					<li>
						<a
								data-type="pinterest"
								href="#"
								class="btn btn-pinterest"
						>
							<i class="fa fa-pinterest"></i> Pinterest
						</a>
					</li>
					{hook h='displayBlogForPrestaShopSocialSharing'}
				</ul>
			</div>
			</div>{/if}


		<div class="col">
			<ul class="pagination pagination-lg mt-0 justify-content-end">
				{if $previousPost}
					<li class="page-item">
						<a class="page-link" href="{$previousPost.url}" tabindex="-1"><i class="fa fa-angle-left"
																						 aria-hidden="true"></i> {l s='Previous article' mod='ph_simpleblog'}
						</a>
					</li>
				{/if}
				<li class="page-item"><a class="page-link"
										 href="{$link->getModuleLink('ph_simpleblog', 'list')}">{l s='Main page' mod='ph_simpleblog'}</a>
				</li>
				{if $nextPost}
					<li class="page-item">
						<a class="page-link" href="{$nextPost.url}">{l s='Next article' mod='ph_simpleblog'} <i
									class="fa fa-angle-right" aria-hidden="true"></i></a>
					</li>
				{/if}
			</ul>
		</div>
	</div>


</div>


{if Configuration::get('PH_BLOG_DISPLAY_RELATED') && $related_products}
	{include file="module:ph_simpleblog/views/templates/front/1.7/_partials/post-single-related-products.tpl"}
{/if}

{if $allow_comments eq true && Configuration::get('PH_BLOG_COMMENTS_SYSTEM') == 'native'}
	{include file="module:ph_simpleblog/views/templates/front/1.7/comments/layout.tpl"}
{/if}

{if $allow_comments eq true && Configuration::get('PH_BLOG_COMMENTS_SYSTEM') == 'facebook'}
	{include file="module:ph_simpleblog/views/templates/front/1.7/comments/facebook.tpl"}
{/if}

{if $allow_comments eq true && Configuration::get('PH_BLOG_COMMENTS_SYSTEM') == 'disqus'}
	{include file="module:ph_simpleblog/views/templates/front/1.7/comments/disqus.tpl"}
{/if}

<script type="application/ld+json">
{$jsonld nofilter}
</script>
{/block}