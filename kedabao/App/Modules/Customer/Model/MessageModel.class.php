<?php
	class MessageModel extends RelationModel{

		protected $_link=array(
			'Cats'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'Cats',
          		'foreign_key'=>'cid',
				'mapping_name'=>'cats',
				'mapping_fields'=>array('id','cname'),
				'as_fields'=>'cname',
			),
		);
		
	}
?>
