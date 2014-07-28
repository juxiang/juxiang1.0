<?php 
class AuthAction extends CommonAction{
    //权限列表
	public function accessList(){
		$m=D('RuleView');
		//$m=M('auth_rule');
		$count=$m->count();
		import('ORG.Util.Page');// 导入分页类
		$page=new Page($count,5);
		//$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$show=$page->show();
		$data=$m->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('page',$show);
		$this->assign('num',$page->firstRow);
		$this->assign('data',$data);
		$this->display();
	}

	//添加权限
	public function addHandle(){
		$m=M("auth_rule");
		$data['name']=I('ruleName');
		$data['title']=I('ruleTitle');
        //过滤方法必须为空,否则验证时会出错
		$data['condition']=I('post.condition','','');
		$data['status']=I('status');
		//$data['mid']=I('modules');
		if($m->add($data)){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
	//读取模块信息
	public function accessAdd(){
    	$m=M('modules');
    	$data=$m->select();
    	$this->assign('modules',$data);
    	$this->display();
    }

    //用户组角色管理页面
    public function groupList(){
    	$m=M('auth_group');
		$count=$m->count();
		import('ORG.Util.Page');// 导入分页类
		$page=new Page($count,5);
		//$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$show=$page->show();
		$data=$m->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
		$this->assign('page',$show);
		$this->assign('num',$page->firstRow);
		$this->assign('data',$data);
		$this->display();
    }

    //添加角色
    public function groupAddHandle(){
    	$data['title']=I('groupName');
    	$data['describe']=I('describe');
    	$data['status']=I('status');
    	$m=M("auth_group");
    	if($m->add($data)){
    		$this->success('添加成功');
    	}else{
    		$this->error('添加失败');
    	}
    }

    //角色授权页面
    public function accessSelect(){
    	//角色id
    	$group['id']=$where['id']=I('id');
    	//角色名称
    	$group['name']=I('name');
    	$m=M('auth_group');
    	//获取所有规则id
    	$ruleID=$m->field('rules')->where($where)->select();

    	$rule=D("RuleView");
    	$mid=$rule->field('mid,moduleName')->group('mid')->select();
		//dump($mid);die;
    	foreach ($mid as $v) {
    		$map['mid']=array('in',$v['mid']);
    		$map['status']='1';    		
    		$result[$v['moduleName']]=$rule->where($map)->select();
    	}
    	$this->group=$group;
    	$this->result=$result;
    	$this->ruleID=$ruleID;
    	$this->display();
    }

    //更新角色授权
    public function accessSelectHandle(){
    	$arr=I('rule');
    	$where['id']=I("groupID");
    	$data['rules']=implode(',',$arr);
    	$m=M('auth_group');
    	//更新,返回影响行数
    	$num=$m->where($where)->save($data);
    	if($num){
    		$this->success('权限更新成功!');
    	}else{
    		$this->error('权限更新失败!');
    	}
    }

    //角色组成员列表
    public function groupMember(){
    	$group['id']=$where['group_id']=I('id');
    	$group['groupName']=I('name');
    	$m=D('GroupMemberView');
    	$count=$m->where($where)->count();
		import('ORG.Util.Page');// 导入分页类
		$page=new Page($count,5);
		//$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$show=$page->show();
		$result=$m->where($where)->limit($page->firstRow.','.$page->listRows)->order('uid desc')->select();
    	$this->result=$result;
    	$this->group=$group;
    	$this->assign('page',$show);
    	$this->assign('num',$page->firstRow);
    	$this->display();
    }

    //删除权限
    public function accessDelHandle(){
       // dump($_GET);
       $where['id']=I('id');
       $m=M('auth_rule');
       $result=$m->where($where)->delete();
       if($result){
            $this->success('权限删除成功!');
       }else{
            $this->error("权限删除失败!");
       }
    }

}

 ?>