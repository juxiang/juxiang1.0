<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title><?php echo ($_GET['wxcats']); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
     
     <script src="__JS__/jquery-1.11.0.js"></script> 
	 <script src="__JS__/bootstrap.js"></script> 
	 <link href="__CSS__/bootstrap.css" rel="stylesheet"> 

</head>
<body> 
<div class="progress progress-striped active" style="margin:-20 0 0 0">
  <div class="progress-bar progress-bar-success" role="progressbar"  style="width: 100%;">
  </div>
</div>

	<div class="row" > 
			 <div class="col-xs-4 col-md-3" style='background: #BEDBE9'   id="tabs">
				<ul class="nav nav-lists" id='cats' style="overflow:scroll;padding:0 -15px;margin:0 -15px" >
                <li class='active hidden' ><a href="#hy" data-toggle="tab">ceshi</a></li>
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><li id='listyle<?php echo ($vo["id"]); ?>' onClick="golid(<?php echo ($vo["id"]); ?>)" class="text-center"/><a href="#panel<?php echo ($vo["id"]); ?>" data-toggle="tab"><h5><strong><?php echo ($vo["cname"]); ?></strong></h5></a></li>
				<li role="presentation" class="divider"></li>
				<hr style="padding:0 0px;margin:0 0px"><?php endforeach; endif; ?>
				</ul> 
			</div>
			<div class="col-xs-8 col-md-9 tab-content" id='dishes' style="overflow:auto;padding:0 0px;margin:0 0px">
            	<div class="tab-pane active" id="hy" style="background:#D4F56C"><h4>欢迎您的到来！！</h4></div>
			<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="tab-pane" id="panel<?php echo ($vo["id"]); ?>" >
                      		<?php if(is_array($vo['dishes'])): $i = 0; $__LIST__ = $vo['dishes'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><div style="height:85px;padding:0 0px;margin:0px 0px -15px 0" >
								<div class="col-xs-4 col-sm-4">
								<img class="img-rounded" alt="这是图片" src='__ROOT__<?php echo ($sub["picpath"]); ?>' width="80" height="80">
								</div>
								<div class="col-xs-8 col-sm-8">
        						<strong>&nbsp;&nbsp;<?php echo ($sub["dname"]); ?></strong><br /><br />
                                &nbsp;<a href="<?php echo U($sub['url']);?>" ><input type="button" class="btn btn-primary" value="查看详细信息" /></a>
								</div>
							</div>
							<hr /><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endforeach; endif; ?>
			</div> 
</div>
<script language="JavaScript">
window.onload=setlistyle();
//点击菜单后，清空右边框，显示新的内容
function getdishes()
{
	var m=split();
	var id=parseInt(m[1]);
	//alert(id);
	document.getElementById('hy').innerHTML='';
   //document.getElementById('dishes').innerHTML=' ';
   var x=document.getElementById('panel'+id).innerHTML;
   document.getElementById('dishes').innerHTML=x;

}   
//获取窗口高度
function getheight(){
	var x=$(window).height();
	//alert(x);
	document.getElementById('cats').style.height=x+'px';
	document.getElementById('dishes').style.height=x+'px';

};
//点击菜单，背景色变化
function setlistyle(){
	getheight();
	var m=split();
	var x=m[1];
	//alert(x);
	//getlid(x);
	/*
	 var tag = document.getElementsByTagName("li");
	 for (var i=0;i<tag.length;i++ )
        {
            tag[i].style.background="none";
        }*/
	document.getElementById('listyle'+x).style.background='#D4F56C';
	getdishes();
}
//设置跳转链接
function golid(lid){
	var m=split();
	if(m){
		var x=m[0]+'/lid/'+lid;
	}else{
		var x=window.location.href+'/lid/'+lid;
	}
	window.location.href=x;
};
//返回后，自动加载上次浏览页面
function split(){
	var x=window.location.href;
	//var lid='/lid/';
	if(x.search('/lid/')>0){
		var m=x.split('/lid/');
		return m;
	}else{
		return false;
		}
}
</script>
</body>
</html>