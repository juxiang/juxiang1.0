<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>详细产品添加</title>
	<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap3/css/bootstrap.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap3/css/bootstrap-theme.min.css" />	
	<link rel="stylesheet" href="__PUBLIC__/statics/css/default.css" />
	<script src="__PUBLIC__/statics/bootstrap3/js/jquery.min.js"></script>
	<script src="__PUBLIC__/statics/bootstrap3/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#collapseFour').addClass('in');
			$('#collapseOne').removeClass('in');
			$('#collapseTwo').removeClass('in');
			$('#collapseThree').removeClass('in');
		});
	</script>
	<!-- 配置文件 -->
    <script type="text/javascript" src="__PUBLIC__/ueditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="__PUBLIC__/ueditor/ueditor.all.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="__PUBLIC__/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
   $(function(){
    getwxcats();
    $("#wxcats").change(function(){
     getcats();
    });
	$("#cats").change(function(){
     getproducts();
    });
    
    function getwxcats()
    {
     $.get("<?php echo U(GROUP_NAME.'/Dishes/getwxcats');?>", function(data) {
	 var json=eval('('+decodeURIComponent(data)+')');
      $.each(json, function(i, item) {
       $("<option></option>").val(item[0]).text(item[0]).appendTo($("#wxcats"));
      });
      getcats();
     });
    }
   
    function getcats()
    {
     $("#cats").empty();
     $.get("<?php echo U(GROUP_NAME.'/Dishes/getcats');?>",  {wxcats:$("#wxcats").val()}, function(data) {
      var json=eval('('+decodeURIComponent(data)+')');
	  $.each(json, function(i, item) {
       $("<option></option>").val(item[1]).text(item[0]).appendTo($("#cats"));
      });
	  getproducts();
     });
    }

	function getproducts()
    {
     $("#products").empty();
     $.get("<?php echo U(GROUP_NAME.'/Dishes/getproducts');?>",  {cats:$("#cats").val()}, function(data) {
      var json=eval('('+decodeURIComponent(data)+')');
	  $.each(json, function(i, item) {
	  if(item[3]==0)
       $("<option></option>").val(item[0]).text(item[2]).appendTo($("#products"));
      });
     });
    }
   });
  </script>
  	<script type="text/javascript">
	window.UEDITOR_HOME_URL='__ROOT__/Public/ueditor/';
		window.UEDITOR_CONFIG.enableAutoSave=false;
		window.UEDITOR_CONFIG.pasteplain = true;//默认纯文本粘贴
		window.UEDITOR_CONFIG.maximumWords=1000;
		window.UEDITOR_CONFIG.toolbars
		=[[
            'fullscreen','source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'pagebreak', 'template', 'background', '|',
            'horizontal', 'date', 'time', 'spechars', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
            'print', 'preview', 'searchreplace', 'help', 'drafts'
        ]];
	 var ue = UE.getEditor('introduce');
	 var ue = UE.getEditor('table');
	</script>

	<style type="text/css">
		body{
			padding-top: 70px;
		}
	</style>
</head>

<body>
	<!--nav导航条-->
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">	
		<div class="container">
			<div class="collapse navbar-collapse">
			    <ul class="nav navbar-nav">
			      <li class="active"><a href="#">我的面板</a></li>
			      <li><a href="<?php echo U(GROUP_NAME.'/Index/index');?>">首页</a></li>
			      <!-- <li><a href="#">设置</a></li>
			      <li><a href="#">模块</a></li>
			      <li><a href="#">内容</a></li>
			      <li><a href="#">用户</a></li>
			      <li><a href="#">界面</a></li>
			      <li><a href="#">扩展</a></li> -->
			    </ul>

			    <ul class="nav navbar-nav navbar-right">
			   		<li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#"><i class="glyphicon glyphicon-user"></i> <?php echo (session('username')); ?> <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if($_SESSION['admin']== admin): ?><li>
                                <a href="<?php echo U('Admin/Index/index');?>" tabindex="-1"><i class="glyphicon glyphicon-cog"></i>	管理员后台</a>
                            </li>
							<li class="divider"></li><?php endif; ?>
                            <li>
                                <a href="<?php echo U(GROUP_NAME.'/Login/dologout');?>" tabindex="-1"><i class="glyphicon glyphicon-off"></i>	退出</a>
                            </li>
                        </ul>
                    </li>
			    </ul>
  			</div><!-- /.navbar-collapse -->
		</div>
	</nav>
	<!--/nav导航条-->
	<div class="container">
		<div class="row">
			
	<div id="sidebar" class="col-sm-3">
	<div class="panel-group" id="accordion">
			<div class="panel panel-primary">
			    <div class="panel-heading">
			     	<h4 class="panel-title">
			       		<a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="glyphicon glyphicon-user"></i> 客 户 管 理</a>
			      	</h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in">
				      	<div class="panel-body">
				         	<ul class=" nav nav-pills nav-stacked">
					          	<li><a href="<?php echo U(GROUP_NAME.'/Member/memberList');?>">客户信息</a></li>
				      		</ul>
				     	 </div>
			    </div>
			</div>
 		<!--<div class="panel panel-primary">
		    <div class="panel-heading">
		        <h4 class="panel-title">
			        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="glyphicon glyphicon-list"></i> 权 限 管 理
			        </a>
		     	</h4>
		    </div>
		    <div id="collapseTwo" class="panel-collapse collapse">
		     	<div class="panel-body">
			      	<ul class=" nav nav-pills nav-stacked">
			          	<li><a href="<?php echo U('Admin/Auth/accessList');?>">权限列表</a></li>
			      		<li><a href="<?php echo U('Admin/Auth/accessAdd');?>">添加权限</a></li>
			      		<li><a href="<?php echo U('Admin/Auth/groupList');?>">角色管理</a></li>
			      	</ul>
		      	</div>
		    </div>
		  </div> -->
		<div class="panel panel-primary">
		    <div class="panel-heading">
		        <h4 class="panel-title">
			        <a data-toggle="collapse" data-toggle="collapse " data-parent="#accordion" href="#collapseThree"><i class="glyphicon glyphicon-cloud"></i> 微信设置管理
			        </a>
		     	</h4>
		    </div>
		    <div id="collapseThree" class="panel-collapse collapse ">
		     	<div class="panel-body">
			      	<ul class=" nav nav-pills nav-stacked">
			          	<li><a href="<?php echo U(GROUP_NAME.'/Wxconf/buttons');?>">微信自定义菜单列表</a></li>
						<?php if($_SESSION['admin']== admin): ?><li><a href="<?php echo U(GROUP_NAME.'/Wxconf/addbutton1');?>">微信自定义一级菜单添加</a></li>
						<li><a href="<?php echo U(GROUP_NAME.'/Wxconf/wxconf');?>">基本参数设置</a></li><?php endif; ?>
						<li><a href="<?php echo U(GROUP_NAME.'/Wxconf/addbutton2');?>">微信自定义二级菜单添加</a></li>
			      		<li><a href="<?php echo U(GROUP_NAME.'/Wxconf/index');?>">微信显示预览</a></li>
			      	</ul>
		      	</div>
		    </div>
		  </div>
		  
		  <div class="panel panel-primary">
		    <div class="panel-heading">
		        <h4 class="panel-title">
			        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><i class="glyphicon glyphicon-asterisk"></i> 产品管理
			        </a>
		     	</h4>
		    </div>
		    <div id="collapseFour" class="panel-collapse collapse">
		     	<div class="panel-body">
			      	<ul class=" nav nav-pills nav-stacked">
			          	<li><a href="<?php echo U(GROUP_NAME.'/Cats/index');?>">分类列表</a></li>
						<li><a href="<?php echo U(GROUP_NAME.'/Cats/add');?>">分类添加</a></li>
						<li><a href="<?php echo U(GROUP_NAME.'/Dishes/index');?>">产品列表</a></li>
			      		<li><a href="<?php echo U(GROUP_NAME.'/Dishes/add');?>">产品添加</a></li>
			      		<li><a href="<?php echo U(GROUP_NAME.'/Product/index');?>">详细产品列表</a></li>
						<li><a href="<?php echo U(GROUP_NAME.'/Product/add');?>">详细产品添加</a></li>
			      	</ul>
		      	</div>
		    </div>
		  </div>
		  <div class="panel panel-primary">
		    <div class="panel-heading">
		        <h4 class="panel-title">
			        <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><i class="glyphicon glyphicon-asterisk"></i> 公司管理
			        </a>
		     	</h4>
		    </div>
		    <div id="collapseFive" class="panel-collapse collapse">
		     	<div class="panel-body">
			      	<ul class=" nav nav-pills nav-stacked">
			          	<li><a href="<?php echo U(GROUP_NAME.'/Connect/index');?>">关于公司</a></li>
			      	</ul>
		      	</div>
		    </div>
		  </div>
		</div>
	</div>	

			
		<div id="content" class="col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="glyphicon glyphicon-header"></i> 详细产品添加</h4>
				</div>

				<div class="panel-body">
<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/Product/doadd');?>" method='post' enctype='multipart/form-data'>
<!--   <div class="form-group">
    <label for="logo" class="col-sm-2 control-label">公司LOGO</label>
    <div class="col-sm-10">
      <input type="file" name="logo" id='logo'></select>
    </div>
  </div> -->
    <div class="form-group">
    <label for="wxcats" class="col-sm-2 control-label">微信二级菜单：</label>
    <div class="col-sm-10">
      <select name="company" id='wxcats'></select>
    </div>
  </div>
  <div class="form-group">
    <label for="cats" class="col-sm-2 control-label">分 类：</label>
    <div class="col-sm-10">
		<select id='cats' name="did" placeholder="" ></select>
    </div>
  </div>
  <div class="form-group">
    <label for="products" class="col-sm-2 control-label">产品名：</label>
    <div class="col-sm-10">
		<select id='products' name="pid" placeholder="" ></select>
    </div>
  </div>
  <div class="form-group">
    <label for="11" class="col-sm-2 control-label">展示图片1：</label>
    <div class="col-sm-10">
		<input id='11' type='file' name="picone" ><small>图片最佳尺寸：80*80，小于100kb</small>
    </div>
	
  </div>
  <div class="form-group">
    <label for="12" class="col-sm-2 control-label">展示图片2：</label>
    <div class="col-sm-10">
		<input id='12' type='file' name="pictwo" ><small>图片最佳尺寸：80*80，小于100kb</small>
    </div>
  </div>
  <div class="form-group">
    <label for="13" class="col-sm-2 control-label">展示图片3：</label>
    <div class="col-sm-10">
		<input id='13' type='file' name="picthree" ><small>图片最佳尺寸：80*80，小于100kb</small>
    </div>
  </div>
    <div class="form-group">
    <label for="introduce" class="col-sm-2 control-label">产品简介:</label>
    <div class="col-sm-10">
      <textarea id='introduce' name="introduce" placeholder="" ></textarea>
    </div>
  </div>
    <div class="form-group">
    <label for="table" class="col-sm-2 control-label">产品性能表:</label>
    <div class="col-sm-10">
      <textarea id='table' type="text" name="table"></textarea>
    </div>
  </div>
    <div class="form-group">
    <label for="5" class="col-sm-2 control-label">产品性能说明:</label>
    <div class="col-sm-10">
      <textarea id='5' name="capability" cols='90'></textarea>
    </div>
    </div>
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">增加</button>
	  <a href="<?php echo U('index');?>" class="btn btn-default" >返回</a>
    </div>
  </div>
</form>
			</div>
		</div>

		</div>
	</div>


</body>
</html>