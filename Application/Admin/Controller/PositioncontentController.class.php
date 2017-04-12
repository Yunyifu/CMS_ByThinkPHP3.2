<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;


class PositionContentController extends CommonController{
    public function index(){
        //获取标题
        $positions = D('Position')->getNormalPosition();
        //获取推荐为内容
        $data['status'] = array('neq',-1);
        if($_GET['title']){
            $data['title'] = trim($_GET['title']);
            $this->assign('title',$data['title']);
        }
        $data['position_id'] = $_GET['position_id']?intval($_GET['position_id']):1;
       // dump($data);exit;
        $page = $_REQUEST['p']?$_REQUEST['p']:1;
        $pageSize = 3;
        $contents = D('PositionContent')->select($data,$page,$pageSize);
        //$res = D('PositionContent')->findall();

        //dump($contents);exit;

        $positions = M('position_content'); // 实例化User对象
        $count      = $positions->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        //dump($show);exit;
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        //$list = $User->where('status=1')->order('create_time')->limit($Page->firstRow.','.$Page->listRows)->select();
        //$this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->assign('contents',$contents);
        $this->assign('positions',$positions);
        $this->assign('positionId',$data['position_id']);
        $this->display();
    }

    public function add(){
        if($_POST){
            if(!isset($_POST['position_id']) || !$_POST['position_id']){
                return show(0,'推荐位ID不能为空');
            }
            if(!isset($_POST['title']) || !$_POST['title']){
                return show(0,'推荐位标题不能为空');
            }
            if(!isset($_POST['url']) && !$_POST['news_id']){
                return show(0,'url和ID不能同时为空');
            }
           /* if(!isset($_POST['thumb']) || !$_POST['thumb']){
                return show(0,'图片不能为空');
            }*/
        if($_POST['id']){
            return $this->save($_POST);
        }
        try{
           $id = D('PositionContent')->insert($_POST);
            if($id){
                return show(1,'新增成功');
            }else{
                return show(0,'新增失败');
            }
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }
        }else{

        $positions = D('Position')->getNormalPosition();
        $this->assign('positions',$positions);
        $this->display();
        }
    }

    public function edit(){
        $id = $_GET['id'];
        $position = D('PositionContent')->find($id);
        //dump($position);exit;
        $positions = D('Position')->getNormalPosition();
        $this->assign('positions',$positions);
        $this->assign('vo',$position);

        $this->display();
    }

    public function save($data){
        $id = $data['id'];
        unset($data['id']);

        try{
            $resID = D('PositionContent')->updataByID($id,$data);
            if($resID === false){
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch(Exception $e){
            return show(0,$e->getMessage());
        }
    }

   /* public function setStatus(){
        $data =array(
            'id'=>intval($_POST['id']),
            'status'=>intval($_POST['status'])
        );

        return parent::setStatus($data,'PositionContent');
    }*/
    public function setStatus(){
        try{
            if($_POST){
                $id = $_POST['id'];
                $status = $_POST['status'];

                if(!$id){
                    return show(0,'ID不存在');
                }
                $res = D('PositionContent')->updataStatusById($id,$status);
                if($res){
                    return show(1,'操作成功');
                }else{
                    return show(0,'操作失败');
                }
            }
            return show(0,'没有提交的内容');
        }catch (Exception $e){
            return show(0,$e->getMessage());
        }
    }

    public function listorder(){
        return parent::listorder('PositionContent');
    }


}