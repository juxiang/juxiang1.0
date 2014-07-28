<?php
	class MessageAction extends Action{
		public function doMessd(){
			$dish=M('dishes');
			
			$d['dname']=$_POST['dishes'];
			$d['cid']=$_POST['cats2'];
			$d['url']=$_POST['url'];
			if (!empty($_FILES)) {

			//如果有文件上传 上传附件
				$up=$this->doupload();
				//var_dump($up);
			}
			if($up){
			$d['picpath']=$_POST['imagepath'];
			$lastd=$dish->add($d);

			if($lastd){
				$this->success('产品添加成功');
			}else{
				$this->error('产品添加失败');
			}
			}else{
				$this->error('上传图片失败!');
			}
		}
		public function doMessc(){
			$cats=M('cats');

			$c['cname']=$_POST['cats'];

			$lastc=$cats->add($c);

			if($lastc){
				$this->success('分类添加成功');
			}else{
				$this->error('分类添加失败');
			}
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
		/*
        if ($list !== false) {
            $this->success('上传图片成功！'.$data);
			//var_dump($upload);
        } else {
            $this->error('上传图片失败!');
        }
		*/
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
    $bucket='bcsimage-1'; //这里是你刚才创建的bucket
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
