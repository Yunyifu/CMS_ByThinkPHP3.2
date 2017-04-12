<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index($type=''){
        //获取首页大图
        $topPicNews =  D('PositionContent')->select(array('status'=>1,'position_id'=>2),1);
        $topsmallNews =  D('PositionContent')->select(array('status'=>1,'position_id'=>3),3);



        $listNews = D('News')->select(array('status'=>1,'thumb'=>array('neq','')),30);



        $advNews =  D('PositionContent')->select(array('status'=>1,'position_id'=>5),2);

        //$a = A("CommonController");
        //$rankNews = R('Home/CommonController/getRank');
        $rankNews = $this->getRank();

        //dump($topPicNews);exit;
        $this->assign('result',array('topPicNews'=>$topPicNews,
            'topsmallNews'=>$topsmallNews,
            'listNews'=>$listNews,
            'advNews'=>$advNews,
            'rankNews'=>$rankNews,
            'catId'=>0,
        ));
        /*
         * 页面静态化
         */
        if($type=='buildHtml')
        {
            $this->buildHtml('index',HTML_PATH,'Index/index');
        }else{
        $this->display();
        }

    }
    public function build_html(){
        $this->index('buildHtml');
        return show(1,'首页缓存生成成功!');
    }

    public function crontab_build_html(){

        $this->index('buildHtml');

    }

    public function getCount(){
        if(!$_POST){
            return show(0,'没有任何内容');
        }
        $newsIds = array_unique($_POST);
        try{
            $list = D('News')->getNewsByNewsIdIn($newsIds);
        }catch(Expection $e){
            return show(0,$e->getMessage());
        }

        if(!$list){
            return show(0,'没有数据');
        }
        $data = array();
        foreach($list as $k=>$v){
            $data[$v['news_id']] = $v['count'];
        }
        return show(1,'success',$data);
    }


}