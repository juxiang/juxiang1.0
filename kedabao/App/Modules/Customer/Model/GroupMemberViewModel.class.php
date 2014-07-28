<?php 
class GroupMemberViewModel extends ViewModel{
	public $viewFields=array(		
		'member'=>array('_table'=>'members','uid'=>'mid','username','score'),		
		'groups'=>array('_table'=>'auth_group_access','uid','group_id','_on'=>'member.uid=groups.uid')
		);
}
 ?>