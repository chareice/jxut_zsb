{include file='header.tpl' section='news'}
<div id="recommend" class="main1 clearfix">
<p>标签云：</p>
<ul class="tags-ul clearfix">
    {foreach from=$tags item=tag}
        <li><a href="/news/tag/{$tag|escape}">{$tag|escape}</a></li>
    {foreachelse}
         <li>未找到标签</li>
    {/foreach}
</ul>
<button class="check" style="display:none">就这么定了</button>
</div>
<section id="newsshow" class="main2">
{if $news|@count ==0}
没有文章，请管理员添加。
{else}
{foreach from=$news item=news}
<article class="show" {if !$news->isLive()&&($identity->user_type!="administrator")} style="display:none"{/if}>
		<input type="hidden" class="ts_created" value="{$news->ts_created}"/>
		<input type="hidden" class="ts_edit" value="{$news->profile->ts_edit}"/>
		<!--{$news->ts_created|date_format:'%Y-%m-%d %H:%M:%S'}<br/>
		修改时间：{$news->profile->ts_edit|date_format:'%Y-%m-%d %H:%M:%S'}-->
		<header><span class="date">[{$news->ts_created|date_format:'%m-%d'}]</span><a href="/news/preview?id={$news->getId()}" title="{$news->getTeaser(400)}">{$news->profile->title|escape}{if !$news->isLive()}<span class="status draft">(未发布)</span>{/if}</a></header>	
</article>
{/foreach}
<footer id="changepage">
	<span>
	{$pageid}/{$pagesum}
	{if $pageid==1}
		{if $pagesum!=1}
		<a href="?page={$pageid+1}">下一页</a>
		{/if}
	{else}
	{if $pageid==$pagesum}<a href="?page={$pageid-1}">上一页</a>
	{else}<a href="?page={$pageid-1}">上一页</a>|<a href="?page={$pageid+1}">下一页</a>
	{/if}
	{/if}
	</span>
	{if $pagesum!=1}
	<form class="gotopage" action="/news" method="get">
		<table>
		<tr><td><input type="text" name="page" size="4" required="required"/></td>
		<td><button type="submit">跳转</button></td></tr></table>
	</form>
	{/if}
</footer>
</section>
{/if}
{if $identity->user_type=='administrator'}
{literal}
<script>
	function sorted(){
		var result_sort = new Array();
		$(".tags-ul li").each(function(i,v){
			result_sort[$(this).text()] = i;
		});
		return result_sort;
	};
	$(function(){
		$(".tags-ul").sortable({
			revert:true,
			containment:$(".tags-ul"),
			stop:function(){
				$("#recommend .check").show();
			}
		});
		$("#recommend .check").click(function(){
			result = sorted();
			$.post("/news/tagsraink",{raink:toJson(result)},function(data){
				alert(data);
				$("#recommend .check").hide();
			});
		});
	});
</script>
{/literal}
{/if}
{include file='footer.tpl'}