<?php
namespace Admin\Controller;
use Common\Controller\AdminController;
class moduleController extends AdminController {
	//模块展示方法
	public function showlist() {
		$module = D('module');
		$data = $module -> showlist();
		$this -> assign('data', $data);
		$this -> display();
	}

	//模块增加方法
	public function addModule() {
		if (I("post.")) {
			$module = D('module');
			if (!$module -> autoCheckToken($_POST)) {
				// 令牌验证错误
				$this -> error('令牌验证错误，请刷新');
			} else {
				$result = $module -> addModule(I("post.nameZh"), I("post.nameEn"), I("post.show"), I("post.index"));
				if ($result != false) {
					if ($result == 3) {
						$this -> error('首页显示超过2个');
					} else {
						$this -> success('新增成功', U('Module/showlist'));
					}
				} else {
					$this -> error('新增失败');
				}
			}
		} else {
			$this -> display();
		}
	}

	//模块修改方法
	public function saveModule() {
		if (I("post.")) {
			$module = D('module');
			if (!$module -> autoCheckToken($_POST)) {
				// 令牌验证错误
				$this -> error('令牌验证错误，请刷新');
			} else {
				$result = $module -> saveModule(I("post.id"), I("post.nameZh"), I("post.nameEn"), I("post.show"), I("post.index"));
				if ($result != false) {
					if ($result == 3) {
						$this -> error('首页显示超过2个');
					} else {
						$this -> success('修改成功', U('Module/showlist'));
					}
				} else {
					$this -> error('修改失败');
				}
			}
		} else {
			$module = D('module');
			$dataModule = $module -> showOne(I('get.id'));
			$this -> assign("dataModule", $dataModule);
			$this -> display();
		}
	}

	//模块删除方法
	public function delModule() {
		if (I('get.id')) {
			$module = D('module');
			$result = $module -> delOne(I('get.id'));
			if ($result != false) {
				if ($result == 3) {
						$this -> error('禁止删除非空模块');
					} else {
						$this -> success('删除成功', U('Module/showlist'));
					}
			} else {
				$this -> error('删除失败');
			}
		}
	}

}
