<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title><?php echo ($list[0]["pname"]); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">    
     <!-- <link rel='stylesheet' id='camera-css'  href='__CSS__/camera.css'> -->
	 <script type='text/javascript' src='__JS__/jquery-1.11.1.min.js'></script>
    <script type='text/javascript' src='__JS__/jquery.min.js'></script>
    <!-- <script type='text/javascript' src='__JS__/jquery.easing.1.3.js'></script>  -->
    <!-- <script type='text/javascript' src='__JS__/camera.min.js'></script> -->
	<script type='text/javascript' src="__JS__/jquery.mobile-1.4.2.min.js"></script>
	<link href="__CSS__/jquery.mobile-1.4.2.min.css" rel="stylesheet">
	<link href="__CSS__/bootstrap.css" rel="stylesheet" >
	 <script type="text/javascript">
	 $(document).ready(function(){
		
		$("table").addClass("table table-condensed table-bordered");
		$("table tr").first().addClass('success');
	});
	 </script>
	 <script>
	 
		jQuery(function(){
			jQuery('#camera_wrap_1').camera({
				height: '200px',
				time: 500,
				navigation: false,
				playPause: false,
				pagination: false,
				thumbnails: false
			});
		});
		
	</script>
</head>
<body>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div data-role="page">

  <div data-role="header" data-theme="b">
    <img src='__ROOT__<?php echo ($vo["logo"]); ?>' height='40' width='40' />
	<strong><?php echo ($vo["company"]); ?></strong>
  </div>
  <div data-role="content">
	<img src='__ROOT__<?php echo ($vo["picone"]); ?>' height='320px' width='480px'/>
  </div>
  <div data-role="collapsible-set">
	<div data-role="collapsible" data-collapsed="false">
	<h1>产品简介</h1>
	<h4><?php echo ($vo["pname"]); ?></h4>
	<p><?php echo (htmlspecialchars_decode($vo["introduce"])); ?></p>
	</div>
	<div data-role="collapsible">
	<h1>详细参数</h1>
	<div class="table-responsive">
	<?php echo (htmlspecialchars_decode($vo["table"])); ?>
	</div>
	<small><?php echo ($vo["capability"]); ?></small>
	</div>
 </div>
</div>
</body><?php endforeach; endif; else: echo "" ;endif; ?>
</html>