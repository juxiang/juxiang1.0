<?php
// 本类由系统自动生成
class WxdisplayAction extends Action {
    public function left(){
		//$_GET['wx_cats']='恒力石化';
		$wx_cats=$_GET['wxcats'];
		$cat=D('Cats');
		$cats=$cat->relation(true)->select();
		$j=0;
		foreach($cats as $k=>$v){
			if($v['wx_cats']==$wx_cats){
				$value[$j]=$v;
				$j++;
			}else{
				unlink($v);
			}
		}
		//var_dump($value);
		$this->assign('list',$value);
		$this->display();
	}
	public function index(){
		//if(!$value=S('wxdisplay_list')){
		//$wx_cats=mb_convert_encoding($_GET['wxcats'], "UTF-8", "gb2312");
		$wx_cats=$_GET['wxcats'];
		$uid=$_GET['uid'];
		$cat=D('Cats');
		$cats=$cat->relation(true)->where('uid='.$uid)->select();
		//dump($cats);die;
		$j=0;
		foreach($cats as $k=>$v){
			if($v['wx_cats']==$wx_cats){
				$value[$j]=$v;
				$j++;
			}else{
				unlink($v);
			}
		}
		//S('wxdisplay_list',$value,2);//缓存
		//}
		//var_dump($value[0]['dishes']);die;
		$this->assign('list',$value);
		$this->display();
	}
	public function main(){
		$wx_cats=$_GET['wxcats'];
		$cat=D('Cats');
		$cats=$cat->relation(true)->select();
		$j=0;
		foreach($cats as $k=>$v){
			if($v['wx_cats']==$wx_cats){
				$value[$j]=$v;
				$j++;
			}else{
				unlink($v);
			}
		}
		//var_dump($value);
		$this->assign('list',$value);
		$this->display();
	}
}
?>