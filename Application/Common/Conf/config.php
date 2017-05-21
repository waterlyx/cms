<?php
return array(
	//'配置项'=>'配置值'
	//开启页面调试信息
	// 	'SHOW_PAGE_TRACE' => true,
	//开启重写模式
	'URL_MODEL'=>2,
	//PDO配置数据库
	'DB_TYPE' => 'mysql',
	'DB_USER' => 'root',
	'DB_PWD' => '',
	'DB_PREFIX' => 'think_',
	'DB_DSN' => 'mysql:host=127.0.0.1;dbname=cms;charset=utf8',
	//配置表单令牌
	'TOKEN_ON'      =>    true,  // 是否开启令牌验证 默认关闭
	'TOKEN_NAME'    =>    '__hash__',    // 令牌验证的表单隐藏字段名称，默认为__hash__
	'TOKEN_TYPE'    =>    'md5',  //令牌哈希验证规则 默认为MD5
	'TOKEN_RESET'   =>    true,  //令牌验证出错后是否重置令牌 默认为true
	//
);