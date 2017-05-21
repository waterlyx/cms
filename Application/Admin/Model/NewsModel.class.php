<?php
namespace Admin\Model;
use Think\Model;
//创建一个公共的模块控制器
class NewsModel extends Model {
	//查看新闻列表
	public function showlist($module,$p){
//		return $this->where("module = $module")->order('think_news.id')->select();
        $showlist[1] = $this -> where("module = $module")->order('think_news.id desc')->page($p,5) ->select();
		$showlist[2] = $this->where("module = $module")->count();
		return $showlist;
	} 
	//添加新的新闻
	public function addNews($title,$content,$show,$top,$module,$img){
		$data['title'] = $title;
		$data['content'] = $content;
		$data['time'] = time();
		$data['show'] = $show;	
		$data['top'] = $top;
		$data['hits'] = 0;
		$data['module'] = $module;
		$data['img'] = $img;
		return $this->add($data);
	}
	//更新新闻
	public function edit($id,$title,$content,$show,$top,$img){
		$data['id'] = $id;
		$data['title'] = $title;
		$data['content'] = $content;
		$data['time'] = time();
		$data['show'] = $show;	
		$data['top'] = $top;
		$data['img'] = $img;	
		return $this -> save($data);
	}
	//批量删除数据
	public function delManydata($data){
		return $this ->where("`id` IN ($data)") ->delete();
	}
}