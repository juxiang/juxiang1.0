<?php
return array(
	//'配置项'=>'配置值'
	//开启静态缓存
	'HTML_CACHE_ON' =>TRUE,
	'HTML_CACHE_RULES' =>array(
			'Wxdisplay:index' =>array('{:module}_{:action}_{wxcats}_{uid}',2),
			'Prodisplay:index' =>array('{:module}_{:action}_{pid}_{uid}',2),
			'ConnectDisplay:index' =>array('{:module}_{:action}_{uid}',2),			
	),
);
?>