<?php
class MyObject_Header extends MyObject{
	static $table = "top_nav";
	function __construct($db){
        parent::__construct($db,self::$table);
    }

    public static function getList($db){
    	$sql = "select * from " .self::$table;
    	return $db->fetchAll($sql);
    }
}