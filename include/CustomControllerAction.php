<?php
    class CustomControllerAction extends Zend_Controller_Action
    {
        public $db;
        public $breadcrumbs;
        public $messenger;
        public $identity;
		public $admin = false;
		
        function init()
        {	
            $this->db = Zend_Registry::get('db');
            $this->breadcrumbs = new Breadcrumbs();
            $this->breadcrumbs->addStep('主页', $this->getUrl(null, 'index'));
			$this->messenger = $this->_helper->_flashMessenger;
			$auth=Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $this->identity = $auth->getIdentity();
				if($this->identity->user_type=="administrator")
					$this->admin = true;
            }
            $this->view->headers  = MyObject_Header::getList($this->db);
            $this->view->bottomlefts  = MyObject_BottomLeft::getList($this->db);
            $this->view->bottomrights  = MyObject_BottomRight::getList($this->db);
        }
        public function sendJson($data){
			$this->_helper->viewRenderer->setNoRender();
			$this->getResponse()->setHeader('content-type','application/json');
			echo Zend_Json::encode($data);
		}
        public function getUrl($action = null, $controller = null,$tag = null)
        {
            $url="http://".$_SERVER['HTTP_HOST'];
            $url.= $this->_helper->url->simple($action, $controller);
			if($tag)
				$url.="?tag=$tag";
            return $url;
        }
        
        public function postDispatch()
        {	$this->view->messages = $this->messenger->getMessages();
            $this->view->breadcrumbs = $this->breadcrumbs;
            $this->view->title = $this->breadcrumbs->getTitle();
        }

       

        function preDispatch(){
			
            $auth=Zend_Auth::getInstance();
            if($auth->hasIdentity()){
                $this->view->authenticated = true;
                $this->view->identity = $auth->getIdentity();
            }
            else 
                $this->view->authenticated = false;
        }
		public function segment($url,$str){
            $ch = curl_init();
			// 2. 设置选项，包括URL
			curl_setopt($ch, CURLOPT_URL, $url.$str);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			// 3. 执行并获取HTML文档内容
			$output = curl_exec($ch);
			// 4. 释放curl句柄
			curl_close($ch);
			return $output;
		}
    }
?>