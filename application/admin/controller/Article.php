<?php
namespace app\admin\controller;
use think\Db;
use think\Request;
use location;
//美食管理
class Article extends Base{
    //美食管理列表
    public function article_list(){
        $keywords = input('keywords');
        $where = [];
        //获取搜索关键字
        if($keywords){
            $where['title'] = ['like', '%'.$keywords.'%'];
        }
        //发布日期的起止时间
        $bg_date = input('bg_date');
        $end_date = input('end_date');
        $bg_time = strtotime($bg_date);
        $end_time = strtotime($end_date);
        if($bg_time && !$end_time){
            $where['add_time'] = ['egt', $bg_time];
        }elseif (!$bg_time && $end_time){
            $where['add_time'] = ['elt', $end_time];
        }elseif ($bg_time && $end_time){
            $where['add_time'] = ['between', [$bg_time, $end_time]];
        }
        $articleModel = Db::name('article');
        $list	= $articleModel->where($where)->order('id desc')->paginate(10);
        $this->assign('article_list', $list);
        $this->assign('num', count($list));
        $this->assign('page', $list->render());
        $this->assign('keywords', $keywords);
        $this->assign('bg_date', $bg_date);
        $this->assign('end_date', $end_date);
        return $this->fetch();
    }
    //美食添加
    public function article_add(){
        if(request()->isPost()){
            $title    = input('title');
            $click    = input('click');
            $duration = input('duration');
            //获取美食描述，并去除html标签
            $content  = strip_tags(htmlspecialchars_decode(input('content')));
            if(!$title){
                $this->error('美食标题不能为空');
            }
            if(!preg_match("/^[0-9]*[1-9][0-9]*$/",$click)){
                $this->error('播放量必须为正整数');
            }

            if(!$content){
                $this->error('美食内容不能为空');
            }
            $data['title'] = $title;
            $data['click'] = $click;
            $data['duration'] = $duration;
            $data['pic'] = $this->upload_pic('pic');
            $data['video'] = $this->upload_video('video');
            $data['content'] = $content;
            $data['add_time'] = time();
            if(Db::name('article')->insert($data)){
                $this->success('添加成功', url('Article/article_list'), 1);
            }else{
                $this->error('添加失败', url('Article/article_add'), 1);
            }
            return ;
        }
        return $this->fetch();
    }
    //美食编辑
    public function article_edit(){
        if(request()->isPost()){
            $id = (int)input('id');
            if(!$id){
                $this->error('参数不正确');
            }
            $title   = input('title');
            $click   = input('click');
            $duration = input('duration');
            //获取美食描述，并去除html标签
            $content  = strip_tags(htmlspecialchars_decode(input('content')));
            if(!$title){
                $this->error('美食标题不能为空');
            }
            if(!preg_match("/^[0-9]*[1-9][0-9]*$/",$click)){
                $this->error('点击量必须为正整数');
            }
            if(!$content){
                $this->error('美食内容不能为空');
            }
            $data['title'] = $title;
            $data['click'] = $click;
            $data['duration'] = $duration;
            $data['content'] = $content;
            $data['up_time'] = time();
            $arr = Db::name('article')->where(['id'=>$id])->find();
            //判断是否有文件上传
            if($_FILES){
                //判断是否上传了图片
                if(isset($_FILES['pic'])){
                    $data['pic'] = $this->upload_pic('pic');
                    $url_pic = $arr['pic'];
                    @unlink('.'.$url_pic);//每次都会更新图片，取自预览图的图片
                }
                //判断是否上传了视频
                if(isset($_FILES['vieo'])){
                    $data['video'] = $this->upload_video('video');
                    $url_video = $arr['video'];
                    @unlink('.'.$url_video);//每次都会更新视频
                }
            }
            if(Db::name('article')->where(['id'=>$id])->update($data)){
                $this->success('修改成功', url('Article/article_list'), 1);
            }else{
                $this->error('修改失败');
            }
            return ;
        }
        $id = (int)input('id');
        $info = Db::name('article')->where(['id'=>$id])->find();
        $this->assign('info', $info);
        return $this->fetch();
    }
    //美食删除
    public function article_del() {
        $id = (int)input('id');
        if(!$id) {
            $this->error('参数不正确');
        }
        $url = Db::name('article')->where(['id'=>$id])->value('pic');
        if(Db::name('article')->where(['id'=>$id])->delete()){
            @unlink('.'.$url);
            $this->success('删除成功',url('Article/article_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //美食批量删除
    public function article_delall(){
        $ids = input('ids');
        $id_arr = explode(',', $ids);
        $where['id'] = ['in', $id_arr];
        $urls = Db::name('article')->field('pic')->where($where)->select();
        if(Db::name('article')->where($where)->delete()){
            foreach($urls as $key=>$value) {
                @unlink('.'.$value['pic']);
            }
            $this->success('删除成功', url('Article/article_list'), 1);
        }else{
            $this->error('删除失败');
        }
    }
    //美食停用
    public function article_stop() {
        $id = (int)input('id');
        if(!$id){
            $this->error('参数不正确');
        }
        $where['id'] = $id;
        $save['status'] = 2; //停用
        if(Db::name('article')->where($where)->update($save)){
            $this->success('停用成功', url('Article/article_list'), 1);
        }else{
            $this->error('停用失败');
        }
    }
    //美食启用
    public function article_start() {
        $id = (int)input('id');
        if(!$id){
            $this->error('参数不正确');
        }
        $where['id'] = $id;
        $save['status'] = 1; //启用
        if(Db::name('article')->where($where)->update($save)){
            $this->success('启用成功', url('Article/article_list'), 1);
        }else{
            $this->error('启用失败');
        }
    }


    //图片上传方法
    private function upload_pic($pic) {
        //获取表单上传文件
        $file = $this->request->file($pic);
        //上传文件验证
        $result = $this->validate(['file'=>$file], ['file'=>'require|image'], ['file.require'=>'请选择上传图片文件', 'file.image'=>'非法图像文件']);
        if(true !== $result) {
            $this->error($result);
        }
        //移动到框架应用根目录 /public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS .'uploads');
        $info_path = '/uploads/' . str_replace('\\', '/',  $info->getSaveName());
        if($info) {
            return $info_path;
        }else{
            return false;
        }
    }
	//视频上传方法
	 private function upload_video($video) {
        //获取表单上传文件
        $file = $this->request->file($video);
        //移动到框架应用根目录 /public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS .'uploads');
        $info_path = '/uploads/' . str_replace('\\', '/',  $info->getSaveName());
        if($info) {
            return $info_path;
        }else{
            return false;
        }
    }
}