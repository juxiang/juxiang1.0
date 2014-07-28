<?php
class IndexAction extends CommonAction {
    public function index(){
			//var_dump($_SESSION);die;
			$this->display();
			//var_dump($_SESSION);
	}
	public function top(){
		//$this->assign('name',$_SESSION['username']);
		$this->display();
	}
	public function main(){
		//$this->assign('name',$_SESSION['username']);
		$this->display();
	}
	public function left(){
		//获取cats,dishes表中的所有数据
		$mesc=D('Cats');
		$mesd=D('Dishes');
		import('ORG.Util.Page');// 导入分页类
		$count=$mesc->count();//获取数据的总数
		$page  = new Page($count,2);//
		$page->setConfig('header','条信息');
		$show=$page->show();//返回分页信息

		
		$arr=$mesc->relation(true)->limit($page->firstRow.','.$page->listRows)->select();
		//var_dump($arr);
		$this->assign('list',$arr);
		$this->assign('show',$show);
		$this->display();
		}
	public function right(){
		$cat=M('cats');
		$sel=$cat->select();
		//dump($sel);
		$this->assign('vo',$sel);
		$this->display();
	}
}
