{include file='header.tpl' section='admin'}
<script type="text/javascript" src="/js/ajax.js"></script>
<table id="users" border='1'>
	<thead>
		<th class="hidden">ID</th>
		<th>用户名</th>
		<th>姓名</th>
		<th>电话</th>
		<th>最后登录</th>
	</thead>
	<tbody>
{foreach from=$users item=user}
	<tr>
		<td class="hidden user_id">{$user->getId()}</td>
		<td class="username">{$user->username}</td>
		<td class="canedit realname">{$user->realname}</td>
		<td>{$user->tel}</td>
		<td>{$user->ts_last_login|date_format:'%Y-%m-%d %H:%M:%S'}</td>
	</tr>
{/foreach}
	</tbody>
</table>
{include file='footer.tpl'}
