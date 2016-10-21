<?php
class IndexController{

    public function addwork(){
        return View::show('add_work.html',array());
    }

    public function home(){
        return View::show('index/home.html',array());
    }

    public function work(){
        $object = new WorkModel(IndexController::input('id'));
        return View::show('index/work.html',array(
            'type'=>$object->type,
            'title'=>$object->title,
            'describe'=>$object->describe,
            'imgs'=>json_decode($object->imgs,true)
        ));
    }

    /**
     * 公众号
     */
    public function works(){
        return View::show('index/works.html',array(
            'type'=>IndexController::input('type',1)
        ));
    }

    public function index(){
        return View::show('index.html',array());
    }

    public function admin(){
        return View::show('admin.html',array());
    }

    public function savework(){
        $filename = \MM\Kits::getMillisecond() . '.jpg';
        PostImage::save(index_path . '/images/work/' . $filename);
        echo json_encode(array('status'=>true,'path'=>'/images/work/' . $filename,'type'=>IndexController::input('type',1)));
        exit;
    }

    /**
     * 将一个work存储起来
     */
    public function storagework(){
        $object = new WorkModel();
        $insertId = $object->insert(\MM\MArray::arrayOnly($_REQUEST,['title','abstract','describe','face_img','type','imgs']));
        echo json_encode(['status'=>true,'data'=>$insertId]);
        exit;
    }

    /**
     * 工作分类列表
     */
    public function worklist(){
        $type = IndexController::input('type');
        if($type){
            $list = DB::select('select * from work where type = ' . intval($type) . ' order by id desc');
        }else{
            $list = DB::select('select * from work order by id desc');
        }
        echo json_encode(array('status'=>true,'data'=>$list));
        exit;
//        $type = IndexController::input('type');
//        $workModel = new WorkModel();
//        if($type){
//            $workModel->where(array('type'=>$type));
//        }
//        $res = $workModel->get();
//        echo json_encode(array('status'=>true,'data'=>$res));
//        exit;
    }



    public function workdelete(){
        $id = IndexController::input('id');
        $workModel = new WorkModel();
        $workModel->where(array('id'=>$id));
        $workModel->delete();
        $workModel->save();
        echo json_encode(array('status'=>true));
        exit;
    }


    static public function input($index,$default=''){
        if(isset($_REQUEST[$index]) && ($_REQUEST[$index] !== '')){
            return $_REQUEST[$index];
        }else{
            return $default;
        }
    }

}