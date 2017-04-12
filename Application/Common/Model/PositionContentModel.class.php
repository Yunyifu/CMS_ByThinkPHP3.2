<?php
namespace Common\Model;
use Think\Model;



class PositionContentModel extends Model
{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M('position_content');
    }

    public function insert($data=array()){
        if(!$data){
            return 0;
        }
        //$data['create_time'] = time();
        //if(isset($data['content'])&&$data['content']){
         //   $data['content'] = htmlspecialchars($data['content']);
       // }
        if(!$data['creat_time']){
            $data['creat_time'] = time();
        }

        return $this->_db->add($data);
    }

    public function select($data = array(),$page=1,$pageSize=5){
           if($data['title']){
            $data['title'] = array('like', '%'.$data['title'].'%');
            }
            $this->_db->where($data)->order('id desc')->select();
            $p = $page;
            $list = $this->_db->page($p,$pageSize)->select();

            return  $list;

        }
    public function getPositionCount($data,$page,$pageSize=5){
        $conditions = $data;
        if(isset($data['title'])&&$data['title']){
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        $conitions['status'] = array('neq',-1);
        $offset = $page;
        $list = $this->_db->where($conditions)
            ->page($offset,$pageSize)
            ->select();

        return $list;
    }

    public function find($id){

        $res = $this->_db->where('id='.$id)->find();
        return $res;
    }

    public function updataById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception("更新的数据不合法");
        }

        return $this->_db->where('id='.$id)->save($data);

    }

    public function updataStatusById($id,$status){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!is_numeric($status)){
            throw_exception("status不能为非数字");
        }
        $data['status'] = $status;
        return $this->_db->where('id='.$id)->save($data);
    }

    public function updataListorderById($id,$listorder){
        $data = array('listorder'=>$listorder);
        return $this->_db->where('id'.$id)->save($data);
    }



}