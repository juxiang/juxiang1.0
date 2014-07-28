<?php
class ConnectDisplayAction extends Action{
	function index(){
		$data=$_GET;
		$where=array(
			'uid' =>$data['uid'],
		);	
		$this->list=M('connect')->where($where)->find();
		$this->display();
	}
}
?>
