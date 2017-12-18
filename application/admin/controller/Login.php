<?php
namespace app\admin\controller;
use think\Controller;
//登录控制器
class Login extends Controller {
    //显示登录页面并验证
    public function login(){
        if (request()->isPost()) {
            //获取验证码、用户名和密码
            $username = input('username');
            $password = input('password');
            //验证,注意顺序
            //先检查验证码
//            $verify = new \Think\Verify();
//            if (!$verify->check($captcha)){
//                $this->error('验证码错误', '', true);
//            }

            //再来检查用户名和密码,调用模型来完成
            if (model('Admin')->checkUser($username,$password)) {
                $this->success('登录成功',url('Index/index'),1);
            } else {
                $this->error('用户名或密码错误');
            }
            return;
        }
        if(session('admin_id')){
            $this->redirect('Index/index');
        }
        // 载入登录页面
        return $this->fetch();
    }

    //生成验证码
    public function code(){
        $Verify = new \Think\Verify();
        $Verify->length   = 4;
        $Verify->entry();
    }

    //注销
    public function logout(){
        session('admin_id', null); // 销毁session,清空所有
        $this->redirect('Login/login');
    }

}