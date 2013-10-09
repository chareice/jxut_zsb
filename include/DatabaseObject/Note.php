<?php
class DatabaseObject_Note extends DatabaseObject{

		public function __construct($db)
			{
				parent::__construct($db, 'users_notes', 'id');

				$this->add('id');
				$this->add('user_id');
				$this->add('title');
				$this->add('content');
			}
		
		public function load($info_k,$user_id){
			if($info_k<=0)
				return false;
			$query = sprintf(
                'select %s from %s where id = %d and user_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $info_k,
                $user_id
            );
			return $this->_load($query);
		}

		public function loadAll($user_id){
			$sql=sprintf('select title as t,content as c from %s where user_id = "%d"',$this->_table,$user_id);
			$result = $this->_db->query($sql);
			return $result->fetchAll();
		}
}
?>