<?php
namespace Admin\Controller;
use Common\Controller\AdminController;
class AboutController extends AdminController {
	public function showlist(){
		//显示数据
		$about = D('about');
		$data =$about->showlist();
		$this->assign('data',$data);
		$this->display();
	}
	public function edit(){
		if(I('post.')){
			//获得更新数据
			$about = D('about');
			if (!$about->autoCheckToken($_POST)) {
				// 令牌验证错误
				$this->error('令牌验证错误，请刷新');
			}else{
				if($about->edit(I('post.id'),I('post.content'))){
					$this->success('提交成功',U('About/showlist'));
				}
			}
		}else{
			$this->error('提交失败');
		}
	}
}