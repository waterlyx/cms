<?php
namespace Home\Controller;
use Common\Controller\HomeController;
class AboutController extends HomeController {
	//获取公司简介
	public function showlist(){
		$about = M('about');
		$data = $about->cache(true,60)->find();
		$this->assign('content',$data['content']);
		$this->display();
	}
}