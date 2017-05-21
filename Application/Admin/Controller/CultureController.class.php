<?php
namespace Admin\Controller;
use Common\Controller\AdminController;
class CultureController extends AdminController {
	public function showlist(){
		//显示数据
		$culture = D('culture');
		$data =$culture->showlist();
		$this->assign('data',$data);
		$this->display();
	}
	public function edit(){
		if(I('post.')){
			//获得更新数据
			$culture = D('culture');
			if (!$culture->autoCheckToken($_POST)) {
				// 令牌验证错误
				$this->error('令牌验证错误，请刷新');
			}else{
				if($culture->edit(I('post.id'),I('post.content'))){
					$this->success('提交成功',U('About/showlist'));
				}
			}
		}else{
			$this->error('提交失败');
		}
	}
}