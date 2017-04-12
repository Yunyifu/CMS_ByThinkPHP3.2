<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

/*
 * 后台计划任务
 */
class CronController{
    public function dumpmysql(){
        $result = D('Basic')->show();
        if(!$result['dumpmysql']){
            die("数据库备份的系统设置未打开");
        }
        $shell = "mysqldump -u".C("DB_USER")."".C("DB_NAME")." > /tmp/cms".date("Ymd")."sql";
        exec($shell);
    }
}