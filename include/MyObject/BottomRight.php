<?php
class MyObject_BottomRight extends MyObject{
	static $table = "bottom_right";
	function __construct($db){
        parent::__construct($db,self::$table);
    }

    public static function getList($db){
    	$sql = "select * from " .self::$table;
    	return $db->fetchAll($sql);
    }
}