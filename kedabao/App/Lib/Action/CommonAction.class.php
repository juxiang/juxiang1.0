<?php
	class CommonAction extends Action{
		Public function _initialize(){
   			// 初始化的时候检查用户权限
			//p($_SESSION);die;
   			if(!isset($_SESSION['uid']) || $_SESSION['uid']==''){
				//p($_SESSION);
				$this->redirect(GROUP_NAME.'/Login/login');
			}
			/* if(!$a=authCheck(MODULE_NAME."/".ACTION_NAME,session('uid'))){
				$this->error('你没有权限');
			} */
		}


	}
?>
