<?php
	class DishesAction extends CommonAction{
		public function index(){
			$dish=D('Dishes');
			$cats=D('Cats');
			import('ORG.Util.Page');// 导入分页类
			$count=$dish->where('uid='.session('uid'))->count();//获取数据的总数
			$page  = new Page($count,8);//
			$page->setConfig('header','条信息');
			$show=$page->show();//返回分页信息
			//$dishes=$dish->join('LEFT JOIN cats ON dishes.cid= cats.id')->select();
			$dishes=$dish->relation(true)->limit($page->firstRow.','.$page->listRows)->order('cid')->where('uid='.session('uid'))->select();
			//var_dump($dishes);
			$this->assign('dishes',$dishes);
			$this->assign('show',$show);
			$this->display();
		}
		public function add(){
			$this->display();
		}
		public function doadd(){
			$dishes=D('Dishes');
			//$dish['wx_cats']=$_POST['wx_cats'];
			$dish['cid']=$_POST['cats'];
			$dish['dname']=$_POST['dname'];
			$dish['uid']=session('uid');
			//p($dishes->create());die;
			if (!$dishes->create()){
				$this->error($dishes->getError());
			}else{
			if (!empty($_FILES['picpath']['name'])) {	
			//如果有文件上传 上传附件
				$info=uploadfile();
				$dish['picpath']=substr($info[0]['savepath'],1).'s_'.$info[0]['savename'];
				//p($dish);die;
			}
			else{
				$this->error('没有添加图片！');
			}
			if($info){
			$lastc=$dishes->add($dish);
			if($lastc){
				$this->success('产品信息添加成功');
			}else{
				$this->error('产品信息添加失败');
			}
			}
			}
		}
		public function update(){
			$dishes=D('Dishes');
			$where=array('id'=>$_GET['did']);
			$data=array(
					'dname' =>$_POST['dname']
			);
			if (!$dishes->create()){
				$this->error($dishes->getError());
			}else{
			$lastc=$dishes->where($where)->save($data);
			if($lastc){
				$this->success('更新成功');
			}else{
				$this->error('更新失败');
			}
			}
		}
		public function delete(){
			$dishes=M('dishes');
			$dish['did']=$_GET['did'];
			$where=array(
				'id' => $dish['did'],
				'isset' =>0
			);
			$lastc=$dishes->where($where)->delete();
			if($lastc){
				$this->success('删除成功');
			}else{
				$this->error('请先删除该产品详细信息！');
			}
		}
		public function getcats(){
			$cats=M('cats');
			$cat['wx_cats']=$_GET['wxcats'];
			//dump($cat['wx_cats']);die;
			$where=array(
				'wx_cats'=>$cat['wx_cats'],
				'uid'=>session('uid'),
				);
			$list=$cats->where($where)->field('cname,id')->select();
			$list=$this->arr_unique($list);
			$list=$this->var_urlencode($list);
			echo json_encode($list);
		}
		public function getwxcats(){
			$cats=M('cats');
			$dish['wx_cats']=$_GET['wx_cats'];
			$list=$cats->where('uid='.session('uid'))->field('wx_cats')->select();
			//var_dump($list);
			$list=$this->arr_unique($list);
			$list=$this->var_urlencode($list);
			echo json_encode($list);
		}
		public function var_urlencode($var) {
			if (empty ( $var )) {
			return false;
			}
			// 判断是否为数组
			if(is_array ($var)){
			foreach ($var as $k => $v ) {
			// is_scalar : 检测变量是否为标量 
			if (is_scalar ($v)) {  // if用来处理不是数组的情况
			$var [$k] = urlencode ($v );
			}
			else {//else用来处理数组
			$var [$k] = $this->var_urlencode ( $v );
			}
			}
			}else {//用来处理数组
			$var = urlencode ( $var );
			}
			return $var;
		}
		public function getproducts(){
			$dish=M('dishes');
			$where=array(
				'cid'=>	$_GET['cats'],
				'uid' =>session('uid'),
			);
			$list=$dish->where($where)->field('id,cid,dname,isset')->select();
			//p($list);die;
			$list=$this->arr_unique($list);
			$list=$this->var_urlencode($list);
			echo json_encode($list);
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

	// 文件上传
	protected function doupload() {
        import('@.Common.UploadFile');
        //导入上传类
        $upload = new UploadFile();
        //设置上传文件大小
        $upload->maxSize            = 3292200;
        //设置上传文件类型
        $upload->allowExts          = explode(',', 'jpg,gif,png,jpeg');
        //设置附件上传目录
        $upload->savePath           = './Public/Uploads/Images/';
        //设置需要生成缩略图，仅对图像文件有效
        $upload->thumb              = true;
        // 设置引用图片类库包路径
        $upload->imageClassPath     = '@.Common.Image';
        //设置需要生成缩略图的文件后缀
        $upload->thumbPrefix        = 's_';  //生产2张缩略图
        //设置缩略图最大宽度
        $upload->thumbMaxWidth      = '100';
        //设置缩略图最大高度
        $upload->thumbMaxHeight     = '100';
        //设置上传文件规则
        $upload->saveRule           = 'uniqid';
        //删除原图
        $upload->thumbRemoveOrigin  = true;
        if (!$upload->upload()) {
            //捕获上传异常
            $this->error($upload->getErrorMsg());
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();
           // import('@.Common.Image');
            //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
           // Image::water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], APP_PATH.'Tpl/Public/Images/logo.png');
		   //上传至BCS
		   
            //$_POST['imagename'] = $uploadList[0]['savename'];
			//$_POST['imagepath'] = $uploadList[0]['savepath'];
			$srcFile=$uploadList[0]['savepath'].'s_'.$uploadList[0]['savename'];
			$ext=$uploadList[0]['extension'];
			$this->upBCS($srcFile,$ext);
			$upload=$uploadList;
        }
        $model  = M('pic');
        //保存当前数据对象
        $data['pname']          = $_POST['imagename'];
		$data['path']          = $_POST['imagepath'];
        $data['create_time']    =  time();
		return $list= $model->add($data);
		//return $upload;
		
        if ($list !== false) {
            $this->success('上传图片成功！');
			//var_dump($upload);
        } else {
            $this->error('上传图片失败!');
        }
		
    }
	
	//上传至BCS空间
	public function upBCS($srcFile,$ext){
	import('@.Common.bcs');
	include('__APP__/Lib/Common/bcs/bcsconf.php');

	function getfileDomain($bucket){
       if(!IS_BAE) return '';
       return 'http://'.HTTP_BAE_ENV_ADDR_BCS.'/'.strtolower($bucket);
    }
	//$tempFileName = tempnam(sys_get_temp_dir(),'tp_');
	//$sourceFileName = $srcFile;
    //file_put_contents($tempFileName, file_get_contents($sourceFileName));
    //$fileInfo = pathinfo($sourceFileName);
    $srcFile =  $srcFile;
    $ext = $ext; //这是要保存的图片后缀 TO DO 写一个方法根据原始图片获得后缀
    $fileExt = '.'.$ext; 
    $bucket=$_SESSION['BCS_Bucket']; //这里是你刚才创建的bucket：$HTTP_POST_VARS['BCS_Bucket']
	$savename=uniqid().$fileExt;
    $savePath = '/'.date('Ymd').'/'.$savename;
	$picurl='http://bcs.duapp.com/'.$bucket.$savePath;
    try{
        $bcs=new BaiduBCS();
        $response=$bcs->create_object($bucket, $savePath,$srcFile,array('acl'=>BaiduBCS::BCS_SDK_ACL_TYPE_PUBLIC_READ));
        if($response->isOK()){
            $srcFile = getfileDomain($bucket) . $savePath;
            $_POST['imagename'] = $savename;
			$_POST['imagepath'] = $picurl;
        }
    }catch(Exception $e){
        die('failed');
    }

	}
	}
?>
