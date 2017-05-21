<?php
namespace Home\Controller;
use Common\Controller\HomeController;
class NewsController extends HomeController {
	//前台显示模块数据列表
    public function showlist(){
    	$news = D('News');
		//获取模块的ID
		$mid = I('get.mid');
		//获取模块的名称
		$module = M('module');
		$datamodule = $module -> cache(true,60)->where("id = $mid")->find();
		$this -> assign('datamodule',$datamodule);
		$datalist = $news -> showlist($mid,I('get.p'));
		//定义分页类
		$Page = new \Think\Page($datalist[2],5);
		$Page -> setConfig('first','首页');
		$Page -> setConfig('end','最后一页');
		$Page -> setConfig('num','其他页的数字');
		$Page -> setConfig('prev','«');
		$Page -> setConfig('next','»');
		$Page -> setConfig('current','当前页');
		$Page -> setConfig('theme','<ul class="am-pagination"><li>%FIRST%</li> <li>%UP_PAGE%</li> <li>%LINK_PAGE%</li> <li>%DOWN_PAGE%</li> <li>%END%</li></ul>');
		$page = $Page->show(); 
		//输出分页信息
		$this -> assign('page',$page);
		//输出数据的列表
		$this -> assign('datalist',$datalist[1]);
    	$this->display();
    }
	//前台显示数据的详细信息
	public function details(){
		//获取模块的ID
		$mid = I('get.mid');
		//获取模块的名称
		$module = M('module');
		$datamodule = $module -> cache(true,60)->where("id = $mid")->find();
		//向视图输出模块名称
		$this -> assign('datamodule',$datamodule);
		//获取数据的id
		$did = I('get.did');
		//实例化数据对象
		$content = M('News');
		//数据点击数加1
		$content -> where("id = $did") ->setInc('hits'); 
		//获取数据详情
		$datacontent = $content ->cache(true,60)-> where("id = $did")->find();
		$this -> assign('datacontent',$datacontent);
		$this->display();
	}
	
}