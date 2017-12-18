<?php
namespace app\admin\controller;
use think\Db;
//评论管理
class Comment extends Base{
    public function comment_list(){
        $keywords = input('keywords');
        $where    = '';
        if($keywords){
            $where['c.content'] = ['like', '%'.$keywords.'%'];
        }
        $bg_date  = input('bg_date');
        $end_date = input('end_date');
        $bg_time  = strtotime($bg_date);
        $end_time = strtotime($end_date);
        if($bg_time && !$end_time){
            $where['c.add_time'] = ['egt', $bg_time];
        }elseif (!$bg_time && $end_time){
            $where['c.add_time'] = ['elt', $end_time];
        }elseif ($bg_time && $end_time){
            $where['c.add_time'] = ['between', [$bg_time, $end_time]];
        }
		//评论信息
        $comment = Db::name('comment');
        $order   = ' c.id desc';
        $join    = [
            ['__ARTICLE__ a', 'c.art_id = a.id', 'LEFT' ],
            ['__USER__ u', 'u.id = c.user_id', 'LEFT' ]
        ];
        $field = 'c.*,a.title,a.id as a_id,u.nickName';
        $list  = $comment->alias('c')->where($where)->field($field)->join($join)->order($order)->paginate(10);
		//美食信息
        $articleModel = Db::name('article');
        $article      = $articleModel->alias('a')->select();
        //获取共有多少条评论数据
        $num = count($comment->select());
		$this->assign('bg_date', $bg_date);
		$this->assign('keywords', $keywords);
        $this->assign('end_date', $end_date);
        $this->assign('comment_list', $list);
        $this->assign('num', $num);
        $this->assign('page', $list->render());
        return $this->fetch();
    }
    //美食删除
    public function comment_del() {
        $id = (int)input('id');
        if(!$id) {
            $this->error('参数不正确');
        }
        if(Db::name('comment')->where(['id'=>$id])->delete()){
            $this->success('删除成功',url('Comment/comment_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //美食批量删除
    public function comment_delall(){
        $ids         = input('ids');
        $id_arr      = explode(',', $ids);
        $where['id'] = ['in', $id_arr];
        if(Db::name('comment')->where($where)->delete()){
            $this->success('删除成功', url('Comment/comment_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //美食停用
    public function comment_stop() {
        $id = (int)input('id');
        if(!$id){
            $this->error('参数不正确');
        }
        $where['id']    = $id;
        $save['status'] = 2; //停用
        if(Db::name('comment')->where($where)->update($save)){
            $this->success('停用成功', url('Comment/comment_list'), 1);
        }else{
            $this->error('停用失败');
        }
    }
    //美食启用
    public function comment_start() {
        $id = (int)input('id');
        if(!$id){
            $this->error('参数不正确');
        }
        $where['id']    = $id;
        $save['status'] = 1; //启用
        if(Db::name('comment')->where($where)->update($save)){
            $this->success('启用成功', url('Comment/comment_list'), 1);
        }else{
            $this->error('启用失败');
        }
    }
}
