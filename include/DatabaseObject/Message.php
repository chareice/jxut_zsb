<?php
class DatabaseObject_Message extends DatabaseObject{
	
	const STATUS_DEL = 'D';
    const STATUS_LIVE  = 'L';
		
		public function __construct($db)
			{
				parent::__construct($db, 'message', 'msg_id');

				$this->add('msg_id');
				$this->add('authid');
				$this->add('message');
				$this->add('msg_created', time(), self::TYPE_TIMESTAMP); 
				$this->add('status', self::STATUS_LIVE);
			}
		
		public function loadMessage($msg_id){
			$msg_id = (int) $msg_id;
			if($msg_id<=0)
				return false;
			$query = sprintf(
                'select %s from %s where msg_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $msg_id
            );
			return $this->_load($query);
		}
		public function senddel($id){
			if($id==$this->authid)
			$this->status = self::STATUS_DEL;
		}
}
?>