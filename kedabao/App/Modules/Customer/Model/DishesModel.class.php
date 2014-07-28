<?php
	class DishesModel extends RelationModel{
   
		protected $_link=array(
			'Cats'=> array(  
     			'mapping_type'=>BELONGS_TO,
          		'class_name'=>'cats',
          		'foreign_key'=>'cid',
				'mapping_name'=>'catory',
				'mapping_fields'=>'cname,wx_cats',
				'as_fields'=>'cname,wx_cats'
			),
		);
		
		protected $_validate=array(
			array('wx_cats','require','微信二级菜单不存在，请在‘微信管理’中，添加‘微信二级菜单’！'),
			array('cats','require','请选择‘分类’！'),
			array('dname','require','请输入‘产品名’！'),
			array('dname','','产品名已存在！',1,'unique'),
		);
	}
?>
