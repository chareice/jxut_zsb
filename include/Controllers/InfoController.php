<?php
class InfoController extends CustomControllerAction
{
        public function indexAction(){
            $this->breadcrumbs->addStep('查询',$this->getUrl(null,'info'));
        }
		public function mainAction(){
            $request = $this->getRequest();
			if($request->isPost()){
				$this->_helper->viewRenderer->setNoRender();
				$q = $request->getPost("q");
				$this->Sendjson(DatabaseObject_Infomain::queryact($this->db,$q));
			}
        }
		public function testAction(){
            $this->_helper->viewRenderer->setNoRender();
			$info = new DatabaseObject_Infomain($this->db);
		}
		public function tbartAction(){
            
        }
		public function searchAction(){
		$db = $this->db;
		$q=$_GET['q'];
		/*$op = array(
			'p_nm', 'arts_b_mark', 'arts_z_mark', 'science_b_mark', 'science_z_mark'
		);
		$select = $db->select();
		$select->from('info_2010',$op)
			   ->where('abb=?',"$q");
		$query = $select->__toString();
		$result = $db->fetchAll($query);*/
		$abb = DatabaseObject_Info::changeAbb($this->db,$q);
		$info = new DatabaseObject_Info($this->db);
		$info->loadInfo($abb[0]);
		$a['c'] = $info->content;
		$a['n'] = $info->p_nm;
		$this->sendJson($a);
		}
		public function cityAction(){
		}
		public function cityproAction(){
			$q = trim($_GET['q']);
			$db = $this->db;
			$op = array(
				'full_name','phone_code','zip_code'
			);
			$select = $db->select();
			$select->from('city',$op)
			   ->where('city.full_name like ?',"%$q%")
			   ;
			$query = $select->__toString();
			$result = $db->fetchAll($query);
			$this->sendJson($result);
		}
}
?>