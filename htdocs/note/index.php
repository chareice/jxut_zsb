<?php
require("view/header.php");
require("../include/lib.php");
my\setSessionInit(1);
if(!isset($_SESSION["user"])){
    my\getLoginForm();
}
$db = new my\db("users");
require("view/footer.php");