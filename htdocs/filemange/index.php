<?php
	if(@md5($_POST['pass'])=='b3c4b9474dd8b90030e42be8562198bb'){
		?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.zh_CN.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
					url : 'php/connector.php',
					height : 900,  // connector URL (REQUIRED)
					lang: 'zh_CN'             // language (OPTIONAL)
				}).elfinder('instance');
			});
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
<?php
	}
	else{
		?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/style/file.css">
		<link rel="stylesheet" type="text/css" href="/style/bootstrap/bootstrap.min.css">
	</head>
	<body>
		<form id="auth-admin" method="post" action="/filemange/index.php" class="well input-append input-prepend">
			<span class="add-on">$</span><input type="password" name="pass" placeholder="请输入管理密码" class="span2"/><button type="submit" class="btn btn-success">验证</button>
		</form>
	</body>
</html>
		<?php
	}
?>