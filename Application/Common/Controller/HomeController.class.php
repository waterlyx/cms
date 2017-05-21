<?php
namespace Common\Controller;
use Think\Controller;
class HomeController extends Controller {
    function __construct(){
        parent::__construct();
		//显示前台的基本数据
        $index = M('index');
		$data = $index ->cache(TRUE,60)-> find();
		//显示前台的顶部菜单
		$module = M('module');
		$dataheadermodule = $module->cache(TRUE,60)->where("`show` = 1")->select();
		$this ->assign('dataheadermodule',$dataheadermodule);
		$this -> assign('data',$data);
    }
}