<!--
         ©2011-2014                                       
    Provide By Chareice.
     All right resived.
    http://chareice.com                             
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>{if $section!='index'}{$title}—{/if}江西科技学院呼叫中心{if $section=='index'} Jiangxi University of Technology Call Center{/if}</title>
        <link rel="stylesheet" type="text/css" href="/style/night.css"/>
		<link href="/image/favicon.ico" rel="shortcut icon" />
		<script type="text/javascript" src="/js/jquery/jquery.js"></script>
		<script type="text/javascript" src="/js/heartcode.js"></script>
		<script type="text/javascript" src="/js/init.js"></script>
		{if $identity->user_type=='administrator'}
<script type="text/javascript" src="/js/ueditor/editor_config.js"></script>
<script type="text/javascript" src="/js/ueditor/editor_all_min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/ueditor/themes/default/css/ueditor.css"/>
{/if}
		{if $authenticated}<script type="text/javascript">
		{literal}
		var timerArr;
		$(function() {
		{/literal}
		{if $section=="message"}
		title=true;
		{else}
		title=false;
		{/if}
		{literal}
		getnew(title);
		});		
		</script>
		{/literal}
		{/if}
		<link rel="stylesheet" type="text/css" href="/style/jui.css"/>
		<script  src="/js/jquery/jui.js"></script>
    </head>
    <body>
<article id="center">
    <header id="main-header">
            <div id="top-nav-container" class="clearfix">
				<nav id="nav">
                    <ul class="nav">
                        <li {if $section=='index'}class="active-trail"{/if}><a href="/" class="clearfix"><img alt="主页" class="logo" src="/image/logo220.png"/></a></li>
                        {foreach from=$headers item=header}
						<li><a href="{$header.url}">{$header.content}</a></li>
						{/foreach}
                        <li class="liserach"><div id="serach-nav">
								<form action="/search" method="get">
								<div id="search-input">
									<input id="search" placeholder="搜索" type="text" value="" name="q" accesskey="/" maxlength="100" size="25" style="color: rgb(136, 136, 136);" autocomplete="off"/>
								</div>
								</form>
							</div><div class="arrow_box" style="display:none"><p>按下回车开始搜索</p></div></li>
                        
						 {if $authenticated}
						<li id="message-notice"{if $section=='message'} class="active-trail"{/if}><a href="#">消息</a><span id="notic"></span></li>
                        <li id="logout"><a href="/account/logout">登出</a></li>
						{else}
							<li {if $section=='login'}class="active-trail login"{else} class="login" {/if}>
							<a class="login" href="#">登录</a>
							<form id="login" class="tip-bubble tip-bubble-top" method="post" action="/account/login">
								<ul>
									<li>
										<input required="required" name="username" type="text" placeholder="账号"/>
									</li>
									<li>
										<input required="required" name="password" type="password" placeholder="密码"/>
									</li>
									<li>
										<button type="submit">登 录</button>
									</li>
						{/if}
								</ul>
							</form>
						</li>
                    </ul>
				</nav>
             </div>
    </header>
{if $section!="info"}<section id="page-container">
				<!--<header id="bread"{if $section=='index'||$section=='message'} style="display:none"{/if}><span id="bread-main">{breadcrumbs trail=$breadcrumbs->getTrail()}</span></header>-->
			<article id="page">
				<section id="main-page" {if $authenticated} style="float:left;margin-left:2%;"{/if}>{/if}
