<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
class Index extends Controller {
    //获取首页列表，上拉加载方式
    /**public function getList() {
        //获取每次显示条数
        $limit = input('limit',3,'intval');
        //获取最后一条id
        $lastid = input('lastid',1,'intval');
        //获取id大于$lastid的数据
        if($lastid > 0) {
            $where['id'] =  array('gt', $lastid);
        }
        $arr = Db::name('article')->where($where)->order('id asc')->field('id,title,pic')->limit($limit)->select();
        //拼接图片地址的绝对路径
        foreach ($arr as $key => $v) {
            $pic = 'http://demo9.jiudianlianxian.com'.$v['pic'];
            $arr[$key]['pic'] = $pic;
        }
        $list = [
                'code' => 1,
                'msg'  => 'succ',
                'arr'  => $arr
        ];
        echo json_encode($list);
    }**/
	//获取首页列表，分页方式
	public function getList() {
		//获取没戏显示条数，默认为3
		$limit = input('limit',3,'intval');
        //获取当前页数，默认为1
        $pageNumber = input('pageNumber',1,'intval');
        //获取总记录数
        $article = Db::name('article');
        $count = count($article->select());
        $totalPage = ceil($count/$limit);
        //起始id值
        $startId = $limit*($pageNumber-1);

		$list = $article->where('status',1)->order('id asc')->field('id,title,pic')->limit($startId,$limit)->select();
        //拼接图片地址的绝对路径
        foreach ($list as $key => $v) {
            $pic = 'http://demo9.jiudianlianxian.com'.$v['pic'];
            $list[$key]['pic'] = $pic;
        }
        $arr['list'] = $list;
        $arr['totalPage'] = $totalPage;
        $list = [
            'code' => 1,
            'msg'  => 'succ',
            'arr'  => $arr
        ];
        echo json_encode($list);
	}
    //获取美食详情
    function getDetail() {
        //获取美食id，没有默认id=2
        $id = input('id',2,'intval');
        //获取美食信息
        $article = Db::name('article');
        $food = $article->where('id',$id)->field('id,title,click,duration,video,content')->find();
        //每次进入，click自增1
        $food['click']++;
        $article->where(['id'=>$id])->update($food);
        //拼接视频url
        $food['video'] = 'http://demo9.jiudianlianxian.com'.$food['video'];
        //链接用户表
        $join = [
            ['__USER__ u', 'u.id = c.user_id', 'LEFT' ]
        ];
        $field = 'c.user_id,c.add_time as c_time,c.content,u.avatarUrl,u.nickName';
        $order = ' c.id desc';
        //获取评论信息,倒序排列
        $comment = Db::name('comment')->alias('c')->where('art_id',$id)->field($field)->join($join)->order($order)->select();
		//将时间戳转换为多久前格式，调用封装的函数mdate
        foreach ($comment as $k => $v) {
            $time = $this->mdate($v['c_time']);
            $comment[$k]['c_time'] = $time;
        }
        $arr = $food;
        $arr['comment'] = $comment;
        //返回数据
        $list = [
            'code' => 1,
            'msg'  => 'succ',
            'arr'  => $arr
        ];
        echo json_encode($list);
    }
    //插入评论
    function saveComment() {
        //获取微信传递的code
        $code = input('code');
        $nickName  = input('nickName');
        $avatarUrl = input('avatarUrl');
        //微信端接口，通过code值取到用户的openid等信息
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=".APPID."&secret=".SECRET."&js_code=".$code."&grant_type=authorization_code";
        //通过file_get_contents方法根据code获取openid等信息
        $weixin = file_get_contents($url);
        //对JSON格式的字符串进行编码
        $jsondecode = json_decode($weixin);
        //转换成数组
        $array = get_object_vars($jsondecode);
        //获取openid
        $openid            = $array['openid'];
        $ob                = Db::name('user');
        $userInfo          = $ob->where('openid',$openid)->find();
        $data['openid']    = $openid;
        $data['nickName']  = $nickName;
        $data['avatarUrl'] = $avatarUrl;
        //保存或者更新用户信息
        if ($userInfo) {
            //说明用户表中已有数据，更新用户的信息
            $data['up_time'] = time();
            $user_id = $userInfo['id'];
            $ob->where('id',$user_id)->update($data);
        } else {
            //说明用户表中没有数据，插入新的数据
            $data['add_time'] =time();
            $user_id = $ob->insertGetId($data);
        }
        //保存评论
        $comment['art_id']   = input('art_id');
        $comment['user_id']  = $user_id;
        $comment['add_time'] = time();
        $comment['content']  = input('content');
        $lastid = Db::name('comment')->insertGetId($comment);
        if ($lastid) {
            //评论成功
            $result = [
                'code' => 1,
                'msg'  => 'succ',
                'id'   => $lastid
            ];
        } else {
            //评论失败
            $result = [
                'code' => 0,
                'msg'  => 'error'
            ];
        }
        echo json_encode($result);
    }
	//将时间戳转换为多久前
    private function mdate($time = NULL) {
	    $text = '';
	    $time = $time === NULL || $time > time() ? time() : intval($time);
	    $t = time() - $time; //时间差 （秒）
	    $y = date('Y', $time)-date('Y', time());//是否跨年
	    switch($t){
	     case $t <=30:
	       $text = '刚刚';//30秒内
	       break;
	     case $t < 60:
	      $text = $t . '秒前'; // 一分钟内
	      break;
	     case $t < 60 * 60:
	      $text = floor($t / 60) . '分钟前'; //一小时内
	      break;
	     case $t < 60 * 60 * 24:
	      $text = floor($t / (60 * 60)) . '小时前'; // 一天内
	      break;
	     case $t < 60 * 60 * 24 * 3:
	      $text = floor($time/(60*60*24)) ==1 ?'昨天 '  : '前天 ' ; //昨天和前天
	      break;
	     case $t < 60 * 60 * 24 * 30:
	      $text = floor($t/(60 * 60 * 24)).'天前'; //一个月内
	      break;
	     case $t < 60 * 60 * 24 * 365&&$y==0:
	      $text = floor($t/(60 * 60 * 24 * 30)).'个月前'; //一年内
	      break;
	     default:
	      $text = floor($t/(60 * 60 * 24 * 30 * 12)).'年前'; //一年以前
	      break;
	    }
	    return $text;
	}
}
