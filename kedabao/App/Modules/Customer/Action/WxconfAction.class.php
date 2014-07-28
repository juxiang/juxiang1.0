<?php
	class WxconfAction extends CommonAction{
		public function auth(){
			import('@.Common.Wechat');
			//根据uid读取配置
			$where=array(
				'uid'=>I('uid'),
			);
			$wxconf=M('wxconf');
			$wxinfo=$wxconf->where($where)->select();
			$_SESSION["wxtoken"]=trim($wxinfo[0]["wxtoken"]);
			/* 加载微信SDK */
			$weixin = new Wechat(); //这里的TOKEN是在公众平台开发者模式中配置的TOKEN
			/* 获取请求信息 */
			$data = $weixin->valid($_SESSION["wxtoken"]);
			echo $data;
		}
		public function index(){
			import('@.Common.Wechat');
			$wx_cat=M('cats');
			$wx_cats=$wx_cat->field('wx_cats')->where('uid='.session('uid'))->select();
			$wx_cats=$this->arr_unique($wx_cats);
			$this->assign('wx_cats',$wx_cats);
			$this->display();
		}
		//平台参数设置
		public function wxconf(){
			$wxconf=M('wxconf');
			$wxinfo=$wxconf->where('uid='.session('uid'))->find();
			$this->assign('wxinfo',$wxinfo);
			$this->display();
		}
		public function buttons(){
		    $button=D('Wx_button1');
			$buttons=$button->relation(true)->where('uid='.session('uid'))->order('sort asc')->select();
			foreach($buttons as $key => $value){
				$buttons[$key]['button2']=multi_array_sort($value['button2'],'sort',SORT_ASC);
			}
			//dump($buttons);die;
			$this->subtime=M('wxconf')->where('uid='.session('uid'))->field('subtime')->find();
			//p($subtime);die;
			$this->assign("buttons",$buttons);
			$this->display();
		}
		public function getbutton1(){
		    $button=M('wx_button1');
			$buttons=$button->field('id,name1,grade')->where('uid='.session('uid'))->select();
			foreach($buttons as $k=>$v){
				if($v['grade']==1){
					unlink($buttons[$k]);
				}else{
					$arr[]=$v;
				}
			}
			$buttons=$arr;
			//p($buttons);
			//var_dump($buttons);
			//echo 1234;
			echo json_encode($buttons);
		}
		public function upbutton1(){
		    $button=D('Wx_button1');
			$id1=$_GET['id1'];
			$buttons1['grade']=$_POST['grade1'];
			$buttons1['name1']=$_POST['name1'];
			$buttons1['key']=$_POST['key1'];
			$buttons1['url']=$_POST['url1'];
			$buttons1['type']=$_POST['type1'];
			$buttons1['sort']=$_POST['sort'];
			if (!$button->create()){
			$this->error($button->getError());
			}else{
			$res=$button->where("id=".$id1,'uid='.session('uid'))->save($buttons1);
			if($res){
				$this->success("更新成功！");
			}else{
				$this->error("更新失败！");
			}
			}
		}
		public function addbutton1(){
			$this->display();
		}
		public function doaddbutton1(){
			$button1=D('Wx_button1');
			$c=count($button1->where('uid='.session('uid'))->select());
			$button['grade']=$_POST['grade'];
			$button['name1']=$_POST['name1'];
			$button['key']=$_POST['key'];
			$button['url']=$_POST['url'];
			$button['type']=$_POST['type'];
			$button['uid']=session('uid');
			if (!$button1->create()){
			$this->error($button1->getError());
			}else{
			if($c<3){
				$res=$button1->add($button);
				if($res){
					$this->success("添加成功！");
				}else{
					$this->error("添加失败！");
				}
			}else{
				$this->error("一级菜单数超过3个，添加失败！");
			}
			}
		}
		public function delbutton1(){
			$id1=$_GET['id1'];
			$button1=M('Wx_button1');
			$button2=M('Wx_button2');
			$res2=$button2->where("bid=".$id1,'uid='.session('uid'))->select();
			if($res2){
				$this->error("仍有关联二级菜单信息，请先删除关联二级菜单！");
			}else{
				$res1=$button1->where('id='.$id1,'uid='.session('uid'))->delete();
				if($res1){
					$this->success("删除成功！");
				}else{
					$this->error("删除失败！");
				}
			}
		}
		public function upbutton2(){
		    $button2=D('Wx_button2');
			$id2=$_GET['id2'];
			//$buttons2['grade']=$_POST['grade2'];
			$buttons2['name2']=$_POST['name2'];
			$buttons2['key']=$_POST['key2'];
			$buttons2['url']=$_POST['url2'];
			$buttons2['type']=$_POST['type2'];
			$buttons2['sort']=$_POST['sort'];
			if (!$button2->create()){
				$this->error($button2->getError());
			}else{
			$res=$button2->where("id=".$id2,'uid='.session('uid'))->save($buttons2);
			if($res){
				$this->success("更新成功！");
			}else{
				$this->error("更新失败！");
			}
			}
		}
		public function addbutton2(){
			//获取一级菜单按钮信息
			$button=M('wx_button1');
			$buttons=$button->field('id,name1,grade')->where('uid='.session('uid'))->select();
			foreach($buttons as $k=>$v){
				if($v['grade']==1){
					unlink($buttons[$k]);
				}else{
					$arr[]=$v;
				}
			}
			$this->buttons=$arr;
			$this->display();
		}
		public function doaddbutton2(){
			$button2=D('Wx_button2');
			$button['bid']=$_POST['bid'];
			$button['name2']=$_POST['name2'];
			$button['key']=$_POST['key'];
			$button['url']=$_POST['url'];
			$button['type']=$_POST['type'];
			$button['uid']=session('uid');
			//dump($button);
			$c=count($button2->where('bid='.$button['bid'],'uid='.session('uid'))->select());
			if (!$button2->create()){
				$this->error($button2->getError());
			}else{
			//p($button);die;
			if($c<5){
				$res=$button2->add($button);
				//dump($res);die;
				if($res){
					$this->success("添加成功！");
				}else{
					$this->error("添加失败！");
				}
			}else{
				$this->error("二级菜单数超过5个，添加失败！");
			}
			}
		}
		public function delbutton2(){
			$id2=$_GET['id2'];
			//$button1=M('Wx_button1');
			$button2=M('Wx_button2');
				$res2=$button2->where("id=".$id2,'uid='.session('uid'))->delete();
				if($res2){
					$this->success("删除成功！");
				}else{
					$this->error("删除失败！");
				}
			
		}
		public function cremenu(){
			import('@.Common.Wechat');
			$wx=M('wxconf');
			$button=D('Wx_button1');
			$buttons=$button->relation(true)->where('uid='.session('uid'))->order('sort asc')->select();
			foreach($buttons as $key => $value){
				$buttons[$key]['button2']=multi_array_sort($value['button2'],'sort',SORT_ASC);
			}
			$wxconf=$wx->where('uid='.session('uid'))->find();
			$_SESSION["wx_aid"]=$wxconf["wx_aid"];
			$_SESSION["wx_secret"]=$wxconf["wx_secret"];
			$weixin = new Wechat();
			$info=$weixin->index('menu',$buttons);
			$data=array(
				'subtime'=>time()
			);
			$wx->where('uid='.session('uid'))->save($data);
			//echo $info;
			$json=json_decode($info);
			if($json['errcode']==0) $this->success('菜单生成成功！',U(GROUP_NAME.'/Wxconf/buttons'));
			else $this->error('菜单生成失败，错误码：'.$json['errcode'].',错误提示：'.$json['errmsg']);
		}
		//二维数组去重
		function arr_unique($array2D){
			foreach ($array2D as $v){
				$v = join(",",$v);  //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
				$temp[] = $v;
			 }
			$temp = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
			foreach ($temp as $k =>$v){
				$temp[$k] = explode(",",$v);   //再将拆开的数组重新组装
			}
			return $temp;
		}
		public function addfile(){
			$file = "__APP_/Conf/config2.php";
			$data='这里是我的';/*
			if (file_exists($file) == false) {
				fwrite($file, "anything you want to write to $filename.";
			}
			*/
			if(!$fso=fopen($file,'w')){
				$this->error('无法打开缓存文件.');//trigger_error
				return false;
			}
			if(!flock($fso,LOCK_EX)){//LOCK_NB,排它型锁定
				$this->error('无法锁定缓存文件.');//trigger_error
				return false;
			}
			if(!fwrite($fso,$data)){//写入字节流,serialize写入其他格式
				$this->error('无法写入缓存文件.');//trigger_error
				return false;
			}
			flock($fso,LOCK_UN);//释放锁定
			fclose($fso);
			return true;
		}

		//更新配置文件
		public function upfile($info){
			$file = CONF_PATH."config2.php";
			$data="<?php 
	return array(
		'DB_PREFIX'=>' ',
		'TMPL_L_DELIM'=>'<{',
		'TMPL_R_DELIM'=>'}>',
        'DB_TYPE'   => 'mysql',
        'DB_HOST'   => '".$info['DB_Url']."', 
        'DB_NAME'   => '".$info['DB_Name']."',
        'DB_USER'   => '".$info['BAE_AK']."',
        'DB_PWD'    => '".$info['BAE_SK']."',
        'DB_PORT'   => '".$info['DB_Port']."', 
        'DB_PREFIX' => '', 
		'TMPL_PARSE_STRING'=>array(   
		'__CSS__'=>__ROOT__.'/Public/Css',
		'__JS__'=>__ROOT__.'/Public/Js',
	),
);	
			?>";/*
			if (file_exists($file) == false) {
				fwrite($file, "anything you want to write to $filename.";
			}
			*/
			//var_dump($file);
			if(!$fso=fopen($file,'w')){
				$this->error('无法打开缓存文件.');//trigger_error
				return false;
			}
			if(!flock($fso,LOCK_EX)){//LOCK_NB,排它型锁定
				$this->error('无法锁定缓存文件.');//trigger_error
				return false;
			}
			if(!fwrite($fso,$data)){//写入字节流,serialize写入其他格式
				$this->error('无法写入缓存文件.');//trigger_error
				return false;
			}
			flock($fso,LOCK_UN);//释放锁定
			fclose($fso);
			return true;

		}
		
		public function addconf($data){
			$wxadd=D('wxconf');
			$data['uid']=session('uid');
			$data['wxurl']=__GROUP__.'/Weixin/index/uid/'.session('uid');
			$res=$wxadd->add($data);

			 if($res){
				return true;
				//$this->success('修改成功!');
			}else{
				return false;
				//$this->error('无法添加至数据库!');
			}
		}
		
		//更新数据库连接设置，云图片路径设置，微信接口验证url、token设置
		public function update(){
			$wxconf=D('wxconf');
			$wxinfo['openid']=$_POST["openid"];
			$wxinfo['wxtoken']=$_POST["wxtoken"];
			$wxinfo['wx_aid']=$_POST["wx_aid"];
			$wxinfo['wx_secret']=$_POST["wx_secret"];
			$a=$wxconf->where('uid='.$_POST["uid"])->find();
			if(empty($a)){
				$res=$this->addconf($wxinfo);
			}else{
				$wxinfo['wxurl']=U(GROUP_NAME.'/Weixin/index',array('uid'=>session('uid')));
				//p($wxinfo);die;
				$res=$wxconf->where('uid='.$_POST['uid'])->save($wxinfo);
			}
			 if($res){
				$this->success('修改成功!');
			}else{
				$this->error('修改失败!');
			}
		}

	}
?>
