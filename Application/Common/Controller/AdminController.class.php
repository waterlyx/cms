<?php
namespace Common\Controller;
use Think\Controller;
class AdminController extends Controller {
    function __construct(){
        parent::__construct();
        if(empty(session('userId'))){
            $this->redirect('Admin/User/login');
        }else{
        	//显示后台的基本数据
        	$index = M('index');
			$dataindex = $index -> find();
			//显示后台的左侧面板
			$module = M('module');
			$datamodule = $module->where("`show` = 1")->select();
			//赋值
			$this ->assign('datamodule',$datamodule);
			$this -> assign('dataindex',$dataindex);
        }
    }
}