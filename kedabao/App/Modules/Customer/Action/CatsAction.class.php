<?php
	class CatsAction extends CommonAction{

		public function index(){
			$cat=M('cats');
			import('ORG.Util.Page');// 导入分页类
			$count=$cat->where('uid='.session('uid'))->count();//获取数据的总数
			$page  = new Page($count,8);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			$cats=$cat->limit($page->firstRow.','.$page->listRows)->order('wx_cats')->where('uid='.session('uid'))->select();
			//p($cats);die;
			$this->assign('cats',$cats);
			$this->assign('show',$show);
			$this->display();
		}
		public function add(){
			$wx_cat=M('wx_button2');
			$this->wxcats=$wx_cat->where('uid='.session('uid'))->field('id,name2')->select();
			//$this->wxcats=arr_unique($wx_cats);
			//p($_SESSION);
			//p($wxcats);die;
			$this->display();
		}
		public function doadd(){
			$cats=M('cats');
			$cat['wx_cats']=$_POST['wx_cats'];
			$cat['cname']=$_POST['cats'];
			$cat['uid']=session('uid');
			$lastc=$cats->add($cat);
			if($lastc){
				$this->success('分类添加成功');
			}else{
				$this->error('分类添加失败');
			}
		}
		public function update(){
			$cats=M('cats');
			$cat['cid']=$_GET['cid'];
			//var_dump($_GET['cid']);
			$cat['wx_cats']=$_POST['wx_cats'];
			$cat['cname']=$_POST['cats'];
			$lastc=$cats->where("id='".$cat['cid']."'")->save($cat);
			if($lastc){
				$this->success('分类更新成功');
			}else{
				$this->error('分类更新失败');
			}
		}
		public function delete(){
			$cats=M('cats');
			$cat['cid']=$_GET['cid'];
			if(M('dishes')->where('cid='.$cat['cid'])->find()){
				$this->error('分类中还有产品，请先删除产品！');
				exit;
			}
			$lastc=$cats->where("id='".$cat['cid']."'")->delete();
			if($lastc){
				$this->success('删除成功');
			}else{
				$this->error('删除失败');
			}
		}
	}
?>
