<?php
class getMysql { //数据库连接初始化
    public $db;
    function __construct() {
        $this->db = new mysqli("localhost","chareice","aa362325","calling");
		$this->db->query("SET NAMES utf8");
    }
}
class mark {
    public $_nor = array();
    public $_art = array();
    public $_result = array();
    public $_mark = array();
    function __construct($mark) {
        $this->_mark = $mark; //数据库返回的mark原始数据
        $this->formate();
    }
    public function getMark() {
      //$this->_result["nor"] = $this->_nor;
      //$this->_result["art"] = $this->_art;
        return $this->_result;
    }
    private function formate() {
        for ($i = 0; $i != count($this->_mark["identity"]["value"]); $i++) {
            $identity = $this->_mark["identity"]["value"]["$i"];
            $mark = $this->_mark["mark"]["value"]["$i"];
          //$temp=array("i"=>$identity,"m"=>$mark);
          //$temp = array($identity=>$mark);
          //if (strlen($this->_mark["identity"]["value"][$i]) == 6) {
              //$this->_nor[$this->_mark["identity"]["value"]["$i"]] = $this->_mark["mark"]["value"]["$i"];
          //  $this->_nor[$identity]=$mark;
          //} else{ 
              //$this->_art[$this->_mark["identity"]["value"]["$i"]] = $this->_mark["mark"]["value"]["$i"];
              $this->_result[$identity]=$mark;
              //array_push($this->_art,"$identity=>$mark");
          //  }
        }
    }
}

class mydb { //自定义数据库对象管理
    public $_table;
    
    public $_properties = array();
    
    public $_dbc;
    
    public $_many = false; //是否有多行数据
    
    public $_loaded = false;
    
    public $_loadField = "";
    
    public $_loadValue = "";
    
    function __construct($db, $table) {
        $this->_dbc   = $db;
        $this->_table = $table;
        $this->setProperties();
    }
    
    public function load($v, $field) {
        $this->_loadField = $field;
        $this->_loadValue = $v;
        $sql              = sprintf("select * from %s where %s = \"%s\"", $this->_table, $this->_loadField, $this->_loadValue);
        $data             = $this->_dbc->query($sql);
        $this->_loaded    = true;
        if ($data->num_rows == 1) { //单行数据库对象 
            foreach ($data->fetch_assoc() as $k => $v) {
                $this->_properties[$k]["value"] = $v;
            }
        } else { //多行数据对象
            //(!is_array($this->_properties[key($this->_properties)]["value"]))
            $this->_many = true;
            foreach ($this->_properties as $k => $v) {
                $this->_properties[$k]["value"] = array();
            }
            while ($row = $data->fetch_assoc())
                foreach ($row as $k => $v) {
                    array_push($this->_properties[$k]["value"], $v);
                }
            return $this->_properties;
        }
    }
    
    public function save() {
        $temp = array();
        foreach ($this->_properties as $k => $v) {
            if ($this->_properties["$k"]["updated"])
                $temp["$k"] = $this->_properties["$k"]["value"];
        }
        
        if ($this->_loaded) { //修改原始数据
            $ld = array();
            foreach ($temp as $k => $v)
                array_push($ld, "$k=\"$v\"");
            $sql    = sprintf("update %s set %s where %s = \"%s\"", $this->_table, join($ld, ","), $this->_loadField, $this->_loadValue);
            $result = $this->_dbc->query($sql);
            if (!$result)
                die("数据库错误");
        } else { //添加新数据
            $sql    = sprintf("insert into %s (%s) values (%s)", $this->_table, join(array_keys($temp), ","), sprintf("'%s'", join(array_values($temp), "','")));
            $result = $this->_dbc->query($sql);
            if (!$result)
                die("数据库错误");
        }
    }
    public function auth($username, $password) {
        $password    = md5($password);
        $sql         = sprintf("select id from users where username = \"%s\" and password = \"%s\"", $username, $password);
        $auth_result = $this->_dbc->query($sql)->fetch_assoc();
        if ($auth_result)
            return $auth_result["id"];
        else
            return false;
    }
    public function __set($name, $value) {
        if (array_key_exists($name, $this->_properties) && (!$this->_many)) {
            $this->_properties[$name]['value']   = $value;
            $this->_properties[$name]['updated'] = true;
            return true;
        }
        
        return false;
    }
    
    
    public function __get($name) {
        return array_key_exists($name, $this->_properties) ? $this->_properties[$name]['value'] : null;
    }
    
    public function getFieldName() {
        return $this->_properties;
    }
    protected function setProperties() {
        $sql  = sprintf("select * from `%s`", $this->_table);
        $data = $this->_dbc->query($sql)->fetch_fields();
        foreach ($data as $d) //$d为获取到的每个列
            $this->_properties["$d->name"] = array(
                'value' => null,
                'updated' => false
            );
        
    }
}
$db_mysql = new getMysql();