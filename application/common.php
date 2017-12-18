<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE DO IT NOT ONLY THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 周琪 <zhouqi001@126.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * @Title: csubstr
 * @Description: todo(中文字符串截取长度)
 * @param string $str
 * @param int $length
 * @param string $charset
 * @param int $start
 * @param boolean $suffix
 * @return string
 * @author duqiu
 * @date 2016-8-21
 */
function csubstr($str, $length, $charset="", $start=0, $suffix=true) {
    if (empty($charset))
        $charset = "utf-8";

    if (function_exists("mb_substr")) {
        if (mb_strlen($str, $charset) <= $length)
            return $str;
        $slice = mb_substr($str, $start, $length, $charset);
    }else {
        $re['utf-8'] = "/[\x01-\x7f]¦[\xc2-\xdf][\x80-\xbf]¦[\xe0-\xef][\x80-\xbf]{2}¦[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]¦[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]¦[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]¦[\x81-\xfe]([\x40-\x7e]¦\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        if (count($match[0]) <= $length)
            return $str;
        $slice = join("", array_slice($match[0], $start, $length));
    }
    if ($suffix)
        return $slice . "...";
    return $slice;
}

/*
 * 测试工具
 */
function p($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}