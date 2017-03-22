<?php
class IndexController{

    public function addwork(){
        return View::show('add_work.html',array());
    }

    public function editorwork(){
        $object = new WorkModel(IndexController::input('id'));
        return View::show('editor_work.html',[
            'id'=>$object->id,
            'type'=>$object->type,
            'title'=>$object->title,
            'describe'=>$object->describe,
            'face_img'=>$object->face_img,
            'imgs'=>json_decode($object->imgs,true),
            'abstract'=>$object->abstract
        ]);
    }

    public function deletework(){
        $object = new WorkModel(IndexController::input('id'));
        $object->delete();
        echo json_encode(['status'=>true]);
        exit;
    }

    public function home(){
        return View::show('index/home_new.html',array());
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


    public function editworks(){
        return View::show('editworks.html',array(
            'type'=>IndexController::input('type',1)
        ));
    }

    /**
     * 重新排列works
     */
    public function reorderworks(){
        /**
         *
         */
        $arr = [];
        $sql = 'update work set power = case ';
        foreach(explode(',',IndexController::input('ids')) as $key=>$val){
            $sql .= " when id = $val then $key";
        }
        $sql .= ' end';
        DB::delete($sql);
        echo json_encode(['status'=>true]);
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
        return View::show('new_admin.html',array());
    }

    public function savework(){
        $filename = \MM\Kits::getMillisecond() . '.jpg';
        PostImage::save(index_path . '/images/work/' . $filename);
        echo json_encode(array('status'=>true,'path'=>'/images/work/' . $filename,'type'=>IndexController::input('type',1)));
        exit;
    }


    public function modifywork(){
        $object = new WorkModel(IndexController::input('id'));
        $object->update(\MM\MArray::arrayOnly($_REQUEST,['title','abstract','describe','face_img','type','imgs']));
        echo json_encode(['status'=>true,'data'=>$object->id]);
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
            $list = DB::select('select * from work where type = ' . intval($type) . ' order by power asc,id desc');
        }else{
            $list = DB::select('select * from work order by power asc,id desc');
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

    /**
     * 关于我恩
     */
    public function about(){
        return View::show('index/about.html',array());
    }

    public function contact(){
        return View::show('index/contact.html',array());
    }


    public function sendmail(){
//        $to      = "35715872@qq.com";
//        $from    = "35715872@qq.com";
//        $subject = "来自tianmingming.com的留言";
//        $body    = "这是测试邮件";
        $content = sprintf("<p>称呼:%s</p><p>邮箱:%s</p><p>留言:%s</p>",IndexController::input('name'),IndexController::input('email'),IndexController::input('content'));

        $mail    = new \MM\Mail();
        $mail->send($content);
        echo json_encode(['status'=>true,'data'=>'您的留言已送达，明明会及时给你回复！']);
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