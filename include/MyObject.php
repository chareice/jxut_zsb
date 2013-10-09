<?php
/*
 *
 *Database object management
 *
 *@auth Chareice
 *
 *@mysql object
 */
class MyObject{
    protected $_table = "";
    
    protected $_properties = array();
    
    protected $_dbc = NULL;
    
    protected $_many = false; //multirow object?
    
    protected $_loaded = false;
    
    protected $_loadField = "";
    
    protected $_loadValue = "";
    
    function __construct($db, $table) {
        $this->_dbc   = $db;
        $this->_table = $table;
        $this->setProperties();
    }
    
    public function load($v, $field) {
        $this->_loadField = $field;
        $this->_loadValue = $v;
        $sql              = sprintf("select * from `%s` where %s = \"%s\"", $this->_table, $this->_loadField, $this->_loadValue);
        $data             = $this->_dbc->fetchAll($sql);
        if (count($data)) {
            $this->_loaded = true;
            if (count($data) == 1) { //single line object
                foreach ($data[0] as $k => $v) {
                    $this->_properties[$k]["value"] = $v;
                }
            } else { //multirow object
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
            return true;
        } else {
            //non object select process here
            return false;
        }
    }
    
    public function save() {
        $temp = array();
        foreach ($this->_properties as $k => $v) {
            if ($this->_properties["$k"]["updated"])
                $temp["$k"] = $this->_properties["$k"]["value"];
        }
        
        if ($this->_loaded) { //modify old record
            $this->_dbc->update($this->_table, $temp, $this->_dbc->quoteInto("$this->_loadField = ?", $this->_loadValue));
        } else { //add new record
            $this->_dbc->insert($this->_table,$temp);
        }
    }
    
    public function delete() {
        if ($this->_loaded) {
            $sql = sprintf("delete from `%s` where %s = '%s'", $this->_table, $this->_loadField, $this->_loadValue);
            $this->_dbc->query($sql);
            return true;
        } else {
            return false;
        }
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
    
    public function getProperties() {
        return $this->_properties;
    }
    
    protected function setProperties() {
        //$sql  = sprintf("select * from `%s`", $this->_table);
        $sql = sprintf("desc `%s`",$this->_table);
        $data = $this->_dbc->fetchAssoc($sql);

        foreach ($data as $key=>$value) //$d is fetched column
            $this->_properties[$key] = array(
                'value' => null,
                'updated' => false
            );        
    }
}