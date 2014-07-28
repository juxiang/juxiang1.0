<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>客户选择</title>
	<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap3/css/bootstrap.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/statics/bootstrap3/css/bootstrap-theme.min.css" />	
	<link rel="stylesheet" href="__PUBLIC__/statics/css/default.css" />
	<script src="__PUBLIC__/statics/bootstrap3/js/jquery.min.js"></script>
	<script src="__PUBLIC__/statics/bootstrap3/js/bootstrap.min.js"></script>
	
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
                            <!-- <li>
                                <a href="#" tabindex="-1"><i class="glyphicon glyphicon-cog"></i>	设置</a>
                            </li> -->
                            <li class="divider"></li>
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
					          	<li><a href="<?php echo U(GROUP_NAME.'/Member/memberList');?>">客户列表</a></li>
					      		<li><a href="<?php echo U(GROUP_NAME.'/Member/memberAdd');?>">添加客户</a></li>
								<li><a href="<?php echo U(GROUP_NAME.'/Member/memberSelect');?>">客户选择</a></li>
				      		</ul>
				     	 </div>
			    </div>
			</div>
<!-- 		<div class="panel panel-primary">
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

		 
		</div>
	</div>	

			
		<div id="content" class="col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="glyphicon glyphicon-header"></i> 客 户 选 择</h4>
				</div>

				<div class="panel-body">
					<table class="table table-hover table-bordered table-condensed">
						<tr>
							<td>客户编号</td>
							<td>客 户 名</td>
							<td>公 司 名</td>
							<td>备	注</td>
							<td>操作</td>
						</tr>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><?php echo ($vo["uid"]); ?></td>
								<td><?php echo ($vo['username']); ?></td>
								<td><?php echo ($vo['company']); ?></td>
								<td><?php echo ($vo['content']); ?></td>
								<td>
									<div class="btn-group btn-group-xs">
										<a href="<?php echo U('Admin/Member/memberRedirect',array('uid'=>$vo['uid']));?>" class="btn btn-primary">选择</i></a>
									</div>
									</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
							<tr>
								<td colspan="3"><?php echo ($page); ?></td>
							</tr>
					</table>
				</div>

			</div>
		</div>

		</div>
	</div>


</body>
</html>