<?php
namespace Home\Controller;
use Common\Controller\HomeController;
//创建前台邮件发送类
class MessageController extends HomeController {
	//显示输入页面
	public function showlist() {
		$this -> display();
	}

	//发送邮件方法
	public function sendMail() {
		if (empty(I('post.content'))) {
			$this -> error('您未填写留言内容');
		} else {
			//AJAX调用发送函数
			$name = I('post.name');
			$content = I('post.content');
			$email = I('post.email');
			//设置邮件发送的隐藏字段验证
			$key = md5(time());
			session('key',$key);
			$str = <<<EOF
			<script src="/Public/jquery.min.js"></script>
			<script>
				$.post(
					"/Home/Message/phpMailer",{
					name:"$name",
					content:"$content",
					email:"$email",
					key:"$key"
					}
				)
			</script>
EOF;
	$this -> success('感谢您的留言', U('Index/index'));
	echo $str;
		}
	}

	/**
	 * 邮件发送函数
	 */
	public function phpMailer() {
		//接收邮件信息
		$name = I('post.name');
		$content = I('post.content');
		$email = I('post.email');
		$key = I('post.key');
		//验证发送邮件的来源
		if(session('key') !== $key){
			return 0;
		}
		//拼接邮件的内容
		$emailcontent = '客户：'.$name.'<br>邮件地址：'.$email.'<br>留言：'.$content;
		//从数据库获取邮件配置
		$email = M('email');
		$dataemail = $email -> find();
		//引入发送邮件的核心类文件
		Vendor('PHPMailer.PHPMailerAutoload');
		//实例化邮件发送的对象
		$mail = new \PHPMailer();
		// 设置为要发邮件
		$mail -> IsSMTP();
		// 是否允许发送“HTML代码”做为邮件的内容
		$html = $dataemail['html']==1?TRUE:FALSE;
		$mail -> IsHTML($html);
		$mail -> CharSet = $dataemail['charset'];
		// 是否需要身份验证
		$smtpauth = $dataemail['smtpauth']==1?TRUE:FALSE;
		$mail -> SMTPAuth = $smtpauth;
		//设置使用ssl加密方式登录鉴权
		$mail -> SMTPSecure = $dataemail['smtpsecure'];
		/*  邮件服务器上发送方账号设置 start*/
		$mail -> From = $dataemail['from'];
		//发送方邮件地址
		$mail -> FromName = $dataemail['fromname'];
		//发送方名称，会显示在邮件的内容中，可以自定义
		$mail -> Host = $dataemail['host'];
		//发送邮件的服务协议地址，中转邮件服务器地址
		$mail -> Username = $dataemail['username'];
		//发送方帐号
		$mail -> Password = $dataemail['password'];
		//发送方帐号密码
		/*  邮件服务器上发送方账号设置 end*/
		// 发邮件端口号默认25
		$mail -> Port = $dataemail['port'];
		// 收件人
		$mail -> AddAddress($dataemail['address']);
		// 邮件标题
		$mail -> Subject = $dataemail['subject'];
		// 邮件内容
		$mail -> Body = $emailcontent;
		return ($mail -> Send());
		//发送邮件
	}

}
