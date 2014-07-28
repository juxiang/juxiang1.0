<?php
	class Wx_button2Model extends Model{
		protected $_validate=array(
			array('name2','require','请输入‘菜单名’！'),
			//array('url','url','菜单跳转链接不正确，请按照http://www.***.com的格式填写！'),
			//array('url2','url','菜单跳转链接不正确，请按照http://www.***.com的格式填写！'),
			array('bid','require','上级菜单不可用，请到“一级菜单”设置！'),
		);
	}
?>
