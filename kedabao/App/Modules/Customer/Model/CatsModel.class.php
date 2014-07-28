<?php
	class CatsModel extends RelationModel{

		protected $_link=array(
			'Dishes'=> array(  
     			'mapping_type'=>HAS_MANY,
          		'class_name'=>'Dishes',
          		'foreign_key'=>'cid',
				'mapping_name'=>'dishes',
				'mapping_fields'=>'dname,picpath,url,isset',
				'condition' =>'isset=1',
				'as_fields'=>'dname',
			),
		);
	}
?>
