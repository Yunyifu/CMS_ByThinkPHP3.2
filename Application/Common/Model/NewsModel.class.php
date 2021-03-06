<?php
namespace Common\Model;
use Think\Model;



class NewsModel extends Model{
    private $_db = '';

    public function __construct()
    {
        $this->_db = M('news');
    }

    public  function insert($data=array()){
        if(!is_array($data)||!$data){
            return 0;
        }

        $data['create_time']=time();
        $data['username']= getLoginUsername();
         return $this->_db->add($data);
    }

    public function getNews($data,$page,$pageSize=10){
        $conditions = $data;
        if(isset($data['title'])&&$data['title']){
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid'])&&$data['catid']){
            $conditions['catid']=intval($data['catid']);

        }
        $conitions['status'] = array('neq',-1);
        $offset = $page;
        $list = $this->_db->where($conditions)
            ->order('listorder desc,news_id desc')
            ->page($offset,$pageSize)
            ->select();

        return $list;
    }

    public function getNewsCount($data = array())
    {
        $conditions = $data;
        if (isset($data['title']) && $data['title']) {
            $conditions['title'] = array('like','%'.$data['title'].'%');
        }
        if (isset($data['catid']) && $data['catid']) {
            $conditions['catid'] = intval($data['catid']);
        }
         return $this->_db->where($conditions)->count();
    }

    //通过ID过去文章内容
    public  function find($id){
        return $data = $this->_db->where('news_id='.$id)->find();
    }

    //更新操作
    public function updataById($id,$data){
        if(!$id||!is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data||!is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('news_id='.$id)->save($data);
    }

    public function updataStatusById($id,$status){
        if(!is_numeric($status)){
            throw_exception('status不能为非数字');
        }
        if(!$id||!is_numeric($id)){
            throw_exception('id不合法');
        }
        $data['status'] = $status;
        return $this->_db->where('news_id='.$id)->save($data);
    }

    public function updataNewsListorderById($id,$listorder){
        if(!$id||!is_numeric($id)){
            throw_exception('ID不合法');
        }
        $data = array('listorder'=>intval($listorder));
        return $this->_db->where('news_id='.$id)->save($data);

    }

    public function getNewsByNewsIdIn($newsIds){
        if(!is_array($newsIds)){
            throw_exception("参数不合法");
        }
        $data = array(
            'news_id'=>array('in',implode(',',$newsIds)),
        );

        return $this->_db->where($data)->select();
    }

    /*
     * 获取排行数据
     */
    public function getRank($data=array(),$limit=100){
        $list = $this->_db->where($data)->order('count desc,news_id desc')->select();
        return $list;
    }

    public function select($data = array(),$limit = 0){

        $this->_db->where($data)->order('news_id desc')->select();
        if($limit){
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();

        return  $list;

       /* if($data['status']){
            $this->_db->where($data)->order('id desc')->select();
        }

        if($limit){
            $this->_db->limit($limit);
        }
        $list = $this->_db->select();

        return  $list;*/
    }

    public function updateCount($id,$count){
        if(!$id || !is_numeric($id)){
            throw_exception("ID不合法");
        }
        if(!is_numeric($count)){
            throw_exception("count不能为非数字");
        }
        $data['count'] = $count;
        return $this->_db->where('news_id='.$id)->save($data);
    }

    public function maxcount(){
        $data = array('status'=>1,);
        return $this->_db->where($data)->order('count desc')->limit(1)->find();
    }


}