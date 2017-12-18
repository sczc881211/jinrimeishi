<?php
namespace app\admin\controller;
use think\Db;
class Admin extends Base{
    public function admin_list(){
        $admin_list = model('Admin')->getAdminList();

        $this->assign('admin_list', $admin_list);
        $this->assign('admin_list_count', count($admin_list));
        return $this->fetch();
    }
    //管理员添加
    public function admin_add() {
        if(request()->isPost()){
            $admin_name = input('adminName');
            $password = input('password');
            $phone = input('phone');
            if(!$admin_name){
                $this->error('管理员账号不能为空');
            }
            if(!preg_match("/^1[34578]\d{9}$/",$phone)){
                $this->error('请输入正确的手机号码');
            }
            if(!preg_match("/^.{6,}$/",$password)){
                $this->error('密码为6位以上');
            }
            $data['admin_name'] = $admin_name;
            $data['password'] = md5(md5($password));
            $data['phone'] = $phone;
            $data['email'] = input('email');
            $data['sex'] = input('sex');
            $data['remark'] = input('remark');
            $data['add_time'] = time();
            $data['status'] = 1;//数据库默认值
            if(Db::name('admin')->insert($data)){
                $this->success('管理员添加成功', url('Admin/admin_list'), 1);
            }else{
                $this->error('管理员添加失败，请重试');
            }
            return ;
        }
        return $this->fetch();
    }
    //管理员修改
    public function admin_edit() {
        if(request()->isPost()){
            $admin_id = input('admin_id');
            $admin_name = input('adminName');
            $phone = input('phone');
            if(!$admin_name){
                $this->error('管理员账号不能为空');
            }
            if(!preg_match("/^1[34578]\d{9}$/",$phone)){
                $this->error('请输入正确的手机号码');
            }
            $data['admin_name'] = $admin_name;
            $data['phone'] = $phone;
            $data['email'] = input('email');
            $data['sex'] = input('sex');
            $data['remark'] = input('remark');
            if(Db::name('admin')->where(array('admin_id'=>$admin_id))->update($data)){
                $this->success('管理员修改成功', url('Admin/admin_list'), 1);
            }else{
                $this->error('管理员修改失败，请重试');
            }
            return ;
        }
        $admin_id = input('admin_id');
        $info = Db::name('admin')->where(array('admin_id'=>$admin_id))->find();
        $this->assign('info', $info);
        return $this->fetch();
    }

    //工作人员删除
    public function admin_del() {
        $admin_id = input('admin_id');
        if(Db::name('admin')->where(array('admin_id'=>$admin_id))->delete()){
            $this->success('删除成功',url('user_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //批量删除
    public function admin_delall(){
        $admin_ids = input('admin_ids');
        $admin_id_arr = explode(',', $admin_ids);
        $where['admin_id'] = array('in', $admin_id_arr);
        if(Db::name('admin')->where($where)->delete()){
            $this->success('删除成功', url('Admin/admin_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //用户停用
    public function admin_stop() {
        $where['admin_id'] = input('admin_id');
        $save['status'] = 2; //停用
        if(Db::name('admin')->where($where)->update($save)){
            $this->success('停用成功', url('Admin/admin_list'), 1);
        }else{
            $this->error('停用失败');
        }
    }
    //用户启用
    public function admin_start() {
        $where['admin_id'] = input('admin_id');
        $save['status'] = 1; //启用
        if(Db::name('admin')->where($where)->update($save)){
            $this->success('启用成功', url('Admin/admin_list'), 1);
        }else{
            $this->error('启用失败');
        }
    }

}