<?php
function p($array){
	dump($array,true,'<pre>',0);//$array是欲处理字符串；第二参数：true，false；第三个参数：；第四个参数；
}
//模板中截取字符串长度
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
	if(function_exists("mb_substr"))
		$slice = mb_substr($str, $start, $length, $charset);
	elseif(function_exists('iconv_substr')) {
		$slice = iconv_substr($str,$start,$length,$charset);
		if(false === $slice) {
			$slice = '';
		}
	}else{
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice.'...' : $slice;
}
//上传文件配置
function uploadfile(){
		import('ORG.Net.UploadFile');
		$config=array(
				'maxSize'           =>  -1,
				'allowExts'         =>  array('bmp','jpg','jpeg','png','gif'),
				'thumb'             =>  true,
				'thumbMaxWidth'     =>  '300',// 缩略图最大宽度
				'thumbMaxHeight'    =>  '225',// 缩略图最大高度
				'thumbPrefix'       =>  's_',// 缩略图前缀
				'thumbPath'         =>  './Public/files/images/',// 缩略图保存路径
				'savePath'          =>  './Public/files/images/',// 上传文件保存路径
				'saveRule'          =>  'uniqid',// 上传文件命名规则
				'uploadReplace'     =>  false,// 存在同名是否覆盖
				'thumbRemoveOrigin'  => true,// 是否移除原图
		);
		$upload=new UploadFile($config);
		if(!$upload->upload()) {// 上传错误提示错误信息
       	 	return $upload->getErrorMsg();
   		}else{// 上传成功
        	return $upload->getUploadFileInfo();
    	}
		
}
	function authCheck($rule,$uid,$type=1, $mode='url', $relation='or'){
		//超级管理员跳过验证
		import('ORG.Util.Auth');//加载类库
		$auth=new Auth();
		//获取当前uid所在的角色组id
		$groups=$auth->getGroups($uid);
		//p($groups);die;
		//这里偷懒了,因为我设置的是一个用户对应一个角色组,所以直接取值.如果是对应多个角色组的话,需另外处理
		if(in_array($groups[0]['id'], C('ADMINISTRATOR'))){
			return true;
		}else{			
			return $auth->check($rule,$uid,$type,$mode,$relation)?true:false;
		}
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
		/*多维数组排序
		$multi_array:多维数组名称
		$sort_key:二维数组的键名
		$sort:排序常量 SORT_ASC || SORT_DESC
		*/
		function multi_array_sort(&$multi_array,$sort_key,$sort=SORT_DESC){
			if(is_array($multi_array)){
				foreach ($multi_array as $row_array){
			if(is_array($row_array)){
			//把要排序的字段放入一个数组中，
				$key_array[] = $row_array[$sort_key];
			}else{
				return false;
			}
			}
			}else{
				return false;
			}
			//对多个数组或多维数组进行排序
			array_multisort($key_array,$sort,$multi_array);
			return $multi_array;
		} 
		function delImage($url){
			unlink($url);
		}