<?php 
class MemberAction extends CommonAction{
	//用户更新页面
	public function memberList(){
		$m=M('members');
		$where=array(
			'uid' =>session('uid'),
		);
		$data=$m->where($where)->find();
		$this->data=$data;
		$this->display();
	}
	//用户更新处理
	public function Updatehandle(){
		$m=D('Members');
		$where=array(
			'uid' =>$_GET['uid']
		);
		$data=array(
			//'username' =>I('username'),
			'password' =>I('password','123'),
			'company' =>I('company'),
			'content' =>I('content')
		);
		//p($data);die;
		if (!$m->create()){
			$this->error($m->getError());
		}else{
		$res=$m->where($where)->save($data);
		if($res) $this->success("修改成功",U(GROUP_NAME.'/Member/memberList'));
		else	$this->error("修改失败");
		}
	}
}
 ?>