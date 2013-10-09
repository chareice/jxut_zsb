<?php
require_once ("../include/lib.php");
session_start();
if(my\isPost()){
    $username = $_POST["username"];
    $password = $_POST["password"];
  if(1){
    $url = $_SERVER['HTTP_REFERER'];
?>
<meta http-equiv="refresh" content="2; url=<?php echo $url?>" />
登录成功，跳转页面中……
<?php
  }
}
else
{echo "您无权这么做"; }
?>