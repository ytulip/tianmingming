<?php
namespace MM;
class MArray{
    /**
     * 过滤掉不用的键值
     * @param array $data
     * @param array $filter
     * @return array
     */
    static public function arrayOnly(Array $data,Array $filter){
        return array_filter($data,function($v,$k) use ($filter){
            return in_array($k,$filter)?true:false;
        },ARRAY_FILTER_USE_BOTH);
    }
}