<?php
class IndexController{
    public function index(){
        return View::show('index.html',array());
    }

    public function admin(){
        return View::show('admin.html',array());
    }
}