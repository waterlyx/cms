<?php
namespace Home\Model;
use Think\Model;
//创建一个公共的模块控制器
class NewsModel extends Model {
	public function showlist($mid,$p){
		//生成数据的列表
		$showlist[1] = $this ->cache(true,60)->where("`show`='1' AND module = $mid")->order('top desc,time desc')->page($p,5) -> select();
		//生成分页的总数
		$showlist[2] = $this ->cache(true,60)->where("`show`='1' AND module = $mid")->order('top desc,time desc') ->count();
		return $showlist;
	}
}