<?php
class MembersModel extends Model{
	protected $_validate=array(
		array('username','','客户名已存在！','0','unique',1), 
		array('password','require','密码不可以为空！'), 
		array('company','require','公司名不可以为空！'), 
	);
}

?>