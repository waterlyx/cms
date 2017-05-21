<?php
namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller
{
    /**
     * 用户登陆控制器
     */
    public function login()
    {
        if (!empty(session('userId'))) {
            redirect('/Admin/Index/index');
        }
        //接收用户输入的表单
        if (I('post.')) {
        	
        	if(I('post.remember') == 'on'){
        		cookie('username',I('post.username'));
        		cookie('password',I('post.password'));
        	}else{
        		cookie('username',null);
        		cookie('password',null);
        	}
            $User = D("User");
            if (!$User->autoCheckToken($_POST)) {
                // 令牌验证错误
                $this->error('令牌验证错误，请刷新');
            } else {
                $this->assign('username',I('post.username'));
                //验证用户名是否正确
                if (check_verify(I('post.identifier')) == false) {
                    $this->error('验证码输入错误！', U('User/login')."?username=".I('post.username'));
                }
                //判断用户名和密码是否正确
                $userId = $User->checkUser(I('post.username'), I('post.password'));
                if ($userId['id'] != false) {
                	//记录用户的登陆时间
                	$userlogin = $User -> saveLoginTime($userId['id']);
                    //将登陆用户的ID存到session中
                    session('userId', $userId['id']);
                    $this->success('登陆成功', U('Index/index'));
                } else {
                    $this->error('用户名或密码错误！', U('User/login')."?username=".I('post.username'));
                }
            }
        } else {
        	$index = M('index');
			$dataindex = $index -> find();
			$this -> assign('dataindex',$dataindex);
            $this->display();
        }
    }

    /**
     * 用户登陆验证码
     */
    public function identifier()
    {
        $Verify = new \Think\Verify();
        $Verify->fontSize = 20;
        $Verify->length = 3;
        $Verify->codeSet = '0123456789';
        $Verify->useNoise = false;
        $Verify->entry();
    }
	//用户退出方法
    public function logoff(){
    	//销毁session
    	session(null);
    	$this->success('您已安全退出',U('User/login'));
    }
}