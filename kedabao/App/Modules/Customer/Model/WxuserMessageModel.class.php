<?php
class WxuserMessageModel extends Model{
	function addMessage($fromuser,$touser,$content,$uid){
		$data=array(
			'fromuser' =>$fromuser,
			'touser' =>$touser,
			'cretime' =>time(),
			'content' =>$content,
			'uid' => $uid
		);
		$w=M('wxusermessage');
		$w->add($data);
	}
}

?>