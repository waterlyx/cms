<?php
namespace Admin\Model;
use Think\Model;
class CultureModel extends Model {
	//查看企业文化
	public function showlist(){
		return $this->find();
	}
	//更新企业文化
	public function edit($id,$content){
		return $this->where("id = $id")->setField('content',$content);
	}
}