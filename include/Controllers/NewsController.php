<?php
    class NewsController extends CustomControllerAction
    {   
    
        public function init()
        {
          parent::init();
          $this->breadcrumbs->addStep('新闻',$this->getUrl(null,'news'));
        }
        public function indexAction()
        {
		//DatabaseObject_News::RebuildIndex();
		//echo $this->segment("http://jxut.sinaapp.com/segment.php?title=","关于成立江西科技学院留学服务中心的通知");
		@$page=$_GET['page'];//传入页码
		/*if(@$tag=$_GET['tag'])
		{$this->breadcrumbs->addStep($tag,$this->getUrl(null,'news',$tag));}
		else
		$tag = false;
		echo $page;*/
		if(!isset($page))
			$page = 1;
		define("NEWSSHOW","10");//定义每页所显示的文章数
		$newsnum = DatabaseObject_News::GetnewsCount($this->db,array('status'=>$this->admin));//得到文章总数
		//---------------------------------------------------------------------------
		if( $newsnum ){
			if( $newsnum < NEWSSHOW )
			{ $pagesum = 1; }
			if( $newsnum % NEWSSHOW ){$pagesum = (int)($newsnum / NEWSSHOW) + 1;}
			else{$pagesum = $newsnum / NEWSSHOW ;}
			}
			else{$pagesum = 0;}
		//---------------根据所定义的每页文章数和文章总数输出总页码------------------
		if($page>$pagesum)
			$page=1;	
		
		$op = array(
			'limit'=>NEWSSHOW,
			'offset'=>("$page"-1)*NEWSSHOW,
			'status'=>$this->admin,
			//'tag'=>$tag,
		);
		//array_push($op,'tag'=>)
		
        $news = DatabaseObject_News::Getnews($this->db,$op);
		$this->view->tags = DatabaseObject_News::getAllTags($this->db);
		$this->view->news = $news;
		$this->view->pageid = $page;//当前页码
		$this->view->pagesum = $pagesum;//总页码
		$this->view->newsnum = $newsnum;//文章总数
		
        }
		 public function tagAction()
        {    
			$this->breadcrumbs->addStep('标签分类',$this->getUrl('tag','news'));
			$request = $this->getRequest();
			$tag = $request->getUserParam('tag');
			$op = array(
			'status'=>$this->admin,
			'tag'=>$tag);
			$news = DatabaseObject_News::Getnews($this->db,$op);
			$this->view->news = $news;
			$this->view->tag = $tag;
		}
		 public function tagsAction()
        {	
            $request = $this->getRequest();

            $news_id = (int) $request->getPost('id');

            $news = new DatabaseObject_News($this->db);
            if (!$news->loadNews($news_id))
                $this->_redirect($this->getUrl());

            $tag = $request->getPost('tag');

            if ($request->getPost('add')) {
                $news->addTags($tag);
                $this->messenger->addMessage('添加标签');
            }
            else if ($request->getPost('delete')) {
                $news->deleteTags($tag);
                $this->messenger->addMessage('删除标签');
            }

            $this->_redirect($this->getUrl('preview') . '?id=' . $news->getId());
        }
		
        public function addAction()
        {
            $request = $this->getRequest();
            $news_id = (int) $this->getRequest()->getQuery('id');

            $fp = new FormProcessor_NewsAdd($this->db,
                                         $this->identity->user_id,
                                         $news_id);
			//无参数 添加新新闻
            if ($request->isPost()) {		
                if ($fp->process($request)) {
                    $url = $this->getUrl('preview') . '?id=' . $fp->news->getId();
                    $this->_redirect($url);
					
                }
            }
			//有参数 找到对应新闻 修改新闻
            if ($fp->news->isSaved()) {
                $this->breadcrumbs->addStep(
                     $fp->news->profile->title,
                    $this->getUrl('preview') . '?id=' . $fp->news->getId()
                );
				#$url = $this->getUrl('preview') . '?id=' . $fp->news->getId();
                #    $this->_redirect($url);
                $this->breadcrumbs->addStep('修改新闻');
				
            }
			//有参数 找不到对应新闻 添加新新闻
            else
                $this->breadcrumbs->addStep('添加新闻');
            $this->view->fp = $fp;
        }
		
        public function manageAction()
        {
            $this->breadcrumbs->addStep('新闻管理',$this->getUrl('manage','news'));
        }
		
        public function tagsrainkAction(){//标签排序API
            $request = $this->getRequest();
            $raink = Zend_Json::decode($request->getPost('raink'));
            foreach ($raink as $k => $v) {
                $sql = "update news_tags set raink = $v where tag = \"$k\"";
                $this->db->query($sql);
            }
            $this->sendJson("排序成功");
        }

		public function previewAction(){
			$news_id = (int) $this->getRequest()->getQuery('id');
			
			$news = new DatabaseObject_News($this->db);
			 if (!$news->loadNews($news_id))
                $this->_redirect($this->getUrl());
			if($news->status=="D" && !$this->admin){
				$this->_redirect("/pro.html");
			}
			else
			$this->breadcrumbs->addStep($news->profile->title);
			$this->view->news = $news;
		}
		  public function setstatusAction()
        {	
            $request = $this->getRequest();
            $news_id = (int) $request->getPost('id');

            $news = new DatabaseObject_News($this->db);
            if (!$news->loadNews($news_id))
                $this->_redirect($this->getUrl());

            // URL to redirect back to
            $url = $this->getUrl('preview') . '?id=' . $news->getId();

            if ($request->getPost('edit')) {
                $this->_redirect($this->getUrl('add') . '?id=' . $news->getId());
            }
            else if ($request->getPost('publish')) {
                $news->sendLive();
                $news->save();

                $this->messenger->addMessage('新闻上线');
            }
            else if ($request->getPost('unpublish')) {
                $news->sendBackToDraft();
                $news->save();

                $this->messenger->addMessage('新闻下线');
            }
            else if ($request->getPost('delete')) {
                $news->delete();

                // Preview page no longer exists for this page so go back to index
                $url = $this->getUrl();

                $this->messenger->addMessage('新闻删除');
            }

            $this->_redirect($url);
        }
		
		public static function GetusersCount($db, $options)
        {
            $select = self::_GetBaseQuery($db, $options);
            $select->from(null, 'count(*)');

            return $db->fetchOne($select);
        }
		public static function GetUsers($db,$options=array())
		{
			$defaults = array(
                'offset' => 0,
                'limit' => 0,
                'order' => 'p.user_id desc'
            );
			foreach ($defaults as $k => $v) {
                $options[$k] = array_key_exists($k, $options) ? $options[$k] : $v;
            }
			$select = self::_GetBaseQuery($db, $options);
			$select->from(null, 'p.*');
			if ($options['limit'] > 0)
                $select->limit($options['limit'], $options['offset']);

            $select->order($options['order']);
			$data = $db->fetchAll($select);
			$news = self::BuildMultiple($db, __CLASS__, $data);
            $news_ids = array_keys($news);
            if (count($news_ids) == 0)
                return array();

			/*$profiles = Profile::BuildMultiple(
                $db,
                'Profile_News', 
                array('news_id' => $news_ids)
            );
            foreach ($news as $news_id =>$new) {
                if (array_key_exists($news_id, $profiles)
                        && $profiles[$news_id] instanceof Profile_News) {
					$news["$news_id"]->profile = $profiles["$news_id"];
                }
                else {
                    $news["$news_id"]->profile->setNewsId("$news_id");
                }
				}*/
			return $news;
		}
		public static function _GetBaseQuery($db, $options)
        {
            // initialize the options
            $defaults = array(
                'user_id' => array(),
                'from'    => '',
                'to'      => ''
            );

            foreach ($defaults as $k => $v) {
                $options[$k] = array_key_exists($k, $options) ? $options[$k] : $v;
            }

            // create a query that selects from the blog_posts table
            $select = $db->select();
            $select->from(array('p' => 'users'), array());
			
            // filter the records based on the start and finish dates
            if (strlen($options['from']) > 0) {
                $ts = strtotime($options['from']);
                $select->where('p.ts_created >= ?', date('Y-m-d H:i:s', $ts));
            }

            if (strlen($options['to']) > 0) {
                $ts = strtotime($options['to']);
                $select->where('p.ts_created <= ?', date('Y-m-d H:i:s', $ts));
            }

            // filter results on specified user ids (if any)
            if (count($options['user_id']) > 0)
                $select->where('p.user_id in (?)', $options['user_id']);

            return $select;
        }
	}
?>
