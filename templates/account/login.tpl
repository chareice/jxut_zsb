{include file='header.tpl' section='login'}

<form id="login_form" method="post" action="/account/login">
<fieldset>
	<legend><span>用户登录</span></legend>
	<div class="row" id="form_username_container">
		<label for="form_username">用户名：</label>
		<input required="required" autofocus="autofocus" type="text" id="form_username" name="username" value="{$username|escape}" />
		{include file='lib/error.tpl' error=$errors.username}
	</div>
	
	<div class="row" id="form_password_container">
		<label for="form_password">密码：</label>
		<input required="required" type="password" id="form_password" name="password" value="" />
		{include file='lib/error.tpl' error=$errors.password}
	</div>	
	
	<div class="submit">
		<input type="submit" value="登陆" />
	</div>
</fieldset>
</form>

{include file='footer.tpl'}
