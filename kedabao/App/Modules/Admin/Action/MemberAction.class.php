<?php 
class MemberAction extends CommonAction{
	//添加会员
	public function addHandle(){
		$data['uid'] =I('uid');
		$data['username']=I('username');
		$data['password']=I('password','');
		$data['company']=I('company');
		$data['content']=I('content');
		$data['score']=I('score','0');
		//所属角色id
		//$groupName=I("groupName");
		$m=D('Members');
		if (!$m->create()){
			$this->error($m->getError());
		}else{
		//p($data);die;
		$res=$m->add($data);
		if($res){
			$this->success('添加成功!');
		}else{
			$this->error('添加失败');
		}
		}
	}

	//会员列表
	public function memberList(){
		$m=M('members');
		//总记录数
		$count=$m->count();
		import('ORG.Util.Page');// 导入分页类
		//每页显示多少条记录
		$page=new Page($count,8);
		//分页栏每页显示的页数
		$page->rollPage='9';
		//设置显示排列样式,默认是不显示总记数,也就是%HEADER%
		//$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
		$where=array(
			'del'=>0
		);
		$show=$page->show();
		$data=$m->field('password',true)->limit($page->firstRow.','.$page->listRows)->order('uid asc')->where($where)->select();
		$this->assign('data',$data);
		$this->assign('num',$page->firstRow);
		$this->assign('page',$show);
		$this->display();
	}

	//添加会员页面
	public function memberAdd(){
		/* $m=M('auth_group');
		$data=$m->where('status=1')->field('id,title')->select();
		$this->data=$data; */
		$m=M('members');
		$da=$m->field('uid')->order("uid desc")->find();
		$this->data=$da['uid']+1;
		$this->display();
	}
	//用户更新页面
	public function memberUpdate(){
		$m=M('members');
		$where=array(
			'uid' =>I('uid'),
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
		if (!$m->create()){
			$this->error($m->getError());
		}else{
		$res=$m->where($where)->save($data);
		if($res) $this->success("修改成功",U(GROUP_NAME.'/Member/memberList'));
		else	$this->error("修改失败");
		}
	}
	//删除会员
	public function deleteHandle(){
		//dump($_GET);
		$where['uid']=I('uid');
		$m=M('members');
		$data=array(
			'del'=>1
		);
		$result=$m->where($where)->save($data);
		if($result){
			$this->success("删除成功!");
		}else{
			$this->error('删除失败!');
		}
	}
	//客户选择
	public function memberSelect(){
		$m=M('members');
		$count=$m->count();
		$where=array(
			'del'=>0
		);
		import('ORG.Util.Page');
		$page=new Page($count,8);
		$show=$page->show();
		$this->list=$m->limit($page->firstRow.','.$page->listRows)->order('uid asc')->where($where)->select();
		$this->assign('page',$show);
		$this->display();
	}
	//客户选择完成后跳转
	public function memberRedirect(){
		session('uid',I('uid'));
		redirect(U('Customer/Index/index'));
	}
}
 ?>