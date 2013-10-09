{include file='header.tpl' section='news'}
{if $news|@count ==0}
	未授权查看此页
{else}
{if $identity->user_type=="administrator"}
<script type="text/javascript" src="/js/scripts.js"></script>
<form method="post"
      action="{geturl controller='news' action='setstatus'}"
      id="status-form">
<div class="preview-status">
    <input type="hidden" name="id" value="{$news->getId()}" />
    {if $news->isLive()}
        <div class="status live">
            新闻已经发布，下线请点击<strong>撤下新闻</strong> 按钮。
            <div>
                <input type="submit" value="撤下新闻"
                       name="unpublish" id="status-unpublish" />
                <input type="submit" value="修改新闻"
                       name="edit" id="status-edit" />
                <input type="submit" value="删除新闻"
                       name="delete" id="status-delete" />
            </div>
        </div>
    {else}
        <div class="status draft">
            新闻还未发布，上线请点击 发布新闻 按钮。
            <div>
                <input type="submit" value="发布新闻"
                       name="publish" id="status-publish" />
                <input type="submit" value="修改新闻"
                       name="edit" id="status-edit" />
                <input type="submit" value="删除新闻"
                       name="delete" id="status-delete" />
            </div>
        </div>
    {/if}
</form>
<fieldset id="preview-tags">
    <legend>标签</legend>
    <ul class="tags-ul">
        {foreach from=$news->getTags() item=tag}
            <li>
                <form method="post" action="/news/tags">
                    <div>
                        <a href="/news/tag/{$tag|escape}">{$tag|escape}</a>
                        <input type="hidden" name="id" value="{$news->getId()}" />
                        <input type="hidden" name="tag" value="{$tag|escape}" />
                        <input type="submit" value="删除" name="delete" />
                    </div>
                </form>
            </li>
        {foreachelse}
            <li>未找到标签</li>
        {/foreach}
    </ul>

    <form method="post" action="{geturl action='tags'}">
        <div>
            <input type="hidden" name="id" value="{$news->getId()}" />
            <input type="text" name="tag" />
            <input type="submit" value="添加标签" name="add" />
        </div>
    </form>
</fieldset>
</div>
{else}
<ul class="tags-ul">
    {foreach from=$news->getTags() item=tag}
        <li><a href="/news/tag/{$tag|escape}">{$tag|escape}</a></li>
    {foreachelse}
         <li>未找到标签</li>
    {/foreach}
</ul>
{/if}
<article id="main_article">
<div class="preview-date">
    发布时间：{$news->ts_created|date_format:'%m-%d %H:%M:%S'}
	<!--最后修改：{$news->profile->editor_name}--> 
</div>

<div class="preview-content clearfix">
    {$news->profile->content}
</div>
</article>
{/if}
{include file='footer.tpl'}