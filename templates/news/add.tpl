{include file='header.tpl' section='admin'}
<script type="text/javascript">
    editor = new baidu.editor.ui.Editor();
    editor.render('baidu_editor');
</script>
<form class="news" method="post" action="{geturl action=add}?id={$fp->news->getId()}">
	<div class="row">
		<label for="news_title">标题:</label>
			<input name="news_title" required="required" type="text" value="{$fp->news->profile->title}"/>
	</div>
	<div class="wysiwyg">
		正文：
        <textarea id="baidu_editor"class="ckeditor" name="news_content">{$fp->news->profile->content}</textarea>
	</div>


    {if $fp->news->isLive()}
        {assign var='label' value='保存更改'}
    {elseif $fp->news->isSaved()}
        {assign var='label' value='保存更改并发布'}
    {else}
        {assign var='label' value='生成并发布'}
    {/if}

    <input type="submit" class="preview" value="{$label|escape}" />
    {if !$fp->news->isLive()}
        <input type="submit" class="submit" name="preview" value="保存但不发布" />
    {/if}
</form>
{include file='footer.tpl'}