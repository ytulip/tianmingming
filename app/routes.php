<?php
Route::get('/work/more',function(){

});
Route::get('/previewimg/',function(){
    \MM\PreviewImage::getImage();
});
Route::controller('/index','IndexController');

