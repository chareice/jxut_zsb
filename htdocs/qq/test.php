 <html lang="zh-cn">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>
            Demo for QQ登录oauth2.0
        </title>
        <script type="text/javascript">
            var childWindow;
            function toQzoneLogin()
            {
                childWindow = window.open("oauth/qq_login.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            } 
            
            function closeChildWindow()
            {
                childWindow.close();
            }
        </script>
    </head>
    <body>
      <h1 style="color:red;text-align:center">Product by Chareice</h1>
        <br><br>
        <a href="#" onclick='toQzoneLogin()'><img src="img/qq_login.png"></a>
        <br><br>
        <a href="user/get_user_info.php"    target="_blank">获取用户信息</a>
		<br><br>
        <a href="share/add_share.html"      target="_blank">添加分享</a>
        <br><br>
        <a href="photo/list_album.php"      target="_blank">获取相册列表</a>
        <br><br>
        <a href="photo/add_album.html"      target="_blank">创建相册</a>
        <br><br>
        <a href="photo/upload_pic.html"     target="_blank">上传相片</a>
        <br><br>
        <a href="blog/add_blog.html"     target="_blank">发表日志</a>
        <br><br>
        <a href="topic/add_topic.html"     target="_blank">发表说说</a>
        <br><br>
        <a href="weibo/add_weibo.html"     target="_blank">发表微博</a>
    </body>
</html>
