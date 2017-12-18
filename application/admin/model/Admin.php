<?php
namespace app\admin\model;
use think\Model;
//后台管理员模型
class Admin extends Model {
    //验证用户名和密码
    public function checkUser($username,$password){
        $condition['admin_name'] = $username;
        $condition['password'] = md5(md5($password));
        $condition['status'] = 1;//启用状态
        if ($admin = $this->where($condition)->find()) {
            //成功，保存session标识，并跳转到首页
            session('admin_id', $admin['admin_id']);
            session('admin',$admin);
            return true;
        } else {
            return false;
        }
    }
    /**
     * 管理员列表
     *
     * @param array $condition 检索条件
     * @param obj $obj_page 分页对象
     * @return array 数组类型的返回结果
     */
    public function getAdminList($condition = ''){
        $condition_str = $this->_condition($condition);
        $result = $this->where($condition_str)->select();
        return $result;
    }

    /**
     * 构造检索条件
     *
     * @param array $condition 检索条件
     * @return string 字符串类型的返回结果
     */
    public function _condition($condition){
        $condition_str = '';

        if (isset($condition['admin_id']) && $condition['admin_id'] != ''){
            $condition_str .= " admin_id = '". $condition['admin_id'] ."'";
        }
        if (isset($condition['admin_name']) && $condition['admin_name'] != ''){
            $condition_str .= " and admin_name = '". $condition['admin_name'] ."'";
        }
        if (isset($condition['password']) && $condition['password'] != ''){
            $condition_str .= " and password = '". $condition['password'] ."'";
        }

        return $condition_str;
    }
}