<?php
namespace app\admin\controller;
use Think\Db;
class Setting extends Base {
    //基本设置
    public function index() {
    	//获取设置的信息
    	$set = Db::name('setting')->order('id desc')->limit(1)->find();
        if(request()->isPost()){
        	//原本有信息
            $id = (int)input('id');
            if($id){
                $site_name = input('site_name');
                $description = input('description');
                $category = input('category');
                $copyright = input('copyright');
                if(!$site_name){
                    $this->error('网站名称不能为空');
                }
                if(!$description){
                    $this->error('网站描述不能为空');
                }
                if(!$category){
                    $this->error('服务类目不能为空');
                }
                if(!$copyright){
                    $this->error('主体信息不能为空');
                }
                $data['site_name'] = $site_name;
                $data['description'] = $description;
                $data['category'] = $category;
                $data['copyright'] = $copyright;
                $data['up_time'] = time();
                if(isset($_FILES['logo']) && !empty($_FILES['logo'])){
                    $data['logo'] = $this->upload_pic('logo');
					//删除原有logo
					@unlink('.'.$set['logo']);
                }
                $where['id'] = $id;
                if(Db::name('setting')->where($where)->update($data)){
                    $this->success('修改成功', url('index'), 1);
                }else{
                    $this->error('修改失败');
                }
                return ;
            }else{
            	//没有信息，需新增信息
                $site_name = input('site_name');
                $description = input('description');
                $category = input('category');
                $copyright = input('copyright');
                if(!$site_name){
                    $this->error('网站名称不能为空');
                }
                if(!$description){
                    $this->error('网站描述不能为空');
                }
                if(!$category){
                    $this->error('服务类目不能为空');
                }
                if(!$copyright){
                    $this->error('主体信息不能为空');
                }
                $data['site_name'] = $site_name;
                $data['description'] = $description;
                $data['category'] = $category;
                $data['copyright'] = $copyright;
				$data['logo'] = $this->upload_pic('logo');
                if(Db::name('setting')->insert($data)){
                    $this->success('添加成功', url('index'), 1);
                }else{
                    $this->error('添加失败');
                }
            }
            return ;
        }
      
//      $this->assign('set', $set);
        return $this->fetch();
    }
    
    //文件上传方法
    private function upload_pic($pic) {
        //获取表单上传文件
        $file = $this->request->file($pic);
        //上传文件验证
        $result = $this->validate(['file'=>$file], ['file'=>'require|image'], ['file.require'=>'请选择上传文件', 'file.image'=>'非法图像文件']);
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
}