<?php
	$a = strtotime($_POST['time']);
	$time = date('Y m d,H:i',$a);
	echo $time;
	?>