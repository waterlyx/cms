<?php
namespace Admin\Model;
use Think\Model;
class ModuleModel extends Model {
	//模块展示方法
	public function showlist(){
		return $this->join('__NEWS__ ON __MODULE__.id = __NEWS__.module','LEFT')->field('think_module.id,namezh,nameen,think_module.show,think_module.index,count(think_news.id) as number')->group('think_module.id')->select();
	}
	//模块增加方法
	public function addModule($nameZh,$nameEn,$show,$index){
		$data['nameZh'] = $nameZh;
		$data['nameEn'] = $nameEn;
		$data['show'] = $show;
		//返回模块的首页显示数量
		$number = $this -> where("`index` = 1")-> count();
		if($index + $number > 2){
			return 3;
		}
		$data['index'] = $index;
		return $this->add($data);
	}
	//显示指定的模块内容
	public function showOne($id){
		return $this -> where("id = $id")->find();
	}
	//模块修改方法
	public function saveModule($id,$nameZh,$nameEn,$show,$index){
		$data['nameZh'] = $nameZh;
		$data['nameEn'] = $nameEn;
		$data['show'] = $show;
		$number = $this -> where("`index` = 1")-> count();
		if($index + $number > 2){
			return 3;
		}
		$data['index'] = $index;
		return $this->where("`id` = $id")-> save($data);
	}
	//删除模块
	public function delOne($id){
		$news = M('news');
		$number = $news -> where("module = $id")->count();
		if($number > 0){
			return 3;
		}else{
			return $this->where("id = $id")->delete();
		}
		
	}
}