<?php
namespace app\admin\controller;
use think\Db;
//评论用户管理
class User extends Base{
    public function user_list(){
        $keywords = input('keywords');
        $where    = [];
        if($keywords){
            $where['nickName'] = ['like', '%'.$keywords.'%'];
        }
        $bg_date  = input('bg_date');
        $end_date = input('end_date');
        $bg_time  = strtotime($bg_date);
        $end_time = strtotime($end_date);
        if($bg_time && !$end_time){
            $where['add_time'] = ['egt', $bg_time];
        }elseif (!$bg_time && $end_time){
            $where['add_time'] = ['elt', $end_time];
        }elseif ($bg_time && $end_time){
            $where['add_time'] = ['between', [$bg_time, $end_time]];
        }
		//评论信息
        $user  = Db::name('user');
        $order = ' id desc';
        $num   = count($user->select());
        $list  = $user->where($where)->order($order)->paginate(5);
		$this->assign('bg_date', $bg_date);
		$this->assign('keywords', $keywords);
        $this->assign('end_date', $end_date);
        $this->assign('user_list', $list);
        $this->assign('num', $num);
        $this->assign('page', $list->render());
        return $this->fetch();
    }
    //评论用户删除
    public function user_del() {
        $id = (int)input('id');
        if(!$id) {
            $this->error('参数不正确');
        }
        if(Db::name('user')->where(['id'=>$id])->delete()){
            $this->success('删除成功',url('User/user_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //用户批量删除
    public function user_delall(){
        $ids         = input('ids');
        $id_arr      = explode(',', $ids);
        $where['id'] = ['in', $id_arr];
        if(Db::name('user')->where($where)->delete()){
            $this->success('删除成功', url('User/user_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //用户停用
    public function user_stop() {
        $id = (int)input('id');
        if(!$id){
            $this->error('参数不正确');
        }
        $where['id']    = $id;
        $save['status'] = 2; //停用
        if(Db::name('user')->where($where)->update($save)){
            $this->success('停用成功', url('User/user_list'), 1);
        }else{
            $this->error('停用失败');
        }
    }
    //用户启用
    public function user_start() {
        $id = (int)input('id');
        if(!$id){
            $this->error('参数不正确');
        }
        $where['id']    = $id;
        $save['status'] = 1; //启用
        if(Db::name('user')->where($where)->update($save)){
            $this->success('启用成功', url('User/user_list'), 1);
        }else{
            $this->error('启用失败');
        }
    }
}
