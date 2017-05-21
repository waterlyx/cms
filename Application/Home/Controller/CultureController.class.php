<?php
namespace Home\Controller;
use Common\Controller\HomeController;
class CultureController extends HomeController {
	//获取公司文化
	public function showlist(){
		$culture = M('culture');
		$data = $culture->cache(true,60)->find();
		$this->assign('content',$data['content']);
		$this->display();
	}
}