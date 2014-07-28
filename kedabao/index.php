<?php
	//1.确定应用名称 App
	define('APP_NAME','App');
	//2.确定应用路径
	define('APP_PATH','./App/');
	//3.开启调试模式
	define('APP_DEBUG',true);
	//4.应用核心文件
	require './ThinkPHP/ThinkPHP.php';
	//目录安全
	define('BUILD_DIR_SECURE',true);
	define('DIR_SECURE_FILENAME', 'index.html');
	define('DIR_SECURE_CONTENT', 'deney Access!');

?>
