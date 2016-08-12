<?php
class IndexController{
    public function index(){
        return View::show('index.html',array());
    }
}