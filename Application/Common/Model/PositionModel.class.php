<?php
namespace Common\Model;
use Think\Model;



class PositionModel extends Model{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M('position');
    }



    public function getPosition($data=array()){
        $conditions = $data;
        $conditions['status'] = array('neq',-1);
        $list = $this->_db
            ->where($conditions)
            ->order('id')
            ->select();
        return $list;
        }

    public function getNormalPosition(){
        $conditions['status'] = array('neq',-1);
        $list = $this->_db
            ->where($conditions)
            ->order('id')
            ->select();
        return $list;
    }



    public function getPositionCount($data = array()){
        $conditions = $data;
        $conitions['status'] = array('neq',-1);
        return $this->_db->where($conditions)->count();


    }
}