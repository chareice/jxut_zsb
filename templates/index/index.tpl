{include file='header.tpl' section='index'}

<section id="today" class="main1" {if $today|@count ==0} style="background:#E6E6E6"{/if}>
	<p>今日更新</p>
	{if $today|@count ==0}
	<!--<div class="none" style="color:red">样式表重要改动，请在页面中右键单击后选择重新载入刷新浏览器缓存。[7-31]</div>-->
	{else}
	{foreach from=$today item=news}
	<div class="show" {if !$news->isLive()&&($identity->user_type!="administrator")} style="display:none"{/if}>
		<input type="hidden" class="ts_created" value="{$news->ts_created}"/>
		<input type="hidden" class="ts_edit" value="{$news->profile->ts_edit}"/>
		<!--{$news->ts_created|date_format:'%Y-%m-%d %H:%M:%S'}<br/>
		修改时间：{$news->profile->ts_edit|date_format:'%Y-%m-%d %H:%M:%S'}-->
		<div class="header">· <span class="date">[{$news->ts_created|date_format:'%m-%d'}]</span><a href="/news/preview?id={$news->getId()}" title="{$news->getTeaser(200)}">{$news->profile->title|escape}{if !$news->isLive()}<span class="status draft">(未发布)</span>{/if}</a></div>		
	</div>
{/foreach}
{/if}
</section>
<section id="thisweek" class="main2" {if $thisweek|@count ==0} style="background:#E6E6E6"{/if}>
	<p>七日内更新</p>
	{foreach from=$thisweek item=news}
	<div class="show" {if !$news->isLive()&&($identity->user_type!="administrator")} style="display:none"{/if}>
		<input type="hidden" class="ts_created" value="{$news->ts_created}"/>
		<input type="hidden" class="ts_edit" value="{$news->profile->ts_edit}"/>
		<!--{$news->ts_created|date_format:'%Y-%m-%d %H:%M:%S'}<br/>
		修改时间：{$news->profile->ts_edit|date_format:'%Y-%m-%d %H:%M:%S'}-->
		<div class="header">· <span class="date">[{$news->ts_created|date_format:'%m-%d'}]</span><a href="/news/preview/?id={$news->getId()}" title="{$news->getTeaser(200)}">{$news->profile->title|escape}{if !$news->isLive()}<span class="status draft">(未发布)</span>{/if}</a></div>		
	</div>
{/foreach}
</section>

{include file='footer.tpl' section="index"}