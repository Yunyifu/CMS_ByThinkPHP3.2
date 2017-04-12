<?php
namespace Admin\Controller;
use Think\Controller;


class BasicController extends Controller{

    public function index(){

        $result = D('Basic')->show();
        $this->assign('vo',$result);
        $this->assign('type',1);
        $this->display();
    }


    public function add(){
        if($_POST){
            if(!$_POST['title']){
                return show(0,'标题不能为空');
            }
            if(!$_POST['keywords']){
                return show(0,'关键字不能为空');
            }
            if(!$_POST['description']){
                return show(0,'描述不能为空');
            }

            $res = D('Basic')->save($_POST);
            return show(1,'配置成功');
        }else{
            return show(0,'没有提交的数据');
        }
    }

    public function cache(){
        $this->assign('type',2);
        $this->display();
    }

}