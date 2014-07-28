<?php
	class ProdisplayModel extends Model{
		protected $_validate=array(
			array('company','require','请选择‘公司名’！'),
			array('did','require','请选择‘分 类’！'),
			array('pid','require','请选择‘产品名’！',1),
			
			array('introduce','require','请输入‘产品简介’！'),
			array('table','require','请输入‘产品性能表’！'),
		);
	}
?>
