<?php
function isallow(){
	$allowips = json_decode(file_get_contents("../allowip.json"));
	$remoteip = $_SERVER['REMOTE_ADDR'];
	foreach ($allowips as $allowip) {
		if (preg_match($allowip, $remoteip)) {
			return true;
		}
	}
	echo $remoteip;
	header('HTTP/1.1 401 Unauthorized'); 
	header('status: 401 Unauthorized'); 
	return false;
}
