<?php
require_once("lib.php");
$q = trim($_GET["q"]);
if(strlen($q)==2){
$marks    = new mydb($db_mysql->db, "2011_mark");
$pros = new mydb($db_mysql->db,"abb_p");
$pros->load($q,"abb");
$pro = $pros->p_nm;
$mark     = new mark($marks->load($q, "abb"));
$result = $mark->getMark();
$result["pro"] = $pro;
echo json_encode($result);
}