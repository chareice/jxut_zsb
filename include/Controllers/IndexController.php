<?php
    class IndexController extends CustomControllerAction
    {
        public function indexAction()
        {
			$t_options = array(
					'from' => 'today',
					'status'=>$this->admin);
			$w_options = array(
					'from' => '-7 day',
					'to'=>'now',
					'status'=>$this->admin);
			$today = DatabaseObject_News::Getnews($this->db,$t_options);
			$thisweek = DatabaseObject_News::Getnews($this->db,$w_options);
			$this->view->today = $today;
			$this->view->a = "aaaaaaaaaaa";
			$this->view->thisweek = $thisweek;
        }
		public function mAction(){
			
		}
    }
?>
