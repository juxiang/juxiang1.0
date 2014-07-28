<?php
	class LoginAction extends Action{
		public function login(){
			$this->display();
		}
		public function doLogin(){
			$username=$_POST['username'];
			$password=$_POST['password'];
			/*$code=$_POST['code'];
			if(md5($code)!=$_SESSION['code']){
				$this->error('验证码不正确'.md5($code).'||'.$_SESSION['code']);
				//var_dump($code);
			}*/
			
			$user=M('members');
			$where=array(
				'username' =>$username,
				'password' =>$password,
				'del' => 0
			);
			$arr=$user->where($where)->find();
			//dump($arr);die;
			if($arr){
				$_SESSION['username']=$username;
				$_SESSION['uid']=$arr['uid'];
				//token赋值
				$wxconf=M('wxconf');
				//非管理员，进行赋值
				if($arr['uid']==100001){
					$_SESSION['admin']='admin';
				}else{
					redirect(U('Customer/Index/index'));
				}
				//p($_SESSION);die;
				$this->success('用户登录成功',U(GROUP_NAME.'/Index/index'));
			}else{
				$this->error('用户或密码错误！');
			}
		}
		//退出
		public function doLogout(){
			$_SESSION=array();
				if(isset($_COOKIE[session_name()])){
					setcookie(session_name(),'',time()-1,'/');
				}
			session_destroy();
			$this->redirect(GROUP_NAME.'/Index/index');
		}
	}
?>
