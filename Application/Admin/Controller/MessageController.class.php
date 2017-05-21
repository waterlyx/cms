<?php
namespace Admin\Controller;
use Common\Controller\AdminController;
//创建邮件发送类
class MessageController extends AdminController {
	//邮件初始化方法
	public function install() {
		$email = M('email');
		$dataemail = $email -> find();
		$this -> assign('dataemail', $dataemail);
		$this -> display();
	}

	//邮件配置更新方法
	public function saveemail() {
		$email = M('email');
		if (!$email -> autoCheckToken($_POST)) {
			// 令牌验证错误
			$this -> error('令牌验证错误，请刷新');
		} else {
			$data['html'] = I('post.html');
			$data['charset'] = I('post.charset');
			$data['smtpauth'] = I('post.smtpauth');
			$data['smtpsecure'] = I('post.smtpsecure');
			$data['from'] = I('post.from');
			$data['fromname'] = I('post.fromname');
			$data['host'] = I('post.host');
			$data['username'] = I('post.username');
			$data['password'] = I('post.password');
			$data['port'] = I('post.port');
			$data['address'] = I('post.address');
			$data['subject'] = I('post.subject');
			$id = I('post.id');
			$result = $email -> where("`id` = $id") -> save($data);
			if ($result) {
				$this -> success('更新成功', U('Message/install'));
			} else {
				$this -> error('更新错误');
			}
		}
	}

}
