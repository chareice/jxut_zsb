<form method="post" action="/message#user-change">
<fieldset>
	<legend>个人信息</legend>
	<input type="hidden" name="redirect" value="{$redirect|escape}">
	<div class="row" id="form_username_container">
		<label for="form_username">用户名：</label>
		<input type="text" id="form_username" name="username" disabled="disabled" value="{$identity->username|escape}" />
	</div>
	
	<div class="row" id="form_oldpasswd_container">
		<label for="form_oldpasswd">原始密码：</label>
		<input required="required" type="password" id="form_oldpasswd" name="oldpasswd"/>
		{include file='lib/error.tpl' error=$fp->getError('oldpasswd')}
	</div>
	
	<div class="row" id="form_password_container">
		<label for="password">新密码：</label>
		<input required="required" type="password" id="password" name="password" value="" />
		{include file='lib/error.tpl' error=$fp->getError('password')}
	</div>	
	<div class="row" id="form_password_confirm_container">
		<label for="password_confirm">确认新密码：</label>
		<input required="required" type="password" id="password_confirm" name="password_confirm" value="" />
		{include file='lib/error.tpl' error=$fp->getError('password_confirm')}
	</div>
	<div class="submit">
		<input type="submit" value="提交" />
	</div>
</fieldset>
</form>
