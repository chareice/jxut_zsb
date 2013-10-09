<?php
namespace my{
class auth{
	private $user;
	private $password;
	
	function __construct($u,$p){
		$this->user = $u;
	}
}
class db{
	public $_table;
	
    public $_dbc;
    
	protected $_properties = array();
	
	function __construct($table){
		$this->_dbc = new \mysqli('localhost','chareice','aa362325','calling');
		$this->setFieldName($table);
	}
	
	public function __set($name,$value){
		if (array_key_exists($name, $this->_properties)) {
			$this->_properties[$name]['value'] = $value;
            $this->_properties[$name]['updated'] = true;
            return true;
        }
        return false;
	}
	
	public function __get($name){
		return array_key_exists($name, $this->_properties) ? $this->_properties[$name]['value'] : null;
	}
	
	//@获取表$table的字段名，将FieldName设置为线性数组。
	//@不可作为对外接口，SQL注入有高风险。
	protected function setFieldName($table){
		$sql = sprintf("select * from `%s`",$table);
        $data = $this->_dbc->query($sql)->fetch_fields();
        foreach ($data as $d)
		$this->_properties[$d->name] = array('value' => null,'updated' => false);
	}
}

function isPost(){
  return (is_array($_POST) && count($_POST)>0);
}
function setSessionInit(){
	$lifeTime = 24 * 3600; 
        session_set_cookie_params($lifeTime); 
        session_start();
}
function getLoginForm(){
echo <<<LoginForm
<form id="login" method="post" action="/note/login.php">
	<fieldset>
          <legend>登陆</legend>
          <label for="username">用户名</label><input id="username" name="username" type="text"/>
          <label for="password">密码</label><input id="password" name="password" type="password"/>
          <button type="submit">登陆</button>
  </fieldset>
</form>
LoginForm;
}
function identity($username,$password){
    
}
}
?>