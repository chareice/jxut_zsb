<?php
class WorkController extends CustomControllerAction{
	public function indexAction(){
		
	}
	public function innerstudentAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$student = new DatabaseObject_Fresh($this->db);
			$info = array();
			$info = $request->getPost();
			$info["inner"] = $this->identity->user_id;
			$info["time"] = time();
			$student->getInitialize($info);
			$this->sendJson("success");
		}
	}

	public function countAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$info = array();
			$info = $request->getPost();
			$info["time"] = time();
			$info["user_id"] = $this->identity->user_id;
			$count = new DatabaseObject_Count($this->db);
			$count->getInitialize($info);

			$this->sendJson("success");
		}
	}

	public function infoaddnewAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$person = new MyObject_Person($this->db);
			$person->id = $request->getPost("id");
			$person->name = $request->getPost("name");
			$person->save();
			$this->sendJson("success");
		}
	}

	public function infoinneraddAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$inner = new MyObject_Inner($this->db);
			$inner->place = $request->getPost("place");
			$inner->person_id = $request->getPost("id");
			$inner->count = $request->getPost("num");
			$inner->save();
			$this->sendJson($request->getPost()	);
		}
	}

	public function getinnerAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$sql = sprintf("select `city`.`FULL_NAME`,`inner`.`inner_id`,`person`.`name`,`inner`.`count` as count from `city`,`inner`,`person` where `inner`.`person_id` = %s and `city`.`DISCTRICT_CODE`= `inner`.`place` and `inner`.`person_id` = `person`.`id`",$request->getPost("id"));
			$result = $this->db->fetchAll($sql);
			if(count($result)==0){
				$sql = sprintf("select * from `person` where id = %s",$request->getPost("id"));
				$result = $this->db->fetchAll($sql);
			}
			$this->sendJson($result);
		}	
	}

	public function editinnerAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$inner = new MyObject_Inner($this->db);
			$inner->load($request->getPost("inner_id"),"inner_id");
			$inner->count = $request->getPost("count");
			$inner->save();
			$result = array('count' =>$inner->count);
			$this->sendJson($result);
		}
	}

	public function deleteinfoAction(){
		$request = $this->getRequest();
		if($request->isPost()){
			$inner = new MyObject_Inner($this->db);
			$inner->load($request->getPost("inner_id"),"inner_id");
			$inner->delete();
			$this->sendJson("success");
		}
	}
}