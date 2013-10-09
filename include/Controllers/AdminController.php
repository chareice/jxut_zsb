<?php
    class AdminController extends CustomControllerAction
    {
		
		public function init(){
            parent::init();
            $this->breadcrumbs->addStep('管理',$this->getUrl(null,'admin'));
        }
        
		public function indexAction(){
			
		}
 		public function getheaderAction(){
            $this->sendJson(MyObject_Header::getList($this->db));
        }
        public function getbottomrightAction(){
            $this->sendJson(MyObject_BottomRight::getList($this->db));
        }
        public function getbottomleftAction(){
            $this->sendJson(MyObject_BottomLeft::getList($this->db));
        }

		public function editobjectAction(){
			$request = $this->getRequest();
			if($request->isPost()){
				$action = $request->getPost('action');
				if($action == 'header'){
					try{
						$header = new MyObject_Header($this->db);
						$header->load($request->getPost('id'),'id');
						$header->content = $request->getPost('name');
						$header->url = $request->getPost('url');
						$header->rankid = $request->getPost('rankid');
						$header->save();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson($e);
					}
					
				}elseif ($action=="bottomleft") {
					try{
						$header = new MyObject_BottomLeft($this->db);
						$header->load($request->getPost('id'),'id');
						$header->content = $request->getPost('content');
						$header->rankid = $request->getPost('rankid');
						$header->save();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson($e);
					}
				}elseif($action == 'bottomright'){
					try{
						$header = new MyObject_BottomRight($this->db);
						$header->load($request->getPost('id'),'id');
						$header->content = $request->getPost('name');
						$header->url = $request->getPost('url');
						$header->rankid = $request->getPost('rankid');
						$header->save();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson($e);
					}
				}
			}
		}

		public function newobjectAction(){
			$request = $this->getRequest();
			if($request->isPost()){
				$action = $request->getPost('action');
				if($action == 'header'){
					try{
						$header = new MyObject_Header($this->db);
						$header->content = $request->getPost('name');
						$header->url = $request->getPost('url');
						$header->rankid = $request->getPost('rankid');
						$header->save();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson($e);
					}
				}elseif ($action == 'bottomleft') {
					try{
						$header = new MyObject_BottomLeft($this->db);
						$header->name = $request->getPost('name');
						$header->content = $request->getPost('content');
						$header->rankid = $request->getPost('rankid');
						$header->save();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson($e);
					}
				}elseif ($action == 'bottomright') {
					try{
						$header = new MyObject_BottomRight($this->db);
						$header->content = $request->getPost('name');
						$header->url = $request->getPost('url');
						$header->rankid = $request->getPost('rankid');
						$header->save();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson($e);
					}
				}
			}
		}
		public function deleteobjectAction(){
			$request = $this->getRequest();
			if($request->isPost()){
				$action = $request->getPost('action');
				if($action == 'header'){
					try{
						$header = new MyObject_Header($this->db);
						$header->load($request->getPost('id'),'id');
						$header->delete();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson("faield");
					}
				}elseif($action == 'bottomleft'){
					try{
						$header = new MyObject_BottomLeft($this->db);
						$header->load($request->getPost('id'),'id');
						$header->delete();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson("faield");
					}
				}elseif($action == 'bottomright'){
					try{
						$header = new MyObject_BottomRight($this->db);
						$header->load($request->getPost('id'),'id');
						$header->delete();
						$this->sendJson("success");
					}catch(Exception $e){
						$this->sendJson("faield");
					}
				}
			}
		}
		public function infoeditAction(){
			$request = $this->getRequest();
			$q = $request->getQuery('q');
			$abb = DatabaseObject_Info::changeAbb($this->db,$q);
			$info = new DatabaseObject_Info($this->db);
			$info->loadInfo($abb[0]);
			$this->view->info = $info;
			$this->view->q = $q;
			if($request->isPost()){
				$info->content = $request->getPost('info');
				$info->save();
			}
		}
		public function addinfoAction(){
			$request = $this->getRequest();
			if($request->isPost()){
				$this->_helper->viewRenderer->setNoRender();
				if($request->getPost("a")){
					$id = DatabaseObject_Infomain::changeAbb($this->db,$request->getPost("q"));
					$info = new DatabaseObject_Infomain($this->db);
					$info->loadInfo($id[0]);
					$b["t"]=$info->info_title;
					$b["c"]=$info->info_content;
					$b["k"]=substr($info->info_py,0,2);
					$this->sendJson($b);
				}
				else if($request->getPost("e")){
					$id = DatabaseObject_Infomain::changeAbb($this->db,$request->getPost("q"));
					$info = new DatabaseObject_Infomain($this->db);
					$info->loadInfo($id[0]);
					$t = trim($request->getPost("t"));
					$py = trim($request->getPost("p"));
					$c = trim($request->getPost("c"));
					if((strlen($t)||strlen($py)||strlen($c))){
						$info->info_title = $t;
						$info->info_py = $py;
						$info->info_content = $c;
						$info->save();
					}
				}
				else{
					$t = trim($request->getPost("t"));
					$py = trim($request->getPost("p"));
					$c = trim($request->getPost("c"));
					if((strlen($t)||strlen($py)||strlen($c))){
					$info = new DatabaseObject_Infomain($this->db);
					$info->info_title = $t;
					$info->info_py = $py;
					$info->info_content = $c;
					$info->save();
					echo $py;
					}
				}
			}
		}
		public function adduserAction(){
			$this->breadcrumbs->addStep('添加用户', $this->getUrl(null, 'adduser'));
            $request = $this->getRequest();
            $errors = array();  
            if($request->isPost()){            
            $username = $request->getPost('username');
            $password = $request->getPost('password');
            $realname = $request->getPost('realname');
            $user_type = $request->getPost('authselect');
            if(strlen($username)== 0)
                $errors['username'] = '请填写用户名' ;
            if(strlen($password)== 0)
                $errors['password'] = '请填写密码' ;
            if(count($errors)==0){
            $db = $this->db;
            $user = new DatabaseObject_User($db);
            $user->username = $username;
            $user->password = $password;
            $user->user_type = $user_type;
            $user->realname = $realname;
            $user->save();
			}
			}
		}
		public function usermanageAction(){
			$this->breadcrumbs->addStep('用户管理', $this->getUrl(null, 'usermanage'));
			$users =DatabaseObject_User::GetUsers($this->db);
			$this->view->users = $users;
		}
		public function ajaxAction(){
			Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
			$name=$_GET['name'];
			$user_id=$_GET['user_id'];
			$user = new DatabaseObject_User($this->db);
			$user->load($user_id);
			$user->realname = $name;
			$user->save();
			echo "修改成功";
		}
}
?>
