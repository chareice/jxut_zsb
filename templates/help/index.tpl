<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>帮助</title>
	<link rel="stylesheet" type="text/css" href="/style/help.css"/>
	<link href="/image/favicon.ico" rel="shortcut icon" />
	<script src="/js/jquery/jquery.js" type="text/javascript"></script>
	<script src="/js/help.js" type="text/javascript"></script>
</head>
<body>
	<div id="top"></div>
	<div id="aside"><p>帮助文档/*2012-2-20*/</p></div>
<div id="article">
<h3>系统介绍：</h3><p>系统一共分为三大部分，分别是</p>
<ol style="margin-left:3em;">
  <li>
    新闻系统
  </li>
<ul>
  <li>用户可在前台浏览由管理员在后台发布的文章，类似QQ空间的日志模块。</li>
</ul>
 <li>
    查询系统
  </li>
  <ul>
  <li>可根据用户发送的查询请求快速响应查询结果，提高工作效率。</li>
</ul>
  <li>
    消息系统
  </li>
  <ul>
  <li>用户登录后可相互发送消息，类似新浪微博的私信模块。</li>
</ul>
</ol>
<h3>技术信息：</h3>
<ul style="margin-left:3em;">
  <li>前台语言：HTML5、CSS3、Javascript（使用jQuery）</li>
  <li>后台语言：PHP（基于 Zend framework &amp; Smarty 构建的MVC模式）</li>
  <li>服务器系统架构：Ubuntu、MySQL、Apache</li>
</ul>
<h3 id="zysx">注意事项：</h3>
<p>不要更改未知的浏览器设置，不可关闭浏览器的Cookie存储和Javascript功能。不要尝试对服务器进行非法操作。</p>
<p>不登陆除消息系统不能使用外其余系统均可正常使用。如果要使用消息系统，则必须进行登录操作。</p>
<h3 id="dkxt">打开系统：</h3>
<p>在浏览器（<a href="#llq">关于浏览器，不得不说的</a>）中输入服务器IP地址：10.0.1.39即可对网站进行访问，主页布局如下图：</p>
<p><img src="/image/help/help1.png" alt="help1" /></p>
<h3 id="dlxt">登录系统：</h3>
<p>点击顶部导航的登录项跳转至登录页面，此时输入您的帐号、密码（<a  href="#wjmm" >忘记密码怎么办？</a>）可进行登录,成功登录后您将被重定向至主页，您可以注意到顶部导航已经出现了消息选项，表明您已经可以使用消息系统。</p>
<h3 id="xwxt">新闻系统：</h3>
<ol style="margin-left:3em;">
	<li>浏览新闻列表</li>
		<ul><li>在顶部导航中点击新闻进入新闻主页，新闻主页中会按照时间顺序分页列出系统中的所有文章。</li>
		<p><img src="/image/help/help2.png" alt="help2"/></p></ul>
	<li id="llwznn">浏览新闻内容</li>
		<ul><li>在列表中点击新闻标题，则跳转至对应新闻内容页面。</li>
		<p><img src="/image/help/help3.png" alt="help3"/></p>		
		</ul>
	<li>文章分类</li>
	<ul><li>所有的文章都是按照其含有的标签进行分类的，一篇文章含有的标签数不限，标签由管理员添加、删除（<a href="#bqgl">标签管理方法</a>），当您点击一个文章标签时，浏览器会打开一个新窗口并分页列出含有该标签的所有文章。</li></ul>
	<li>文章搜索</li>
	<ul><li>注意到在顶部导航最后的部分有搜索框，搜索框可按照文章标签对文章进行搜索（暂时仅支持对标签进行搜索，后期可能会增加对文章标题和内容的支持），搜索多个标签时，标签之间需要使用空格分割。</li></ul>
</ol>
<h3 id="cxxt">查询系统：</h3>
<p>在顶部导航中点击信息速查即可进入查询系统，底部查询面板也属此系统。</p>
<ol style="margin-left:3em;">
	<li>查询系统主页面</li>
	<p><img src="/image/help/help4.png" alt="help4"/></p>
	<p>在第一个文本输入框中，输入各省份的拼音缩写发送查询请求，例如查询江西省的数据则输入JX，对于有冲突的各省拼音缩写，此处遵循<a href="#cernet" >CERNET域名结构标准</a>，当用户输入第一个拼音字符时搜索框会引导用户输入下一个字符，以避免查询到错误的省份信息。当用户点击要查询的省份或者按下回车键时会向服务器发送查询请求并等待服务器响应数据（响应数据应当包含该省历年的录取分数线，填报志愿时间等信息，可由管理员<a href="#change">更改</a>）。服务器响应的数据将在页面显目位置列出,依照服务器的处理速度和网络情况响应时间会有不同，一般在300ms上下。</p>
	<li>底部查询面板</li>
	<p>除去本帮助页面，在其他页面您都可以见到底部有查询面板，用户将鼠标划过底部面板左侧的项目会有相应的列表列出，目前仅添加了统招本科的专业列表和瑶湖校区的校园风景列表。列表中的文字显示为蓝色时表示该项目有具体内容，当用户点击之跳转至详细信息页面，目前仅添加了校园风景的详细信息。底部面板右侧位作者信息，点击可跳转至本帮助页面。</p>
</ol>
<h3 id="xxxt">消息系统：</h3>
<p>用户登录之后可在顶部导航进入消息系统</p>
<ol style="margin-left:3em;">
	<li>消息系统主页</li>
	<p><img src="/image/help/help5.png" alt="help5"/></p>
	<p>上图所示的是消息主界面，目前暂分为四个标签，第一个标签为收件箱，可查阅收到的信息。第二个为发件箱，可查阅发送给他人的消息并查看接收者是否已读该信息。第三个为写信息，在此页面选择收件人（支持群发）并填写消息内容可发送信息。第四个为修改密码，用户可在此修改自己的密码。</p>
	<li>相关操作</li>
	<ul><li>只有当用户将新信息置为已读之后新消息提示才会消失。</li><li>在收件箱中，点击对应信息中的"回复"可回复该条消息，将鼠标划过"回复"时左侧会出现"删除"，点击"删除"可删除该条信息。</li>
	<li>在发件箱中，消息左上方的时间代表的是发送时间，点击右上方的"消息报告"可查看每位该条信息对应每位收件人的状态（未读或已读），鼠标划过"消息报告"左侧会出现"删除"选项，点击其可在自己的发件箱中删除该条信息，但收件人中的信息不会消失。</li></ul>
</ol>
<h3 id="qxxt">权限系统：</h3>
<ol style="margin-left:3em;"><li>本系统将用户分为三种类型：</li>
<ul><li>游客:没有登录的用户，与普通用户相比无法使用消息系统。</li><li>普通用户：登录的用户，有特定的用户信息，可使用消息系统。</li><li>管理员：有管理权限，例如可以删除文章、更改用户信息等。</li></ul>
<li>文章系统中的权限</li>
<p>作为拥有管理员权限的用户登录时，该用户可以"看见"普通用户无法"看见"的面板，例如页面右侧的控制面板中的内容，其中包含添加新闻、修改用户信息等操作。这些具有权限限制的页面普通用户也是无法访问的。<br/>在<a  href="#llwznn">浏览新闻内容</a>页面中，会出现含有此篇文章的一些操作的控制面板，包含文章的状态、删除文章和文章标签的管理。特别解释新闻的在线、离线状态，当新闻置为在线状态时，普通用户可在文章列表中看到此篇文章，但文章下线之后文章不会在普通用户的文章列表中出现，也无法搜索到该文章，管理员则不受限制。</p>
<p><img src="/image/help/help6.png" alt="help6"/></p>
</ol>
<h3 id="llq">浏览器说明：</h3>
<p>因为使用了较新的HTML5进行前端开发，而HTML5是不被老旧的浏览器（IE9以下版本）所支持，为了保持与<a href="http://www.jxbsu.com" target="_blank">学院官网</a>(官网只支持IE浏览器)的最大兼容,这里推荐使用傲游3浏览器。</p>
<p>更多关于傲游3浏览器的信息，请访问其<a href="http://www.maxthon.cn/mx3/" target="_blank">官方网站</a>。</p>
<p><img src="/image/browser/Maxthon.png"/></p>
<p>同时以下浏览器都对HTML5有很好的支持，推荐高级用户使用：</p>
<ul id="browser">
	<li><img src="/image/browser/Chrome.png"/>Chrome</li>
	<li><img src="/image/browser/Firefox.png"/>Firefox</li>
	<li><img src="/image/browser/Opera.png"/>Opera</li>
	<li><img src="/image/browser/Safari.png"/>Safari</li>
</ul>
</div>
	<div style="right: 10px; display:none;" class="back-to" id="toolBackTo">
	<a onclick="abc()" href="#top" class="backtotop">返回顶部
	<img class="back-tip" alt="返回顶部" src="/image/back-tip.png"/>
	</a>
</div>
</body>
</html>