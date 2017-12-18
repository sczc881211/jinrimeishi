<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Base extends Controller {
    //构造方法
    public function __construct(){
        parent::__construct(); //一定要调用父类的构造方法
        $this->checkLogin();
        $count_admin = Db::name('admin')->where(['status'=>1])->count();
        $count_article = Db::name('article')->where(['status'=>1])->count();
        $count_comment = Db::name('comment')->where(['status'=>1])->count();
        $this->assign('count_admin', $count_admin);
        $this->assign('count_article', $count_article);
        $this->assign('count_comment', $count_comment);
    }
    //验证是否登录
    public function checkLogin()
    {
        //通过session来验证
        if (!session('admin_id')) {
            $this->redirect('Login/login');
        }
        $this->admin = session('admin');
        $set = Db::name('setting')
            ->find();
        $this->assign('set', $set);
    }
}