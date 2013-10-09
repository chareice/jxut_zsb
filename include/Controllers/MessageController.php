<?php
class MessageController extends CustomControllerAction{
	public function indexAction(){
		$this->breadcrumbs->addStep('消息',$this->getUrl(null,'message'));
		$request = $this->getRequest();
		$fp = new FormProcessor_UserChange($this->db,$this->identity->user_id);			
			if ($request->isPost()) {
					if($fp->process($request)){
						$session = new Zend_Session_Namespace('Change');
						$session->user_id = $fp->user->getId();
						$this->_redirect('/account/changecomplete');
					}
				}
			$this->view->fp = $fp;
		/*@$page=$_GET['page'];//传入页码
		if(!isset($page))
			$page = 1;
		define("NEWSSHOW","3");//定义每页所显示的文章数
		$msgs = DatabaseObject_Messageto::getInMessageCount($this->db,$identity->user_id);
		//--------------------------------------------------------------
		require_once "Cutpage.php";
		$pagesum = Cutpage::process($msgs,NEWSSHOW);
		//---------------根据所定义的每页文章数和文章总数输出总页码-------------
		if($page>$pagesum)
			$page=1;
		*/	
		$op = array(
			'status'=>'ON'
		);
		/*$pa = array(
			'user_id'=>$identity->user_id,
			'limit'=>NEWSSHOW,
			'offset'=>("$page"-1)*NEWSSHOW
		);*/
		$users =DatabaseObject_User::GetUsers($this->db/*,$op*/);
		$this->view->users = $users;
		/*$message = DatabaseObject_Messageto::getInMessage($this->db,$pa);
		$this->view->message = $message;
		$this->view->pageid = $page;//当前页码
		$this->view->pagesum = $pagesum;//总页码
		$this->view->newsnum = $msgs;//文章总数*/
	}	
	public function setstatusAction(){//将消息置已读
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$request =$this->getRequest();
		if($request->isPost()){
			$status = $request->getPost('act');
			$msg_to_id = $request->getPost('msg_to_id');
			$msg_to = new DatabaseObject_Messageto($this->db);
			$msg_to->load($msg_to_id);
			if($status=='del')
				$msg_to->senddel();
			else
				$msg_to->sendview();
			$msg_to->save();
			echo "success";
		}
	}
	public function setdelAction(){
		if($this->getRequest()->isPost()){
			$msg = new DatabaseObject_Message($this->db);
			$msg->load($this->getRequest()->getPost('msg_id'));
			$msg->senddel($this->identity->user_id);
			$msg->save();
			$this->sendJson("success");
		}
	}
	public function getmsgAction(){
	define("NEWSSHOW","5");
	require_once "Cutpage.php"; 
	$a = array("page"=>(int)$this->getRequest()->getPost('page'),
			   "msgs"=>DatabaseObject_Messageto::getInMessageCount($this->db,$this->identity->user_id),
			   );
	
	$a["pagesum"] = Cutpage::process($a["msgs"],NEWSSHOW);
	$pa = array(
			'user_id'=>$this->identity->user_id,
			'limit'=>NEWSSHOW,
			'offset'=>($a["page"]-1)*NEWSSHOW
		);
	
	$message = DatabaseObject_Messageto::getInMessage($this->db,$pa);
	array_push($message,$a);
	$this->sendJson($message);
	}
	public function getoutAction(){//获取发件箱数据
		$op = array("page"=>(int)$this->getRequest()->getPost('page'),
			   "user_id"=>$this->identity->user_id,
			   "show"=>5);
		$a["page"] = $op["page"];
		$a["msgs"] = DatabaseObject_Messageto::getOutMessageCount($this->db,$this->identity->user_id);
		$m = DatabaseObject_Messageto::getOutMessage($this->db,$op);
		$a['pagesum'] = Cutpage::process($a['msgs'],$op['show']);
		array_push($m,$a);
		$this->sendJson($m);
	}
	public function getstatusAction(){//获取消息状态
		$msg_id = (int)$this->getRequest()->getPost('msg_id');
		$this->sendJson(DatabaseObject_Messageto::getstatus($this->db,$msg_id));
	}
	public function getnewAction(){//获取新消息提示
		$this->sendJson(DatabaseObject_Messageto::getnewCount($this->db,$this->identity->user_id));
	}
	public function sendAction(){
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$request =$this->getRequest();
		if($request->isPost()){
			 $message = trim($request->getPost('message'));
			 $re_id = $request->getPost('receive');
			 if((strlen($message)==0)|| (count($re_id)==0))
			 die("发生了一些错误");
			 $msg = new DatabaseObject_Message($this->db);
			 $msg->authid = $this->identity->user_id;
			 $msg->message = $message;
			 $msg->save();
			 foreach($re_id as $re){
			 $message_to = new DatabaseObject_Messageto($this->db);
			 $message_to->msg_id = $msg->getId();
			 $message_to->receiver_id = $re;
			 $message_to->save();
			}
		}
    }		
}
?>
