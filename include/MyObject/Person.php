<?php
class MyObject_Person extends MyObject{
	function __construct($db){
        parent::__construct($db,"person");
    }

    public static function getPersonId($db){
        $select = $db->select();
        $select->from("person","id");
        return $db->fetchCol($select);
    }
}