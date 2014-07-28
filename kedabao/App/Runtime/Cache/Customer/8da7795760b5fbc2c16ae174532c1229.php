<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>微信自定义菜单管理</title>
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
	<script type="text/javascript">
		$(function(){
			var x=document.getElementsByName("grade1")
			var y=document.getElementsByName("url1")
			for(var i=0;i<x.length;i++){
				if(x[i].value==1){
					y[i].style.display="";
				}else{
					y[i].style.display="none";
				}
			}
		}
		);
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
					<h4 class="panel-title"><i class="glyphicon glyphicon-header"></i> 自定义菜单列表</h4>
				</div>
		
			  <a href="<?php echo U(GROUP_NAME.'/Wxconf/cremenu');?>" class='btn btn-success' target='_blank'>菜单发布</a>
			  <small>上次菜单发布时间：
			<?php if(empty($subtime['subtime'])): ?>未发布过！
			<?php else: ?>
				<?php echo (date('Y年m月d日 H:i',$subtime['subtime'])); endif; ?>
			</small>
			<div class="panel-body">
			<h4>一级菜单</h4>
				<table class="table table-hover table-bordered table-condensed">
					<tr>
					<th >排	序</th>
					<th >菜单级别</th>
					<th >菜 单 名</th>
					<th >菜单类型</th>
					<th >菜单跳转链接：</th>
					<th >操	   作</th>
					</tr>
				<?php if(is_array($buttons)): $i = 0; $__LIST__ = $buttons;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/Wxconf/upbutton1',array('id1'=>$vo['id']));?>" method='post' enctype='multipart/form-data'>
					<tr>
						<input type="text" id="bu1id" hidden value="<?php echo ($vo["id"]); ?>"/>
					<td><input type="text" value="<?php echo ($vo["sort"]); ?>" name="sort" size="5px"/></td>
					<td ><select type="text" name="grade1" id="grade1" >
					<?php if($vo["grade"] == 1): ?><option value="1" selected >不含子菜单</option>
		<!-- <option value="2" >二级菜单</option> -->
		<?php else: ?>
		<!-- <option value="1" >一级菜单</option> -->
		<option value="2" selected >含子菜单</option><?php endif; ?>
		</select></td>
		<td ><input type='text' name='name1' value='<?php echo ($vo["name1"]); ?>'></td>
		<td ><select type="text" name="type1" id="type">
		<?php if($vo["type"] == click): ?><option value="click" selected>点击</option>
		<!-- <option value="view">视图</option> -->
		<?php else: ?>
		<!-- <option value="click">点击</option> -->
		<option value="view" selected>视图</option><?php endif; ?>
		</select></td>
		<td ><!-- <input type='text' name='key1' id='key' value='<?php echo ($vo["key"]); ?>'>
		     / --><input type='text' name='url1' id='url' value='<?php echo ($vo["url"]); ?>' ></td>
		<td >
		<div class="btn-group btn-group-xs">
		<?php if($_SESSION['admin']== admin): ?><input type='submit'  class="btn btn-warning" value='修改'>
		<a href="<?php echo U(GROUP_NAME.'/Wxconf/delbutton1',array('id1'=>$vo['id']));?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a><?php endif; ?>
		</div>
		</td>
	</tr>
</form><?php endforeach; endif; else: echo "" ;endif; ?>
  </table>
  <p>注意：请将“公司管理”-“关于我们”的“预览地址”复制到“关于”的“菜单跳转链接”！</p>
<hr />
<h4>微信二级菜单</h4>
	<table class="table table-hover table-bordered table-condensed">
		<tr>
		<th>一级菜单</th>
		</tr>
<?php if(is_array($buttons)): $i = 0; $__LIST__ = $buttons;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
		<td ><input type='text' name='name1' value='<?php echo ($vo["name1"]); ?>' disabled size="10px"></td>
		<td>
		
		<table class="table table-hover table-striped">
		<tr>
		<th >排	序</th>
		<th >二级菜单</th>
		<th >菜单类型</th>
		<th >菜单跳转链接：</th>
		<th >操	   作</th>
		</tr>
		<?php if(is_array($vo['button2'])): $i = 0; $__LIST__ = $vo['button2'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/Wxconf/upbutton2',array('id2'=>$sub['id']));?>" method='post' enctype='multipart/form-data'>
		<tr>
		<td><input type="text" value="<?php echo ($sub["sort"]); ?>" name="sort"  size="5px"/></td>
		<td ><input type='text' name='name2' value='<?php echo ($sub["name2"]); ?>'></td>
		<td ><select type="text" name="type2" id="type">
		<?php if($sub["type"] == click): ?><!-- <option value="click" selected>点击</option> -->
		<option value="view">视图</option></select></td>
		<?php else: ?>
		<!-- <option value="click">点击</option> -->
		<option value="view" selected>视图</option></select></td><?php endif; ?>
		
		<td ><!-- <input type='text' name='key2' id='key' value='<?php echo ($sub["key"]); ?>'>
			/ --><input type='text' name='url2' id='url' value='<?php echo ($sub["url"]); ?>'>
		</td>
		<td >
		<div class="btn-group btn-group-xs">
		<input type='submit' value='修改' class="btn btn-warning"><a href="<?php echo U(GROUP_NAME.'/Wxconf/delbutton2',array('id2'=>$sub['id']));?>" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
		</td>
		</form><?php endforeach; endif; else: echo "" ;endif; ?>
		<tr>
		</table>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </table>
  <p>注意：请将“微信显示预览”内菜单的“预览地址”复制到对应的“微信二级菜单”的“菜单跳转链接”！</p>
  
</div>
</div>
</div>

		</div>
	</div>


</body>
</html>