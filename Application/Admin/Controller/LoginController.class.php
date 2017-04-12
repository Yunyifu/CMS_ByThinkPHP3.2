<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

    public function index(){
        if(session('adminUser')) {
            $this->redirect('/index.php?m=admin&c=index');
        }
                // admin.php?c=index
        $this->display();
    }

    public function check() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(!trim($username)) {
            return show(0,'后台检测到校验用户名为空');
        }
        if(!trim($password)) {
            return show(0,'后台检测到校验密码为空');
        }

        $ret = D('Admin')->getAdminByUsername($username);
        if(!$ret || $ret['status'] !=1) {
            return show(0,'该用户不存在');
        }

        if($ret['password'] != getMd5Password($password)) {
            return show(0,'密码错误');
        }

        D("Admin")->updateByAdminId($ret['admin_id'],array('lastlogintime'=>time()));

        session('adminUser', $ret);
        return show(1,'登录成功');


    }

    public function loginout() {
        session('adminUser', null);
        $this->redirect('/admin.php?m=admin&c=login');
    }

}