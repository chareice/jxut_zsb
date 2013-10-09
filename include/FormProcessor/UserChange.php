<?php
    class FormProcessor_UserChange extends FormProcessor
    {
		 protected $db = null;
		 public $user = null;
        
		 public function __construct($db, $user_id)
        {
            parent::__construct();

            $this->db = $db;
            $this->user = new DatabaseObject_User($db);
            $this->user->load($user_id);
			$this->oldpassword = $this->user->password;
            $this->realname = $this->user->realname;
        }
          public function process(Zend_Controller_Request_Abstract $request)
        {	
		
			$this->old_passwd = $this->sanitize($request->getPost('oldpasswd'));
			$this->password = $this->sanitize($request->getPost('password'));
            $this->password_confirm = $this->sanitize($request->getPost('password_confirm'));
            if(strlen($this->old_passwd)==0)
				{$this->addError('oldpasswd','请填写原始密码');return false;}
			if(strlen($this->password)==0)
				{$this->addError('password','请输入新密码');return false;}
			if(strlen($this->password_confirm)==0)
				{$this->addError('password_confirm','请再次输入新密码');return false;}
			if($this->password !=$this->password_confirm)
				{$this->addError('password','两次密码输入不一致');return false;}
			if(strlen($this->old_passwd)> 0 && md5($this->old_passwd)!=$this->oldpassword)
				{$this->addError('oldpasswd','原始密码错误');return false;}
            if($this->password == $this->old_passwd)
				{$this->addError('password_confirm','哥哥姐姐们，不要这么玩我好吗，作为服务器我鸭梨真的很大');return false;}
				else
                    $this->user->password = $this->password;
                  if (!$this->hasError()) {
						$this->user->save();
					}
				return !$this->hasError();

		}
    }
?>
