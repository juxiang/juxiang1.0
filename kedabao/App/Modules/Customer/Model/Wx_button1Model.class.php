<?php
	class Wx_button1Model extends RelationModel{

		protected $_link=array(
			'Wx_button2'=> array(  
     			'mapping_type'=>HAS_MANY,
          		'class_name'=>'wx_button2',
          		'foreign_key'=>'bid',
				'mapping_name'=>'button2',
				'mapping_fields'=>'id,key,url,type,name2,sort',
			),
		);
		protected $_validate=array(
			array('name1','require','请输入‘菜单名’！'),
			//array('url','url','菜单跳转链接不正确，请按照http://www.***.com的格式填写！',2),
			//array('url1','url','菜单跳转链接不正确，请按照http://www.***.com的格式填写！',2),
		);
	}
?>
