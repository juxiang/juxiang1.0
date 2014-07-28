<?php
class ProductRelationModel extends RelationModel{
	
	protected $tableName='prodisplay';
	protected $_link=array(
			'Dishes'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'dishes',
          		'foreign_key'=>'pid',
				'mapping_name'=>'dishes',
				'mapping_fields' =>'picpath',
				'as_fields' =>'picpath'
			),
		);
}
?>