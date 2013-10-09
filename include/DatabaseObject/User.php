<?php
    class DatabaseObject_User extends DatabaseObject
    {
        static $userTypes = array('member'        => 'Member',
                                  'administrator' => 'Administrator');

		const STATUS_OFFLINE = 'OFF';
        const STATUS_ONLINE  = 'ON';

        public function __construct($db)
        {
            parent::__construct($db, 'users', 'user_id');

            $this->add('username');
            $this->add('password');
            $this->add('user_type', 'member');
			
            $this->add('ts_created', time(), self::TYPE_TIMESTAMP);
            $this->add('ts_last_login', null, self::TYPE_TIMESTAMP);
			$this->add('realname');
			$this->add('tel');
			$this->add('Staff_Number');
			$this->add('status', self::STATUS_OFFLINE);
            //$this->profile = new Profile_User($db);
        }
        
        public function createAuthIdentity(){
        
            $identity = new stdClass;
            $identity->user_id = $this->getId();
            $identity->username = $this->username;
			$identity->password = $this->password;
            $identity->user_type = $this->user_type;
            $identity->realname = $this->realname;
            return $identity;
        }
        public function loginSuccess(){
			$this->sendOnline();
            $this->ts_last_login = time();
            $this->save();
            $message = sprintf('%s：登录成功',$this->username); 
            $logger=Zend_Registry::get('logger');
            $logger->notice($message);
        }
		public function sendOnline(){
			$this->status = self::STATUS_ONLINE;
		}
        public function sendOffline(){
			$this->status = self::STATUS_OFFLINE;
		}
		static public function LoginFailure($username, $code = '')
        {
            switch ($code) {
                case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                    $reason = '用户名无效';
                    break;
                case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
                    $reason = '不存在的用户';
                    break;
                case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                    $reason = '密码无效';
                    break;
                default:
                    $reason = '';
            }

            $message = sprintf('%s用户%s登录失败',
                               $_SERVER['REMOTE_ADDR'],
                               $username);

            if (strlen($reason) > 0)
                $message .= sprintf(' (%s)', $reason);

            $logger = Zend_Registry::get('logger');
            $logger->warn($message);
        }

        public function __set($name, $value)
        {
            switch ($name) {
                case 'password':
                    $value = md5($value);
                    break;

                case 'user_type':
                    if (!array_key_exists($value, self::$userTypes))
                        $value = 'member';
                    break;
            }

            return parent::__set($name, $value);
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
                'order' => 'p.user_id'
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
			
			$users = self::BuildMultiple($db, __CLASS__, $data);
            
			$users_ids = array_keys($users);
            if (count($users_ids) == 0)
                return array();
				
			return $users;
		}
		public function isOnline()
        {
            return $this->isSaved() && $this->status == self::STATUS_ONLINE;
        }
		
		public static function _GetBaseQuery($db, $options)
        {
            // initialize the options
            $defaults = array(
                'user_id' => array(),
                'from'    => '',
                'to'      => '',
				'status' =>''
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
			
			if (strlen($options['status']) > 0) {
                $select->where('p.status = ?',$options['status']);
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
