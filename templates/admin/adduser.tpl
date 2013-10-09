{include file='header.tpl' section="admin"}

<form method="post" action="/admin/adduser">
<fieldset>
	<input type="hidden" name="redirect" value="{$redirect|escape}" />
	<legend>添加用户</legend>
	<div class="row" id="form_username_container">
		<label for="form_username">用户名：</label>
		<input type="text" id="form_ussername" name="username" value="{$username|escape}" />
		{include file='lib/error.tpl' error=$errors.username}
	</div>
	
	<div class="row" id="form_password_container">
		<label for="form_password">密码：</label>
		<input type="password" id="form_password" name="password" value="" />
		{include file='lib/error.tpl' error=$errors.username}
	</div>	
	<div class="row" id="form_realname_container">
		<label for="form_realname">真实姓名：</label>
		<input type="text" id="form_password" name="realname" value="" />
		{include file='lib/error.tpl' error=$errors.username}
	</div>	
		<div class="row" id="form_auth_container">
		<label for="form_auth_select">用户类型:</label>
		<select id="form_auth_select" name="authselect" value="member">
			<option value="member">用户</option>
			<option value="administrator">管理员</option>
		</select>
		{include file='lib/error.tpl' error=$errors.username}
	</div>	
		<div class="submit">
		<input type="submit" value="提交" />
	</div>
	</fieldset>
</form>
{include file='footer.tpl'}
