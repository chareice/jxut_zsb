{if $section neq 'info'}</section>
				<section id="message-page-container">
				<aside id="message-page" {if $section=="index"||$section=="message"}style="margin-top:1em;"{/if}>
					 {if $messages|@count > 0}
						<div id="messages" class="box">
                    {if $messages|@count == 1}
                        <strong>新闻信息：<br/></strong>
                        {$messages.0|escape}
                    {else}
                        <strong>新闻信息：<br/></strong>
                        <ul>
                            {foreach from=$messages item=row}
                                <li>{$row|escape}</li>
                            {/foreach}
                        </ul>
                    {/if}
				</div>
            {else}
                <div id="messages" class="box" style="display:none"></div>
            {/if}
				{if $authenticated}
				   欢迎：<span>{$identity->realname}</span><br/>
					{if $identity->user_type=='administrator'}
						<ul>
							<li><a href="/news/add">添加新闻</a></li>
							<li><a href="/admin/">管理后台</a></li>
							<li><a href="/admin/adduser">添加用户</a></li>
							<li><a href="/admin/usermanage">修改用户信息</a></li>
							<li><a href="/admin/infoedit">修改速查主页信息</a></li>
							<li><a href="/admin/addinfo">添加底部面板查询</a></li>
							<li><a href="/filemange/index.php">上传文件</a></li>
						</ul>
					{/if}
				{/if}
				</aside>
			</section>
			</article>
			<section class="clearfix"></section>
		</section>
{/if}
<div style="right: 10px; display:none;" class="back-to" id="toolBackTo">
<a onclick="abc()" href="#center" class="backtotop">返回顶部
<img class="back-tip" alt="返回顶部" src="/image/back-tip.png"/>
</a>
</div>
<!--底部面板开始-->
<div id="bottombar">
	<div id="webpager" class="webpager" style="height:30px;">
					<div class="info-container" id="tb-container" style="z-index:20000">
						<table class="info">
						<div class="close" onclick="$(this).closest('.info-container').slideUp(500);" style="position:absolute;left:0px;bottom:0px;width:48px;float:left;"><img width="12" src="/image/close48.png"/></div>
						<tr>
							<td class="infot">就不告诉你</td>
							<td class="infoc">就不告诉你</td>
						</tr>
					</table></div>   
		<div id="apps-panel" class="panel">
			{foreach from=$bottomlefts item=bottomleft}
			<div class="popupwindow " style="z-index: 1001;">
				<div class="panelbarbutton">
					<strong>{$bottomleft.name}</strong>
				</div>
				<article class="window">
					{$bottomleft.content}
				</article>	
			</div>
			{/foreach}
		</div>
		<div id="jump-panel" class="panel">
			{foreach from=$bottomrights item=bottomright}
			<div class="popupwindow">
				<div class="jpanelbarbutton">
					<a href="{$bottomright.url}" target="_blank"><strong>{$bottomright.content}</strong></a>
				</div>
			</div>
			{/foreach}
			{if $authenticated}
			<!-- <div class="popupwindow note">
				<div class="jpanelbarbutton notesbar">
					<strong>我的收藏</strong>
				</div>
				<article class="window mynotes">
					
					<input type="hidden" id="note_status" value="0"/>
					<div id="note_add"><button class="add" disabled="disabled">新增一条记录(建设中。。。)</button></div>
					<div id="note_preview">标题</div>
					<div id="note_main">内容</div>
					<div id="add_dialog" style="display:none;position:absolute;top:30%;left:30%;">
						<label for="note_title_add">添加标题</label><input id="note_title_add" type="text"/><br/>
						<label for="note_content_add">内容</label><textarea id="note_content_add"></textarea>
						<button type="submit">提交</button>
					</div>
				</article>
			</div> -->
			{/if}
			<div class="popupwindow">
				<div class="jpanelbarbutton">
					<a href="/file" target="_blank"><strong>文件共享</strong></a>
				</div>
			</div>
			<div class="popupwindow">
				<div id="auth">
				<table class="auth">
					<tr>
						<td>Technical Support</td>
					</tr>
					<tr>
						<td>&copy;Chareice</td>
					</tr>		
				</table>
			</div>
		</div>	
		<section class="panel_msg">
		</section>
		<div id="alert" style="display:none;z-index:20001;"></div>
</div>
</div>
</div>
</article>
</body>
</html>