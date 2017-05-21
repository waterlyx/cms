<?php
namespace Admin\Controller;
use Common\Controller\AdminController;
class IndexController extends AdminController {
	/**
	 * 展示后台主界面
	 */
	public function index() {
		$user = M('user');
		$userId = session('userId');
		$datauser = $user -> where("id = $userId")->find();
		$this->assign('datauser',$datauser);
		$this -> display();
	}

	public function img() {
		//实例化首页图片显示对象
		$imgindex = M('imgindex');
		$dataimg = $imgindex -> select();
		$this -> assign('dataimg', $dataimg);
		//实例化首页推荐新闻显示
		//		$datanews = M('News');
		//		$datanews -> where('')
		$this -> display();
	}

	/**
	 * 上传站点标题图片
	 */
	public function imgTitle() {

		$index = M('index');
		if (!$index -> autoCheckToken($_POST)) {
			// 令牌验证错误
			$this -> error('令牌验证错误，请刷新');
		} else {
			//接收上传图片
			$upload = new \Think\Upload();
			// 实例化上传类
			$upload -> maxSize = 3145728;
			// 设置附件上传大小
			$upload -> exts = array('jpg', 'gif', 'png', 'jpeg');
			// 设置附件上传类型
			$upload -> savePath = '/Title/';
			// 设置附件上传目录
			$info = $upload -> uploadOne($_FILES['img_title']);
			if (!$info) {// 上传错误提示错误信息
				$this -> error($upload -> getError());
			} else {
				//生成缩略图
				$image = new \Think\Image();
				$image -> open('./Uploads' . $info['savepath'] . $info['savename']);
				$image -> thumb(72, 72, \Think\Image::IMAGE_THUMB_FIXED) -> save('./Uploads' . $info['savepath'] . 'thumb_' . $info['savename']);
				unlink('./Uploads' . $info['savepath'] . $info['savename']);
				//				return
				//将缩略图的地址上传到数据库
				$data['img_title'] = '/Uploads' . $info['savepath'] . 'thumb_' . $info['savename'];
				//删除之前保存的图标
				unlink('.' . I('post.img_title'));
				//获取首页数据的id
				$id = I('post.id');
				$result = $index -> where("id = $id") -> save($data);
				if ($result) {
					$this -> success('更新成功', U('Index/img'));
				} else {
					$this -> error('更新失败');
				}
			}
		}
	}

	//修改站点的基本信息
	public function editIndex() {
		$index = M('index');
		if (!$index -> autoCheckToken($_POST)) {
			// 令牌验证错误
			$this -> error('令牌验证错误，请刷新');
		} else {
			$id = I('post.id');
			$data['title'] = I('post.title');
			$data['footer'] = I('post.footer');
			$data['mintitle'] = I('post.mintitle');
			$data['introduce'] = I('post.introduce');
			$result = $index -> where("id = $id") -> save($data);
			if ($result) {
				$this -> success('更新成功', U('Index/index'));
			} else {
				$this -> error('更新失败');
			}
		}
	}

	//更新前端页面的首页图片
	public function imgIndex() {
		$index = M('imgindex');
		if (!$index -> autoCheckToken($_POST)) {
			// 令牌验证错误
			$this -> error('令牌验证错误，请刷新');
		} else {
			//接收上传图片
			$upload = new \Think\Upload();
			// 实例化上传类
			$upload -> maxSize = 3145728;
			// 设置附件上传大小
			$upload -> exts = array('jpg', 'gif', 'png', 'jpeg');
			// 设置附件上传类型
			$upload -> savePath = '/Index/';
			// 设置附件上传目录
			$info = $upload -> upload();
			if (!$info) {// 上传错误提示错误信息
				$this -> error($upload -> getError());
			} else {
				foreach ($info as $file) {
					//生成缩略图
					$image = new \Think\Image();
					$image -> open('./Uploads' . $file['savepath'] . $file['savename']);
					$image -> thumb(1000, 480, \Think\Image::IMAGE_THUMB_FIXED) -> save('./Uploads' . $file['savepath'] . 'thumb_' . $file['savename']);
					unlink('./Uploads' . $file['savepath'] . $file['savename']);
					//将缩略图的地址上传到数据库
					$data['img_index'] = '/Uploads' . $file['savepath'] . 'thumb_' . $file['savename'];
					$result = $index -> add($data);

				}
				if ($result) {
					$this -> success('上传成功', U('Index/img'));
				} else {
					$this -> error('上传失败');
				}
			}
		}
	}

	//删除首页图片
	public function delImg() {
		if (I('get.id')) {
			//接收需要删除的图片id
			$id = I('get.id');
			//实例化首页图片类
			$imgindex = M('imgindex');
			//获取需要删除的图片地址
			$url = $imgindex -> where("id = $id") -> find();
			//删除图片
			unlink('.' . $url['img_index']);
			//删除数据库中的图片信息
			$resault = $imgindex -> where("id = $id") -> delete();
			if ($resault) {
				$this -> success('删除成功', U('Index/img'));
			} else {
				$this -> error('删除失败');
			}
		}
	}

	//清除默认缓存
	public function delcache() {
		$path = "./Application/Runtime";
		$this -> deleteAll($path);
		$this -> success('清除缓存成功', U('Index/index'));
	}

	//循环删除方法
	private function deleteAll($path) {
		$op = dir($path);
		while (false != ($item = $op -> read())) {
			if ($item == '.' || $item == '..') {
				continue;
			}
			if (is_dir($op -> path . '/' . $item)) {
				$this -> deleteAll($op -> path . '/' . $item);
				rmdir($op -> path . '/' . $item);
			} else {
				unlink($op -> path . '/' . $item);
			}

		}
	}

}
