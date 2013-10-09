{include file='header.tpl'}

{if $search.performed}
    {if $search.total == 0}
        <center><p style="font-size:20px;padding:1em;">这里没有你要找的东西╮(╯▽╰)╭</p><p><a href="/" style="text-decoration:none;">返回主页</a></p></center>
        <div>
        <hr/>
        <p id="author-information"><center>Technical Support &copy;Chareice</center></p>
        </div>
    {else}
        <p>
            显示结果：{$search.start}-{$search.finish} 总共： {$search.total}
        </p>
        <div style="background:#fff;padding:1em;border-radius:5px;">
        {foreach from=$search.results item=news}
            [{$news->ts_created|date_format:'%m-%d'}]</span><a href="{geturl controller="news" action='preview'}?id={$news->getId()}" >{$news->profile->title}</a><br/><hr/>
        {/foreach}

        <div class="pager">
            {section loop=$search.pages name=page}
                {assign var=p value=$smarty.section.page.index_next}
                {if $p == $search.page}
                    <strong>{$p}</strong>
                {else}
                    <a href="{geturl controller='search'}?q={$q|escape}&amp;p={$p}"
                        >{$p}</a>
                {/if}
            {/section}
        </div></div>
    {/if}
{else}
<center><p style="font-size:20px;padding:1em;">未能获取到请求内容，请确认是否填写搜索框</p><p><a href="/" style="text-decoration:none;">返回主页</a></p></center>
<div>
<hr/>
<p id="author-information"><center>Technical Support &copy;Chareice</center></p>
</div>
{/if}

{include file='footer.tpl'}