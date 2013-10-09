{include file='header.tpl' section='news'}
{if $news|@count ==0}
没有找到带有标签&ldquo;{$tag}&rdquo;的文章~~~~(>_<)~~~~ 
{else}<div style="background:#fff;padding:1em;border-radius:5px;">
{foreach from=$news item=news}

<article class="show" {if !$news->isLive()&&($identity->user_type!="administrator")} style="display:none"{/if}>
		<input type="hidden" class="ts_created" value="{$news->ts_created}"/>
		<input type="hidden" class="ts_edit" value="{$news->profile->ts_edit}"/>
		<!--{$news->ts_created|date_format:'%Y-%m-%d %H:%M:%S'}<br/>
		修改时间：{$news->profile->ts_edit|date_format:'%Y-%m-%d %H:%M:%S'}-->
		<header><span>[{$news->ts_created|date_format:'%m-%d'}]</span><a href="{geturl action='preview'}?id={$news->getId()}" title="{$news->getTeaser(400)}" target="_blank">{$news->profile->title|escape}{if !$news->isLive()}<span class="status draft">(未发布)</span>{/if}</a></header>	
</article>

{/foreach}</div>
{/if}
{include file='footer.tpl'}
