<?php
class DatabaseObject_Messageto extends DatabaseObject{
		const STATUS_NEW = 'N';
		const STATUS_VIEW  = 'V';
		const STATUS_DEL  = 'D';
		public function __construct($db)
			{
				parent::__construct($db, 'message_to', 'msg_to_id');

				$this->add('msg_to_id');
				$this->add('msg_id');
				$this->add('receiver_id');
				$this->add('msg_status', self::STATUS_NEW);      
			}
		public function loadMessage($msg_to_id){
			$msg_to_id = (int) $msg_to_id;
			if($msg_to_id<=0)
				return false;
			$query = sprintf(
                'select %s from %s where msg_to_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $msg_to_id
            );
			return $this->_load($query);
		}
		public function sendview(){
			$this->msg_status = self::STATUS_VIEW;
		}
		public function senddel(){
			$this->msg_status = self::STATUS_DEL;
		}
		public static function getInMessage($db,$pa){
			$sql = sprintf("select a.authid as from_id,b.msg_to_id,c.realname,b.msg_status,UNIX_TIMESTAMP(a.msg_created) as msg_created,a.message from
							message as a,message_to as b,users as c
							where b.receiver_id = '%s' and a.msg_id = b.msg_id and a.authid = c.user_id and b.msg_status in(\"N\",\"V\") 
							order by msg_created desc 
							limit %s,%s",$pa['user_id'],$pa['offset'],$pa['limit']);
			$result = $db->fetchAll($sql);
			return $result;
		}
		public static function getInMessageCount($db,$user_id){
			 $sql = sprintf("SELECT COUNT( * )
							FROM message_to
							where receiver_id = '%s' and msg_status in(\"N\",\"V\")",$user_id);
			return $db->fetchOne($sql);
		}
		
		public static function getOutMessageCount($db,$user_id){
			 $sql = sprintf("SELECT COUNT( * )
							FROM message
							where authid = '%s' and status !=\"D\"",$user_id);
			return $db->fetchOne($sql);
		}
		public static function getOutMessage($db,$a){
			/*$sql = sprintf("select a.message as m,a.msg_id as i,UNIX_TIMESTAMP(a.msg_created) as t,c.realname as n from
					message as a,message_to as b,users as c
					where a.authid = '%s' and b.msg_id = a.msg_id and b.receiver_id = c.user_id",$user_id);*/
			
			
			$select = $db->select();
			/*$select->from(array('a'=>'message'),array('message','msg_id','UNIX_TIMESTAMP(a.msg_created) as time'))
				->join(array('b'=>'message_to'),'b.msg_id = a.msg_id')
				->join(array('c'=>'users'),'b.receiver_id = c.user_id',array('realname'));
				*/
//			$quer = $select->__toString();
			//$quer = join('a',array('1'=>'a',2,3,4));
//			DatabaseObject_News::RebuildIndex();
			//$result = $db->fetchAll($sql);
			$select->from(array('a'=>'message'),array('message as m','msg_id as i','UNIX_TIMESTAMP(a.msg_created) as t'))
				   //->join(array('b'=>'message_to'),'b.msg_id = a.msg_id','count(b.receiver_id)')
				   ->where('a.authid = ?',$a['user_id'])
				   ->where('a.status !=?','D')
				   ->order('a.msg_created desc')
				   ->limitPage($a['page'],$a['show']);
			//echo $select->__toString();
			$re = $db->fetchAll($select);
			return $re;
		}
		public static function getstatus($db, $msg_id){
			$select = $db->select();
			$select->from(array('c'=>'users'),array('realname as n'))
				   ->join(array('b'=>'message_to'),'b.receiver_id = c.user_id',array('b.msg_status as s'))
				   ->where('b.msg_id = ?',$msg_id)
				   ->order('c.user_id');
			//echo $select->__toString();
			$result = $db->fetchAll($select);
			return $result;
		}
		public static function getnewCount($db, $user_id)
        {
            $sql = sprintf("SELECT COUNT( * )
							FROM message_to
						where receiver_id = '%s' and msg_status ='%s'",$user_id,self::STATUS_NEW);
            
			return $db->fetchOne($sql);
        }
		
		public static function _GetBaseQuery($db, $options)
        {
            $defaults = array(
                'from_id' => array(),
                'from'    => '',
                'to'      => ''
            );

            foreach ($defaults as $k => $v) {
                $options[$k] = array_key_exists($k, $options) ? $options[$k] : $v;
            }

            // create a query that selects from the blog_posts table
            $select = $db->select();
            $select->from(array('p' => 'message_to'), array());

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
            if (count($options['from_id']) > 0)
                $select->where('p.from_id in (?)', $options['from_id']);

            return $select;
        }
		/*public function loadMessage_to($msg_to_id){
			$msg_to_id = (int) $msg_to_id;
			if($msg_to_id<=0)
				return false;
			$query = sprintf(
                'select %s from %s where msg_to_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $msg_to_id
            );
			return $this->_load($query);
		}*/
}
?>
