<?php
//商品分类模型
namespace app\admin\Model;
use think\Model;
class Category extends Model{
    //自动验证
//    protected $_validate = array(
//        array('name','require','商品分类名称不能为空'),
//    );

    //定义一个方法，获取树状的分类信息,为方便连表，本方法已在控制层重写
    public function catTree(){
        $cats = $this->order('sort desc')->select();
        return $this->tree($cats);
    }

    //定义一个方法，对给定的数组，递归形成树
    public function tree($arr,$pid = 0,$level = 0) {
        static $tree = array();
        foreach ($arr as $v) {
            if ($v['parent_id'] == $pid) {
                //说明找到，保存
                $v['level'] = $level; //保存当前分类的所在层级
                $tree[] = $v;
                //继续找
                $this->tree($arr,$v['cid'],$level + 1);
            }
        }
        return $tree;
    }

    //给定一个分类，找其后代分类的cid，包括它自己
    public function getSubIds($cid){
        $cats = $this->select();
        $list = $this->tree($cats,$cid);
        $res = array();
        foreach ($list as $v) {
            $res[] = $v['cid'];
        }
        //把cat_id追加到数组
        $res[] = $cid;
        return $res;
    }
}