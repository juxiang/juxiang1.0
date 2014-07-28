<?php
class MembersModel extends Model{
	protected $_validate=array(
		array('username','','客户名已存在！','0','unique',1), 
		array('password','require','请输入‘密码’！'), 
		array('password','{6}','密码由字母和数字组合并且长度不能少于6位',0,'regex',3),
		array('company','require','请输入‘公司名’！'), 
	);
}

?>