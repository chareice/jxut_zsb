<?php
class DatabaseObject_Info extends DatabaseObject{

		public function __construct($db)
			{
				parent::__construct($db, 'info_2010', 'info_k');

				$this->add('info_k');
				$this->add('abb');
				$this->add('p_nm');
				$this->add('content');
			}
		
		public function loadInfo($info_k){
			if($info_k<=0)
				return false;
			$query = sprintf(
                'select %s from %s where info_k = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $info_k
            );
			return $this->_load($query);
		}
		public static function changeAbb($db,$abb){
			return $db->fetchCol(
			'select info_k from info_2010 where abb = :abb',
			array('abb' => "$abb")
			);
		}
}
?>