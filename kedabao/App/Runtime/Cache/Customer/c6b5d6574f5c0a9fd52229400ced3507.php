<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>平台参数设置</title>
	<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap3/css/bootstrap.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap3/css/bootstrap-theme.min.css" />	
	<link rel="stylesheet" href="__PUBLIC__/statics/css/default.css" />
	<script src="__PUBLIC__/statics/bootstrap3/js/jquery.min.js"></script>
	<script src="__PUBLIC__/statics/bootstrap3/js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#collapseFive').addClass('in');
			$('#collapseOne').removeClass('in');
			$('#collapseTwo').removeClass('in');
			$('#collapseThree').removeClass('in');
			$('#collapseFour').removeClass('in');
		});
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
					<h4 class="panel-title"><i class="glyphicon glyphicon-header"></i>公司信息</h4>
				</div> 
				<div class="panel-body">
				<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/Connect/update');?>" method='post' enctype='multipart/form-data'>
				<table class="table table-hover table-bordered table-condensed">
			<tr>
			<td>公司LOGO</td><td><input type='file' name='logo'/><img height='40' width='40' src="__ROOT__<?php echo ($list["logo"]); ?>" ><small>图片最佳尺寸：80*80，小于100kb</small></td>
			<td>公司名称</td><td><input type='text' name='company' value='<?php echo ($list["company"]); ?>'/></td>
			<tr>
			<td>公司图片展示1</td><td><input type='file' name='picone'/><img height='40' width='40' src="__ROOT__<?php echo ($list["picone"]); ?>" ><small>图片最佳尺寸：80*80，小于100kb</small></td>
			<td>公司图片展示2</td><td><input type='file' name='pictwo'/><img height='40' width='40' src="__ROOT__<?php echo ($list["pictwo"]); ?>" ><small>图片最佳尺寸：80*80，小于100kb</small></td>
			</tr>
			<tr>
			<td>公司图片展示3</td><td><input type='file' name='picthree'/><img height='40' width='40' src="__ROOT__<?php echo ($list["picthree"]); ?>" ><small>图片最佳尺寸：80*80，小于100kb</small></td>
			</tr>
			<tr>
			<td >公司简介</td><td colspan='4'><textarea rows='5' cols="90" name='introduce' /><?php echo ($list["introduce"]); ?></textarea></td>
			</tr>
			<tr>
			<td>公司联系方式</td><td><textarea rows='5' cols='30' name='phone' /><?php echo ($list["phone"]); ?></textarea></td>
			<td>公司地址</td><td><textarea rows='5' cols='30' name='address' /><?php echo ($list["address"]); ?></textarea></td>
			</tr>
			<tr>
			<td colspan='4' style='text-align:center'>
				<input type="submit" class="btn btn-warning" value="修改">
				<a href="<?php echo U(GROUP_NAME.'/ConnectDisplay/index',array('uid'=>session('uid')));?>" class="btn btn-primary" target="_blank">预览</a>
			</td>
			</tr>
			</table>
		</form>
</div>
</div>
</div>

		</div>
	</div>


</body>
</html>