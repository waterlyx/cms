<?php
namespace Admin\Controller;
use Common\Controller\AdminController;
//创建展示类
class NewsController extends AdminController {
	//查看模块列表
	public function showlist() {
		if (!empty(I('get.module'))) {
			$news = D('news');
			$data = $news -> showlist(I('get.module'),I('get.p'));
			$name = $this -> getModuleName(I('get.module'));
			//定义分页类
			$Page = new \Think\Page($data[2],5);
			$Page -> setConfig('first','首页');
			$Page -> setConfig('end','最后一页');
			$Page -> setConfig('num','其他页的数字');
			$Page -> setConfig('prev','«');
			$Page -> setConfig('next','»');
			$Page -> setConfig('current','当前页');
			$Page -> setConfig('theme','<ul class="am-pagination"><li>%FIRST%</li> <li>%UP_PAGE%</li> <li>%LINK_PAGE%</li> <li>%DOWN_PAGE%</li> <li>%END%</li></ul>');
			$page = $Page->show(); 
			//输出模块名称
			$this -> assign('name', $name);	
			//输出模块列表
			$this -> assign('data', $data[1]);
			//输出分页信息
			$this -> assign('page', $page);
			//输出总记录数
			$this -> assign('sum', $data[2]);
			$this -> display();
		}
	}

	//查看模块名称
	public function getModuleName($id) {
		$name = M('module');
		return $name -> where("id = $id") -> find();
	}

	//创建新的信息
	public function add() {
		if (I('post.')) {
			$news = D('news');
			if (!$news -> autoCheckToken($_POST)) {
				// 令牌验证错误
				$this -> error('令牌验证错误，请刷新');
			} else {
				//上传图片
				$thumbnail = $this -> uploadthumbnail(I('post.module'),$_FILES['thumbnail']);
				//新增新闻信息
				$result = $news -> addNews(I('post.title'), I('post.content'), I('post.show'), I('post.top'), I('post.module'),  $thumbnail);
				if ($result != false) {
					$this -> success('新增成功', U('News/showlist') . '?module=' . I('post.module'));
				} else {
					$this -> error('新增失败');
				}
			}
		} else {
			$name = $this -> getModuleName(I('get.module'));
			$this -> assign('name', $name);
			$this -> display();
		}
	}

	//新闻缩略图上传方法
	private function uploadthumbnail($module,$thumbnail) {
		$upload = new \Think\Upload();
		// 实例化上传类
		$upload -> maxSize = 3145728;
		// 设置附件上传大小
		$upload -> exts = array('jpg', 'gif', 'png', 'jpeg');
		// 设置附件上传类型
		$upload -> savePath = '/News/' . $module . '/';
		// 设置附件上传目录
		$info = $upload -> uploadOne($thumbnail);
		if (!$info) {// 上传错误提示错误信息
			$this -> error($upload -> getError());
		}else{
			//生成缩略图
			$image = new \Think\Image(); 
			$image->open('./Uploads'.$info['savepath'] . $info['savename']);
			$image->thumb(160, 90,\Think\Image::IMAGE_THUMB_FIXED)->save('./Uploads'.$info['savepath'] . 'thumb_'.$info['savename']);
			unlink('./Uploads'.$info['savepath'] . $info['savename']);
			return '/Uploads' .$info['savepath'] . 'thumb_'.$info['savename'];
		}
	}

	//编辑新闻
	public function edit() {
		if (I('post.')) {
			$news = D('news');
			if (!$news -> autoCheckToken($_POST)) {
				// 令牌验证错误
				$this -> error('令牌验证错误，请刷新');
			} else {
				//上传图片
				if($_FILES['thumbnail']['size'] != 0){
					unlink(I('post.img'));
					$thumbnail = $this -> uploadthumbnail(I('post.module'),$_FILES['thumbnail']);
				}else{
					$thumbnail = I('post.img');
				}
				$result = $news -> edit(I('post.id'), I('post.title'), I('post.content'), I('post.show'), I('post.top'),$thumbnail);
				if ($result != false) {
					$this -> success('更新成功', U('News/showlist') . '?module=' . I('post.module'));
				} else {
					$this -> error('更新失败');
				}
			}
		} else {
			$news = M('news');
			$id = I('get.id');
			$data = $news -> where("id=$id") -> find();
			$this -> assign('data', $data);
			$name = $this -> getModuleName(I('get.module'));
			$this -> assign('name', $name);
			$this -> display();
		}
	}
	//删除信息
	public function del(){
		if(I('get.id')){
			$id = I('get.id');
			$del = M('news');
			$result = $del -> where("id = $id")->delete();
			if($result){
				$this -> success('删除成功', U('News/showlist') . '?module=' . I('get.module'));
			}else{
				$this -> error('删除失败');
			}
		}
	}
	//批量删除信息
	public function delMany(){
		if (I('post.')) {
			$news = D('news');
			if (!$news -> autoCheckToken($_POST)) {
				// 令牌验证错误
				$this -> error('令牌验证错误，请刷新');
			} else {
				$result = $news -> delManydata(I('post.blog_ids'));
				if($result){
					$this -> success('批量删除成功', U('News/showlist') . '?module=' . I('get.module'));
				}else{
					$this -> error('批量删除失败');
				}
			}
		}
	}

}
