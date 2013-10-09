<?php
class MyObject_Inner extends MyObject{
	function __construct($db){
        parent::__construct($db,"inner");
    }
}