<?php
	class RegisterAction extends Action{
		public function reg(){
			$this->display();
		}
		//检查用户是否注册过
		public function checkName(){
			$username=$_GET['username'];
			$user=M('admin');
			$where['name']=$username;
			$count=$user->where($where)->find();
			//dump($count);
			if($count){
				echo false;
			}else{
				echo true;
			}
		}
		//注册
		public function doReg(){
		
			$user=D('admin');
			if(!$user->create()){
				$this->error($user->getError());
			}
		
			$lastId=$user->add();
			if($lastId){
				$this->redirect('Index/index');
			}else{
				$this->error('用户注册失败');
			}

		}
	}
?>
