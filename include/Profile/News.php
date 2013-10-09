<?php
    class Profile_News extends Profile
    {
        public function __construct($db, $news_id = null)
        {
            parent::__construct($db, 'news_profile');

            if ($news_id > 0)
                $this->setNewsId($news_id);
        }

        public function setNewsId($news_id)
        {
            $filters = array('news_id' => (int) $news_id);
            $this->_filters = $filters;
        }
    }
?>
