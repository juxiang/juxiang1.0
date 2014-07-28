<?php
class AndroidAction extends Action{
	function loginhandle(){
		$data=I('get.');
		$where=array(
			'username' =>$data['username'],
			'password' =>$data['password'],
		);
		//p($data);die;
		$res=M('members')->where($where)->find();
		if($res)
			echo 1;
		else
			echo 0;
	}
	function index(){
		redirect(U('loginhandle',array('username' =>1,'password'=>2)));
		echo $res;
	}
	function register(){
		if(IS_GET){
		$data=array(
			'username'=>I('get.username'),
			'password'=>I('get.password'),
		);
		$where=array(
			'username'=>$data['username'],
			);
		$r=M('members')->where($where)->find();
		//dump($data);die;
		if($r){
			echo 0;//用户已注册
		}else{
			$res=M('members')->add($data);
			if($res){
				echo 1;//用户添加成功
			}else{
				echo 2;//用户添加失败
			}
		}
		}else{
			echo "不可访问！";
		}
	}
}

?>