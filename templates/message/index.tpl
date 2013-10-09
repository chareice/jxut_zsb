{include file='header.tpl' section='message'}
<script type="text/javascript" async="async" src="/js/test.js"></script>
<div id="message-box">
<ul>
	<li><a href="#in-message">收件箱<span class="getin"><img alt="刷新" src="/image/refresh.png" title="点我获取新消息"/></span></a></li>
	<li><a href="#out-message">发件箱<span class="getout"><img alt="刷新" src="/image/refresh.png" title="点我刷新数据"/></span></a></li>
	<li><a href="#send-message">写信息</a></li>
	<li><a href="#user-change">修改密码</a></li>
</ul>
<div id="in-message">
加载中......
<!--/*{*{foreach from=$message item=message}
		<div class="amsg  clearfix">
		{foreach from=$message key=k item=m}
		{if $k=='msg_to_id'}<div class="msg_info"><input class="msg_to_id" type="hidden" value="{$m}" />{/if}
		{if $k=='realname'}<span class="from">{$m}：</span>{/if}
		{if $k=='msg_status'}{if $m=='N'}<input type="button" value="置为已读"/>{/if}{/if}
		{if $k=='msg_created'}<span class="time">{$m|date_format:'%m-%d %H:%M:%S'}</span></div>{/if}
		{if $k=='message'}<div class="content">{$m}</div>{/if}
		{/foreach}
		<span class="replay">&lt;回复</span>
		</div>
{/foreach}
<footer id="changepage" class="clearfix">
	{$pageid}/{$pagesum}
	{if $pageid==1}<a href="?page={$pageid+1}">下一页</a>
	{else}
	{if $pageid==$pagesum}<a href="?page={$pageid-1}">上一页</a>
	{else}<a href="?page={$pageid-1}">上一页</a>|<a href="?page={$pageid+1}">下一页</a>
	{/if}
	{/if}
	<form class="gotopage" action="/message" method="get">
		<input type="text" name="page" size="2"/>
		<input type="submit" value="跳转"/>
	</form>
</footer>*/同步获取数据方法*}-->
</div>
<div id="out-message">
	点击对应标签上的<img alt="刷新" src="/image/refresh.png"/>刷新数据
	<p id="send_to"> </p>
	<p id="content"> </p>
</div>
<section id="send-message">
{if $users|@count ==0}
当前无用户在线
{else}
用户：<ul>
{foreach from=$users item=user}
	<li><input type="checkbox" name="user_id" value="{$user->getId()}"/>{$user->realname}</li>
{/foreach}
</ul>
{/if}
	<textarea name="message" class="message"></textarea>
	<input id="send" type="button" value="发送"/>
</section>
<section id="user-change">
{include file='account/mine.tpl'}
</section>
</div>
<div id="comment" title="回复消息" style="display:none;">
<textarea class="replay"></textarea>
</div>
<div id="view-status" title="详细" style="display:none;">

</div>
{include file='footer.tpl' section='message'}