<?php 
class ConnectAction extends CommonAction{
	function index(){
		$c=M('connect');
		$where=array(
			'uid' =>session('uid'),
		);		
		$this->list=$c->where($where)->find();
		$this->display();
	}
	function update(){
		$c=M('connect');
		$data=I('post.');
		$where=array(
			'uid' =>session('uid'),
		);
		if($_FILES){
			$files=uploadfile($_FILES);
			foreach($files as $k=>$v){
				$data[$v['key']]=substr($v['savepath'],1).'s_'.$v['savename'];
			}
		}
		$r=$c->where($where)->find();
		if($r)
		{
			$res=$c->where($where)->save($data);
			if($res) $this->success("修改成功！");
			else $this->error("修改失败!");
		}else{
			$res=$this->add($data);
			if($res) $this->success("添加成功！");
			else $this->error("添加失败!");
		}
	}
	function add($data){
		$c=M('connect');
		$data['cretime']=time();
		$data['uid']=session('uid');
		$res=$c->add($data);
		if($res) return true;
		else return false;
	}
}
?>