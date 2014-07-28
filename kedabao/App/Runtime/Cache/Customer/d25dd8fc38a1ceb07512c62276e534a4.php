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
			$('#collapseThree').addClass('in');
			$('#collapseOne').removeClass('in');
			$('#collapseTwo').removeClass('in');
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
					<h4 class="panel-title"><i class="glyphicon glyphicon-header"></i> 平台参数设置</h4>
				</div> 
				<div class="panel-body">
				
		<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/Wxconf/update');?>" method='post' enctype='multipart/form-data'>

  <div class="form-group">
    <label for="1" class="col-sm-3 control-label">微信公众账号认证URL（自动生成）：</label>
    <div class="col-sm-8">
		<!-- <p>http://<?php echo ($_SERVER['HTTP_HOST']); echo ($wxinfo["wxurl"]); ?></p>  -->
		<p>http://<?php echo ($_SERVER['HTTP_HOST']); ?>__ROOT__/weixin.php</p>
    </div>
  </div>
  <div class="form-group">
    <label for="1" class="col-sm-3 control-label">微信公众账号原始ID：</label>
    <div class="col-sm-4">
		<input id='11' type="text" name="openid"	value="<?php echo ($wxinfo["openid"]); ?>"  placeholder="微信公众账号原始ID" />
    </div>
  </div>
 <input type="hidden" name="uid" value="<?php echo ($wxinfo["uid"]); ?>">
  <div class="form-group">
    <label for="11" class="col-sm-3 control-label">微信  token：</label>
    <div class="col-sm-4">
      <input id='11' type="text" name="wxtoken"	value="<?php echo ($wxinfo["wxtoken"]); ?>"  placeholder="请输入TOKEN值" />
    </div>
  </div>
    <div class="form-group">
    <label for="12" class="col-sm-3 control-label">微信 appid：</label>
    <div class="col-sm-4">
      <input id='12' type="text" name="wx_aid"	value="<?php echo ($wxinfo["wx_aid"]); ?>"  placeholder="请输入 appid值" />
    </div>
  </div>
    <div class="form-group">
    <label for="13" class="col-sm-3 control-label">微信 appsecret：</label>
    <div class="col-sm-4">
      <input id='13' type="text" name="wx_secret"	value="<?php echo ($wxinfo["wx_secret"]); ?>"  placeholder="请输入 appsecret值" />
    </div>
  </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-4">
      <button type="submit" class="btn btn-default">修改</button>
    </div>
  </div>
  </form>
  
</div>
</div>
</div>

		</div>
	</div>


</body>
</html>