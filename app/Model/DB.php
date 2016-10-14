<?php
class DB{
    static public function __callstatic($name,$arguments){
        $pdo = PdoMysql::getInstance();
        return call_user_func_array([$pdo, $name], $arguments);
    }

    /**
     * 重写select,DB::select();
     */
    static public function select($sqlStatement){
        $pdoStatment = self::query($sqlStatement);
        header("Content-type: text/html; charset=utf-8");
        $row = $pdoStatment -> fetchAll(PDO::FETCH_OBJ);
        return $row;
    }
}