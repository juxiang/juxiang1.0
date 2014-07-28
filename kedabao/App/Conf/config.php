<?php
return array(
	//'配置项'=>'配置值'
	'APP_GROUP_LIST' => 'Customer,Admin',//分组列表
	'APP_GROUP_MODE' => 1,//独立分组
	'APP_GROUP_PATH' => 'Modules',//存放独立分组文件夹
	'DEFAULT_GROUP' => 'Customer',//默认分组
	'URL_HTML_SUFFIX' => '',//URL静态后缀名为空
	'TMPL_L_DELIM'	=>	'<{',
	'TMPL_R_DELIM'	=>	'}>',
	//默认过滤函数
	'DEFAULT_FILTER'=>'strip_tags,htmlspecialchars' ,
	//数据库配置
	'DB_TYPE'   => 'mysql', // 数据库类型
	'DB_HOST'   => 'huaxianyun.mysql.rds.aliyuncs.com', // 服务器地址
	'DB_NAME'   => 'kedabao', // 数据库名
	'DB_USER'   => 'kedabao', // 用户名
	'DB_PWD'    => 'kedabao601415', // 密码
	'DB_PORT'   => 3306, // 端口
	'DB_PREFIX' => '', // 数据库表前缀
	
	
	//添加自己的模板变量规则
	'TMPL_PARSE_STRING'=>array(           
			'__CSS__'=>__ROOT__.'/Public/Css',
			'__JS__'=>__ROOT__.'/Public/Js',
	),
	//'SHOW_PAGE_TRACE'=>true,
);
?>