<?php
    class AccountController extends CustomControllerAction
    {
        public function indexAction()
        {
            // nothing to do here, index.tpl will be displayed
        }
        public function testAction(){

        }
        public function init(){
            parent::init();
            $this->breadcrumbs->addStep('账户',$this->getUrl(null,'account'));
        }

		public function loginAction(){
		    $this->breadcrumbs->addStep('用户登录');
			$auth = Zend_Auth::getInstance();
            if($auth->hasIdentity()){ 
                $this->_redirect('/');}
            $request =$this->getRequest();
            $redirect = $request->getPost('redirect');
			isset($_SERVER['REQUEST_URI'])?$redirect=$_SERVER['REQUEST_URI']:$redirect = '/account';
            if(strlen($redirect)==0)
                $redirect = $request->getServer('REQUEST_URI');
            if(strlen($redirect)==0)  
                $redirect = '/account';
				
            $errors = array();
			
            if($request->isPost()){  
			
            $username = trim($request->getPost('username'));
            $password = trim($request->getPost('password'));
			
			if(strlen($username)==0)
				$errors['username'] = '请填写用户名';
			if(strlen($password)==0)
				$errors['password'] = '请填写密码';
			if(count($errors)==0){
			$adapter = new Zend_Auth_Adapter_DbTable($this->db,'users','username','password','md5(?)');
			$adapter->setIdentity($username);
			$adapter->setCredential($password);
            
			$result = $auth->authenticate($adapter);
             if($result->isValid()){
                
                $user = new DatabaseObject_User($this->db);
                $user->load($adapter->getResultRowObject()->user_id);
                
                $user->loginSuccess();
                $identity = $user->createAuthIdentity();
                $auth->getStorage()->write($identity);
                echo $redirect;
				$this->_redirect($redirect);
                }
            
				DatabaseObject_User::LoginFailure($username,$result->getCode());
                    $errors['username'] = '您的登录信息无效';
					}
			}
			$this->view->errors = $errors;
            $this->view->redirect = $redirect;
		}
        public function logoutAction(){
			$auth = Zend_Auth::getInstance();
			$identity=$auth->getIdentity();
			$user = new DatabaseObject_User($this->db);
			$user->load($identity->user_id);
			$user->sendOffline();
			$user->save();
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/');
        }
        
       
		public function mineAction(){
		    
		    $request = $this->getRequest();
			$this->breadcrumbs->addStep('账户信息');
			$auth = Zend_Auth::getInstance();
			$identity=$auth->getIdentity();
			$fp = new FormProcessor_UserChange($this->db,$identity->user_id);
			
			if ($request->isPost()) {
					if($fp->process($request)){
						$session = new Zend_Session_Namespace('Change');
						$session->user_id = $fp->user->getId();
						$this->_redirect('/account/changecomplete');
					}
				}
			$this->view->fp = $fp;
		}

		public function noteAction(){
			$request = $this->getRequest();
			$act = $request->getPost('act');
			if($act=="add"){
				$title = $request->getPost("title");
				$content = $request->getPost("content");
				$note = new DatabaseObject_Note($this->db);
				$note->title = $title;
				$note->content = $content;
				$note->user_id = $this->identity->user_id;
				$note->save();
				$this->sendJson("success");
			}
			elseif ($act=="get") {
				$note = new DatabaseObject_Note($this->db);
				$this->sendJson($note->loadAll($this->identity->user_id));
			}
		}

		public function changecompleteAction(){
		Zend_Auth::getInstance()->clearIdentity();	
		$session = new Zend_Session_Namespace('Change');	
			
			$user = new DatabaseObject_User($this->db);
            if (!$user->load($session->user_id)) {
                $this->_forward('login');
                return;
			}
			$user->load($session->user_id);
			$this->view->user = $user;
			}
	
}
?>

