<?php
class IndexController{

    private $_view;
    private function __construct(){
        $this->_view = ViewServer::singleton();
    }


    public function index(){
        $view = ViewServer::singleton();
        return $view->show('index.html',array());
    }

    public function admin(){
        $view = ViewServer::singleton();
        return $view->show('admin.html',array());
    }

    public function savework(){
        $filename = time() . '.jpg';
        PostImage::save(index_path . '/images/work/' . $filename);
        $workModel = new WorkModel();
        $workModel->add(array(array('name'=>$filename,'type'=>IndexController::input('type',1))));
        $workModel->save();
        echo json_encode(array('status'=>true,'path'=>'/images/work/' . $filename));
        exit;
    }

    public function saveworkdetailimg(){
        $filename = time() . '.jpg';
        PostImage::save(index_path . '/images/work/' . $filename);
        echo json_encode(array('status'=>true,'path'=>'/images/work/' . $filename));
        exit;
    }

    /**
     * 工作分类列表
     */
    public function worklist(){
        $type = IndexController::input('type');
        $workModel = new WorkModel();
        if($type){
            $workModel->where(array('type'=>$type));
        }
        $workModel->orderDesc();
        $res = $workModel->get();
        echo json_encode(array('status'=>true,'data'=>$res));
        exit;
    }

    public function workdetail(){
        $view = ViewServer::singleton();
        $workModel = new WorkModel();
        $workModel->where(array('id'=>IndexController::input('id')));
        $info = $workModel->get();
        $describe = htmlspecialchars_decode(urldecode($info[0]['describe']));
//        var_dump($describe);
//        exit;
        return $view->show('workdetail.html',array('id'=>IndexController::input('id'),'title'=>$info[0]['title'],'imgs'=>explode(',',$info[0]['imgs']),'describe'=>$describe));
    }

    /**
     * 保存工作详情
     */
    public function saveworkdetail(){
        if(!IndexController::input('id')){
            echo json_encode(array('status'=>false));
            exit;
        }
        $workModel = new WorkModel();
        $workModel->where(array('id'=>IndexController::input('id')));          $workModel->update(array('title'=>IndexController::input('title'),'imgs'=>trim(IndexController::input('imgs'),','),'describe'=>IndexController::input('describe')));
        echo json_encode(array('status'=>true));
        exit;
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

    /**
     * 工作详情
     */
    public function workdetailinfo(){
        if(!IndexController::input('id')){
            echo json_encode(array('status'=>false));
            exit;
        }

        $workModel = new WorkModel();
        $workModel->where(array('id'=>IndexController::input('id')));
        $info = $workModel->get();

        if(isset($info[0])){
            echo json_encode(array('status'=>true,'data'=>$info[0]));
            exit;
        }else{
            echo json_encode(array('status'=>false));
            exit;
        }
    }


    static public function input($index,$default=''){
        if(isset($_REQUEST[$index]) && ($_REQUEST[$index] !== '')){
            return htmlspecialchars($_REQUEST[$index]);
        }else{
            return $default;
        }
    }

}