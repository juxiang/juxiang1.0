<?php
class ProdisplayAction extends Action {
	function index(){
		if(!$list=S('prodisplay_list')){
		$pid=$_GET['pid'];
		$where=array(
			'pid' =>$pid,
			'uid' =>$_GET['uid'],
		);
		$list=D('ProductRelation')->relation(true)->where($where)->select();
		S('prodisplay_list',$list,2);
		}
		$this->list=$list;
		$this->display();
	}
}
?>