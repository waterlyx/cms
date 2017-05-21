<?php
namespace Admin\Model;
use Think\Model;
class AboutModel extends Model {
	//查看企业简介
	public function showlist(){
		return $this->find();
	}
	//更新企业简介
	public function edit($id,$content){
		return $this->where("id = $id")->setField('content',$content);
	}
}