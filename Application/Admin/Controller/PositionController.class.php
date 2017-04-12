<?php
namespace Admin\Controller;
use Think\Controller;


class PositionController extends CommonController{
    public function index(){
        $data = array();
        //$page = $_REQUEST['p']?$_REQUEST['p']:1;
        //$pageSize = $_REQUEST['pageSize']?$_REQUEST['pageSize']:10;

        $position = D('Position')->getPosition($data);
      //  $positionCount = D('Position')->getPositionCount($data);

       // $res = new\Think\Page($positionCount,$pageSize);
      //  $pageRes = $res->show();
        $this->assign('positions',$position);


        //$this->assign('pageRes',$pageRes);

        $this->display();
    }


    public function add(){
        $this->display();
    }
}