<?php 
class RuleViewModel extends ViewModel{
	public $viewFields=array(		
		'rule'=>array('_table'=>'auth_rule','id','name','title','type','condition'=>'term','status','mid'),
		//condition必须别名,否则出错
		'modules'=>array('moduleName','_on'=>'rule.mid=modules.id')
		);
}
 ?>