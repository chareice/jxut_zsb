<?php
$file_handle = fopen("bbb.txt", "rw+");
while (!feof($file_handle)) {
   $line = fgets($file_handle);
   if(preg_match('/专业名称|核心理论|主要技能|毕业主要去向|从事职业|本行业领域人才需求|本专业未来发展前景/',$line)){
	 if(preg_match('/专业名称/',$line)){
		echo "<br/>";continue;
	 }
	$s = "<h4>".trim($line)."</h4>";
	echo htmlspecialchars($s); 
   }
   else {
	$s = "<p>".trim($line)."</p>";
	echo htmlspecialchars($s); }
	echo "<br/>";
}
//fclose($file_handle);