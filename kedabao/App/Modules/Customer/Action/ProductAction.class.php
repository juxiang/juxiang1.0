<?php
class ProductAction extends CommonAction {
	function index(){
		import('ORG.Util.Page');// 导入分页类
		$count=M('prodisplay')->where('uid='.session('uid'))->count();//获取数据的总数
		$page  = new Page($count,8);//
		$this->show=$page->show();//返回分页信息
		$this->products=D('ProductRelation')->limit($page->firstRow.','.$page->listRows)->order('cretime desc')->where('uid='.session('uid'))->select();
		//$products=D('ProductRelation')->relation('Dishes')->select();
		//p($products);die;
		$this->display();
	}
	function add(){
		$this->display();
	}
	function add2(){
		$d=M('dishes');
		$did=$_GET['did'];
		$r=$d->where('id='.$did)->field('isset')->find();
		//p($r);die;
		if($r['isset']==0){
		$sql="select c.id cid,c.cname,c.wx_cats,d.id did,d.dname from dishes d inner join cats c on d.cid=c.id and d.id=$did";
		$ds=M()->query($sql);
		$this->list=$ds[0];
		//p($list);die;
		$this->display();
		}else{
			redirect(U(GROUP_NAME.'/Dishes/index'));
		}
	}
	function update(){
		$id=I('get.');
		$where=array(
				'id' =>$id['id'],	
		);
		$this->products=M('prodisplay')->where($where)->select();
		$this->display();
	}
	function doadd(){
		$m=D('Prodisplay');
		$data=I('post.');
		//p($data);die;
		if($_FILES){
			$files=uploadfile($_FILES);
			foreach($files as $k=>$v){
				$data[$v['key']]=substr($v['savepath'],1).'s_'.$v['savename'];
			}
		}
		$logo=M('connect')->where('uid='.session('uid'))->field('logo')->find();
		$data['logo']=$logo['logo'];
		$wherec=array(
			'id'=>I('did'),
		);
		$whered=array(
			'id'=>I('pid'),
		);
		$data['table']=addslashes($_POST['table']);
		$data['introduce']=addslashes($_POST['introduce']);
		$data['dname']=M('cats')->where($wherec)->getField('cname');
		$data['pname']=M('dishes')->where($whered)->getField('dname');
		$data['cretime']=time();
		$data['prourl']="/Prodisplay/index/pid/".I('pid')."/uid/".session('uid');
		$data['uid']=session('uid');
		$dd['url']=$data['prourl'];
		$dd['isset']=1;//是否添加产品
		//p($data);die;
		if (!$d=$m->create()){
			$this->error($m->getError());
		}else{
		$res=$m->add($data);
		if($res){
			$r=M('dishes')->where($whered)->save($dd);
			$this->success('添加成功！');
		}else{
			$this->error('添加失败！');
		}
		}
	}
	function doupdate(){
		$id=I('get.');
		$where=array(
				'id' =>$id['id'],	
		);
		$data=I('post.');
		if($_FILES){
			$files=uploadfile($_FILES);
			foreach($files as $k=>$v){
				$data[$v['key']]=substr($v['savepath'],1).'s_'.$v['savename'];
				}
		}
		$logo=M('connect')->where('uid='.session('uid'))->field('logo')->find();
		$data['logo']=$logo['logo'];
		$wherec=array(
			'id'=>I('did'),
		);
		$whered=array(
			'id'=>I('pid'),
		);
		$data['table']=addslashes($_POST['table']);
		$data['introduce']=addslashes($_POST['introduce']);
		$data['dname']=M('cats')->where($wherec)->getField('cname');
		$data['pname']=M('dishes')->where($whered)->getField('dname');
		$data['cretime']=time();
		$data['prourl']="/Prodisplay/index/pid/".I('pid')."/uid/".session('uid');
		$dd['url']=$data['prourl'];
		$dd['isset']=1;
		$m=D('Prodisplay');
		if (!$d=$m->create()){
			$this->error($m->getError());
		}else{
		$res=M('prodisplay')->where($where)->save($data);
		if($res){
			$r=M('dishes')->where($whered)->save($dd);//将产品的设置状态和链接进行更新
			$this->success('更新成功',U('index'));
		}else{
			$this->error('更新失败！');
		}
		}
	}
	function deletepro(){
		$where=array(
				'id' =>I('id'),	
		);
		$whered=array(
			'id'=>I('pid'),
		);
		
		$d['isset']=0;//是否添加产品
		$urls=M('prodisplay')->where($where)->field('picone,pictwo,picthree')->find();
		//$urlone='.'.$urls['picone'];
		M('dishes')->where($whered)->save($d);
		$res=M('prodisplay')->where($where)->delete();
		if($res){
			$urlone='.'.$urls['picone'];
			$urltwo='.'.$urls['pictwo'];
			$urlthree='.'.$urls['picthree'];
			delImage($urlone);
			delImage($urltwo);
			delImage($urlthree);
			$this->success('删除成功！');
		}else{
			$this->error('删除失败！');
		}	
		}
}
?>