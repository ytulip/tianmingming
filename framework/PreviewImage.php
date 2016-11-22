<?php
namespace MM;
use Intervention\Image\ImageManager;

/**
 * 这个输出预览图片
 * Class PreviewIamge
 * @package MM
 */
class PreviewImage{

    /**
     * 生成预览图片
     */
    static public function makeImage(){

    }

    /**
     * 返回图片
     */
    static public function getImage(){
        $realPath = str_replace('/previewimg','',$_SERVER['REQUEST_URI']);
        $previewPath = preview_path . $realPath;
        $realPath = index_path . $realPath;
        //如果已经存在了缓存
        if(file_exists($previewPath)){
            //输出图片
            header('Content-type: image/jpg');
            echo file_get_contents($previewPath);
            exit;
        }
        //查看原文件是否存在
        if(file_exists($realPath)){
            //生成缩略图
            $mamager = new ImageManager();
            self::create_dir(pathinfo($previewPath,PATHINFO_DIRNAME));
            $mamager->make($realPath)->widen(50)->save($previewPath);
            header('Content-type: image/jpg');
            echo file_get_contents($previewPath);
            exit;
        }else{
            //报404错误
            header("HTTP/1.1 404 Not Found");
            header("Status: 404 Not Found");
            exit;
        }
    }

    /**
     * 创建目录
     * @param $path
     * @return bool
     */
    static public function create_dir($path){
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
}