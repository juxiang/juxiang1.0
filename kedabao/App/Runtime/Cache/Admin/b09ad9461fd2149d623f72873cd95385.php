<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title>Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"> 
     <script src="__JS__/jquery-1.11.0.js"></script> 
	 <script src="__JS__/bootstrap.js"></script> 
	 <link href="__CSS__/bootstrap.css" rel="stylesheet"> 
</head>
	<body>
		<div class="container">

      <form class="form-signin" role="form" action="<?php echo U(GROUP_NAME.'/Login/doLogin');?>" method='post' name='myForm1' style="width:220px;margin:0px auto;">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" placeholder="用户名" name='username' required autofocus><br />
        <input type="password" class="form-control" placeholder="密码" name='password' required><br />
<!--         <input type='text' name='code'/>
		<Message:code width='30' height='30'/><br /> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
      </form>

    </div>
	</body>
</html>