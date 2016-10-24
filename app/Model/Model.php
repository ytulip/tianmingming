<?php
/**
 * Model类
 * Class Model
 */
class Model{
    protected $_table;
    protected $_primary_key = 'id';
    protected $_model_object;

    public $_test = 123;


    public function __construct($id = null){
        if($id === null){
            return;
        }
        $res = DB::select(sprintf("select * from %s where %s = %s",$this->_table,$this->_primary_key,$id));
        $this->_model_object = $res[0];
        return $this;
    }

    public function __get($property_name){
        if(isset($this->_model_object->$property_name)){
            return $this->_model_object->$property_name;
        }else{
            return null;
        }
    }

    /**
     * @param array $data
     */
    public function insert($data){
        return DB::insert($this->_table,$data);
    }


    public function delete(){
        return DB::delete(sprintf('delete from `%s` where %s = %s',$this->_table,$this->_primary_key,$this->id));
    }
}