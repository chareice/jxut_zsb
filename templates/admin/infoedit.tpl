<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"/>
<title>Info eidtor</title>
<script type="text/javascript" src="/js/jquery/jquery.js"></script>
<script type="text/javascript" src="/js/jquery/ac.js"></script>
<link rel="Stylesheet" href="/js/jquery/ac.css" />
<script type="text/javascript" src="/js/infoedit.js"></script>
<script type="text/javascript" src="/js/ueditor/editor_config.js"></script>
<script type="text/javascript" src="/js/ueditor/editor_all_min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/ueditor/themes/default/css/ueditor.css"/>
</head>
<body>
<form action="/admin/infoedit?q={$q}" method="post" style="float:left;margin-right:2em;">
	<section class="message">
		<textarea width="500" class="ckeditor"  id="baidu_editor" name="info">{$info->content}</textarea>
	</section>
	<input type="hidden" name="id" value="{$info->getId()}"/>
	<input type="submit" value="修改以上信息"/>
</form>
<input id="main-serch" type="text"/>
<h3>当前修改：<span id="p_nm" style="color:red;">{$info->p_nm}</span></h3>
<ul style="list-style-type:none;">告知：
<li>1.仅<span>Firefox（火狐浏览器）</span>支持对表格大小进行修改。</li>
<li>2.表格最大宽度不应超过500像素(500px，编辑框宽度)，超出部分将被前台忽略。</li>
<li>3.编辑框不支持修改表格结构，请将表格复制到Office软件中进行修改。</li>
</ul>
</body>
</html>