<?php
class DatabaseObject_Infomain extends DatabaseObject{

		public function __construct($db)
			{
				parent::__construct($db, 'info_main', 'info_id');

				$this->add('info_id');
				$this->add('info_title');
				$this->add('info_py');
				$this->add('info_content');
			}
		
		public function loadInfo($info_id){
			if($info_id<=0)
				return false;
			$query = sprintf(
                'select %s from %s where info_id = %d',
                join(', ', $this->getSelectFields()),
                $this->_table,
                $info_id
            );
			return $this->_load($query);
		}
	
		public static function queryact($db,$q){
			$sql = sprintf("select info_title as t,info_content as c 
							from info_main
							where info_py = '%s'",$q);
			return $db->fetchRow($sql);
		}
		public static function changeAbb($db,$abb){
			return $db->fetchCol(
			'select info_id from info_main where info_py like :abb',
			array('abb' => "%$abb%")
			);
		}
}
?>