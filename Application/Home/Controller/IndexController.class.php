<?php
namespace Home\Controller;
use Common\Controller\HomeController;
class IndexController extends HomeController {
    public function index(){
    	//定义首页图片展示对象
    	$imgindex = M('imgindex');
		//获取首页图片列表
		$dataimg = $imgindex -> cache(true,60)->select();
		//前端页面显示
		$this -> assign('dataimg',$dataimg);
		$module = M('module');
		$datamodule = $module ->cache(true,60)-> where("`index` = 1 AND `show` = 1")->limit(2)->select();
		$this -> assign("datamodule",$datamodule);
		$id[0] = $datamodule[0]['id'];
		$id[1] = $datamodule[1]['id'];
		$news = M('news');
		$datanews[0] = $news->cache(true,60)-> where("`show` = 1 AND module = $id[0]")->order('top desc,time desc')->limit(3)->select();
		$datanews[1] = $news->cache(true,60)-> where("`show` = 1 AND module = $id[1]")->order('top desc,time desc')->limit(3)->select();
		$this -> assign("datanews",$datanews);
    	$this->display();
    }
}