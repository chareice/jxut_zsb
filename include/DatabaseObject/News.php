<?php
    class DatabaseObject_News extends DatabaseObject
    {
        public $profile = null;

        const STATUS_DRAFT = 'D';
        const STATUS_LIVE  = 'L';

        public function __construct($db)
        {
            parent::__construct($db, 'news', 'news_id');

            $this->add('user_id');
            $this->add('url');
            $this->add('ts_created', time(), self::TYPE_TIMESTAMP);
            $this->add('status', self::STATUS_DRAFT);

            $this->profile = new Profile_News($db);
        
		}
		

        protected function preInsert()
        {
            $this->url = $this->generateUniqueUrl($this->profile->title);
            return true;
        }

        protected function postLoad()
        {
            $this->profile->setNewsId($this->getId());
            $this->profile->load();
        }

        protected function postInsert()
        {
            $this->profile->setNewsId($this->getId());
            $this->profile->save(false);
			
			$this->addToIndex();
            
			return true;
        }

        protected function postUpdate()
        {
            $this->profile->save(false);
            $this->addToIndex();
			return true;
        }

        protected function preDelete()
        {
            $this->profile->delete();
			$this->deleteAllTags();
            $this->deleteFromIndex();
			return true;
        }
		public function loadNews($news_id){
			$news_id = (int) $news_id;
			if($news_id<=0)
				return false;
			$query = sprintf(
                'select %s from %s where news_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $news_id
            );
			return $this->_load($query);
			#else $this->news->load($news_id);
		}
        public function loadForUser($user_id, $news_id)
        {
            $news_id = (int) $news_id;
            $user_id = (int) $user_id;

            if ($news_id <= 0 || $user_id <= 0)
                return false;

            $query = sprintf(
                'select %s from %s where user_id = %d and news_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $user_id,
                $news_id
            );

            return $this->_load($query);
        }

        public function sendLive()
        {
            if ($this->status != self::STATUS_LIVE) {
                $this->status = self::STATUS_LIVE;
                $this->profile->ts_published = time();
            }
        }

        public function isLive()
        {
            return $this->isSaved() && $this->status == self::STATUS_LIVE;
        }

        public function sendBackToDraft()
        {
            $this->status = self::STATUS_DRAFT;
        }
		  
		  public function getTags()
        {
            if (!$this->isSaved())
                return array();

            $query = 'select tag from news_tags where news_id = ?';

            // sort tags alphabetically
            $query .= ' order by lower(tag)';

            return $this->_db->fetchCol($query, $this->getId());
        }
		public static function getAllTags($db)
        {
            $query = 'select  DISTINCT(tag) from news_tags';

            // sort tags alphabetically
            $query .= ' order by raink,lower(tag)';
            
            return $db->fetchCol($query);
        }
        public function hasTag($tag)
        {
            if (!$this->isSaved())
                return false;

            $select = $this->_db->select();
            $select->from('news_tags', 'count(*)')
                   ->where('news_id = ?', $this->getId())
                   ->where('lower(tag) = lower(?)', trim($tag));

            return $this->_db->fetchOne($select) > 0;
        }

        public function addTags($tags)
        {
            if (!$this->isSaved())
                return;

            if (!is_array($tags))
                $tags = array($tags);

            // first create a clean list of tags
            $_tags = array();
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (strlen($tag) == 0)
                    continue;

                $_tags[strtolower($tag)] = $tag;
            }

            // now insert each into the database, first ensuring
            // it doesn't already exist for the current post
            $existingTags = array_map('strtolower', $this->getTags());

            foreach ($_tags as $lower => $tag) {
                if (in_array($lower, $existingTags))
                    continue;

                $data = array('news_id' => $this->getId(),
                              'tag' => $tag);

                $this->_db->insert('news_tags', $data);
            }
			$this->addToIndex();
        }

        public function deleteTags($tags)
        {
            if (!$this->isSaved())
                return;

            if (!is_array($tags))
                $tags = array($tags);

            $_tags = array();
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if (strlen($tag) > 0)
                    $_tags[] = strtolower($tag);
            }

            if (count($_tags) == 0)
                return;

            $where = array('news_id = ' . $this->getId(),
                           $this->_db->quoteInto('lower(tag) in (?)', $tags));

            $this->_db->delete('news_tags', $where);
			$this->addToIndex();
        }

        public function deleteAllTags()
        {
            if (!$this->isSaved())
                return;

            $this->_db->delete('news_tags', 'news_id = ' . $this->getId());
        }

        public static function GetPostsCount($db, $options)
        {
            $select = self::_GetBaseQuery($db, $options);
            $select->from(null, 'count(*)');

            return $db->fetchOne($select);
        }

        protected function generateUniqueUrl($title)
        {
           $url = urlencode($title);
		   
            if (strlen($url) == 0)
                $url = 'news';


            // find sitmilar URLs
            $query = sprintf("select url from %s where user_id = %d and url like ?",
                             $this->_table,
                             $this->user_id);

            $query = $this->_db->quoteInto($query, $url . '%');
            $result = $this->_db->fetchCol($query);


            // if no matching URLs then return the current URL
            if (count($result) == 0 || !in_array($url, $result))
                return $url;

            // generate a unique URL
            $i = 2;
            do {
                $_url = $url . '-' . $i++;
            } while (in_array($_url, $result));

            return $_url;
        }
		//-----------------------------------------------------------------------------------------
		public function getIndexableDocument()
        {	Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
            Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
			$doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('news_id',
                                                             $this->getId()));

            $fields = array(
                'title'     => $this->segment($this->profile->title),
                //'content'   => strip_tags($this->profile->content),
                //'published' => $this->profile->ts_published,
                'tags'      => join(' ' , $this->getTags())
				
			);
            foreach ($fields as $name => $field) {
                $doc->addField(
                    Zend_Search_Lucene_Field::UnStored($name,$field, "utf-8")
                );
            }

            return $doc;
        }

        public static function getIndexFullpath()
        {
            $config = Zend_Registry::get('config');

            return sprintf('%s/search-index',
                           $config->paths->data);
        }

        protected function addToIndex()
        {
            try {
                $index = Zend_Search_Lucene::open(self::getIndexFullpath());
            }
            catch (Exception $ex) {
                self::RebuildIndex();
                return;
            }

            try {
                $query = new Zend_Search_Lucene_Search_Query_Term(
                    new Zend_Search_Lucene_Index_Term($this->getId(), 'news_id')
                );

                $hits = $index->find($query);
                foreach ($hits as $hit)
                    $index->delete($hit->id);

                if ($this->status == self::STATUS_LIVE)
                    $index->addDocument($this->getIndexableDocument());

                $index->commit();
            }
            catch (Exception $ex) {
                $logger = Zend_Registry::get('logger');
                $logger->warn('Error updating document in search index: ' .
                              $ex->getMessage());
            }
        }

        protected function deleteFromIndex()
        {
            try {
                $index = Zend_Search_Lucene::open(self::getIndexFullpath());
                $query = new Zend_Search_Lucene_Search_Query_Term(
                    new Zend_Search_Lucene_Index_Term($this->getId(), 'news_id')
                );

                $hits = $index->find($query);
                foreach ($hits as $hit)
                    $index->delete($hit->id);

                $index->commit();
            }
            catch (Exception $ex) {
                $logger = Zend_Registry::get('logger');
                $logger->warn('Error removing document from search index: ' .
                              $ex->getMessage());
            }
        }

        public static function RebuildIndex()
        {
            try {
                $index = Zend_Search_Lucene::create(self::getIndexFullpath());
                $options = array('status' => self::STATUS_LIVE);
                                 $posts = self::GetNews(Zend_Registry::get('db'),
                                 $options);

                foreach ($posts as $post) {
                    $index->addDocument($post->getIndexableDocument());
                }
                $index->commit();
            }
            catch (Exception $ex) {
                $logger = Zend_Registry::get('logger');
                $logger->warn('Error rebuilding search index: ' .
                              $ex->getMessage());
            }
        }//----------------------------------------------------------------------------------------
		public static function GetnewsCount($db, $options)
        {
            $select = self::_GetBaseQuery($db, $options);
            $select->from(null, 'count(*)');

            return $db->fetchOne($select);
        }
		public static function GetNews($db,$options=array())
		{
			$defaults = array(
                'offset' => 0,
                'limit' => 0,
                'order' => 'p.ts_created desc'
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
			$profiles = Profile::BuildMultiple(
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
				}
			//print_r($news);
			return $news;
		}
		public static function _GetBaseQuery($db, $options)
        {
            // initialize the options
            $defaults = array(
                'user_id' => array(),
                'from'    => '',
                'to'      => '',
				'tag'     => '',
				'status'  => ''
            );

            foreach ($defaults as $k => $v) {
                $options[$k] = array_key_exists($k, $options) ? $options[$k] : $v;
            }

            // create a query that selects from the blog_posts table
            $select = $db->select();
            $select->from(array('p' => 'news'), array());
            // filter the records based on the start and finish dates
            if (strlen($options['from']) > 0) {
                $ts = strtotime($options['from']);
                $select->where('p.ts_created >= ?', date('Y-m-d H:i:s', $ts));
            }
			
			if (!$options['status'])
				$select->where('p.status = ?', self::STATUS_LIVE);
            if (strlen($options['to']) > 0) {
                $ts = strtotime($options['to']);
                $select->where('p.ts_created <= ?', date('Y-m-d H:i:s', $ts));
            }

            // filter results on specified user ids (if any)
            if (count($options['user_id']) > 0)
                $select->where('p.user_id in (?)', $options['user_id']);
			
			$options['tag'] = trim($options['tag']);
            if (strlen($options['tag']) > 0 && $options['tag']) {
                $select->joinInner(array('t' => 'news_tags'),
                                   't.news_id = p.news_id',
                                   array())
                       ->where('t.tag = ?', $options['tag']);
            }

            return $select;
        }
		public function getTeaser($length)
        {
            require_once('Smarty/plugins/modifier.truncate.php');
	  $temp = smarty_modifier_truncate(strip_tags($this->profile->content),$length);
	  $title = preg_replace('/[\n\r\t]/', ' ', $temp);
         return $title; 
	//return smarty_modifier_truncate(strip_tags($this->profile->content),$length);
        }
    }
?>