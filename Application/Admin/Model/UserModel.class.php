<?php
namespace Admin\Model;
use Think\Model;
class UserModel extends Model {
	//验证用户的正确
	public function checkUser($username,$passsword){
		$passsword = md5($passsword);
		return $this->where("username = '$username' AND password = '$passsword'")->field('id')->find();
	}
	//记录用户登陆时间
	public function saveLoginTime($id){
		//获取上一次的登陆时间
		$time = $this->where("id = $id")->field('nowlogintime')->find();
		//记录这一次的登陆时间
		$data['logintime'] = $time['nowlogintime'];
		$data['nowlogintime'] = time();
		return $this->where("id = $id")->save($data);
	}
}