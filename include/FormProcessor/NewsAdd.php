<?php
	class FormProcessor_NewsAdd extends FormProcessor
	{
		protected $db = null;
		public $user = null;
		public $user_id= null;
		public $news = null;
		public function __construct($db,$user_id,$news_id = 0){
			parent::__construct();
			$this->db = $db;
			$this->user = new DatabaseObject_User($this->db);
			$this->user->load($user_id);
			$this->news = new DatabaseObject_News($this->db);			
            $this->news->loadNews($news_id);
			$this->user_id  = $user_id;
		}
		
		public function process(Zend_Controller_Request_Abstract $request){
			$this->title = $this->sanitize($request->getPost('news_title'));
			$this->content =$request->getPost('news_content');
			$this->news->user_id=$this->user_id;
			$this->news->profile->editor_name = $this->user->realname;
			$this->news->profile->title = $this->title;
			$this->news->profile->content = $this->content;
			$this->news->profile->ts_edit=time();
			$preview = !is_null($request->getPost('preview'));
                if (!$preview)
                    $this->news->sendLive();
			$this->news->save();
		}
	}
?>