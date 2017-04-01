<?php
namespace MM;
class Kits{
    /**
     * 获取毫秒级别的时间戳
     */
    public static function getMillisecond()
    {
//获取毫秒的时间戳
        $time = explode ( " ", microtime () );
        $time = $time[1] . ($time[0] * 1000);
        $time2 = explode( ".", $time );
        $time = $time2[0];
        return $time;
    }


    static public function secondaryKeyIndex(&$hack,$key,$value){
            foreach($hack as $k=>$item){
                if($item->$key == $value){
                    return $k;
                }
            }
            return -1;
    }


    /**
     * @param $datetime
     */
    static public function timeDescribe($datetime){
        $nowtimestampe = time();
        $comparetimestampe = strtotime($datetime);
        $differ = $nowtimestampe - $comparetimestampe;
        if($differ < 60){
            return "$differ" . "秒前";
        }
        if($differ < 3600){
            return intval($differ/60) . "分钟前";
        }

        if($differ < 86400){
            return intval($differ / 3600) . "小时前";
        }

        if($differ < (86400 * 3)){
            return intval($differ / 86400) . '天前';
        }

        return date('Y月m日',$comparetimestampe);
    }


    static public function getAvatar($email){
        if(strpos($email,'qq.com') !== false){
            //q1.qlogo.cn/g?b=qq&amp;nk=35715872&amp;s=100
            $qq = str_replace('@qq.com','',$email);
            return '//q1.qlogo.cn/g?b=qq&nk='.$qq.'&s=100';
        }
        return '/public/images/avatar.png';
    }
}