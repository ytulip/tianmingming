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
//        var_dump($sqlStatement);
//        exit;
        $pdoStatment = self::query($sqlStatement);
        if(!$pdoStatment)
        {
            return null;
        }
        $row = $pdoStatment -> fetchAll(PDO::FETCH_OBJ);
        return $row;
    }

    static public function delete($sqlStatement){
        self::exec($sqlStatement);
        return true;
    }


    static public function update($query,$data){
        self::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = self::prepare($query);
        $stmt->execute($data);
        return true;
    }

    /**
     * 插入一条数据
     */
    static public function insert($tableName,$data){
        //用value方法
        self::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $attrs = '';
        $values = '';
        $valuesArray = [];
        foreach($data as $key=>$val){
            $attrs .= "`$key`,";
            $values .= "?,";
            $valuesArray[] = $val;
        }
        $query = sprintf("insert into %s(%s) VALUES(%s)",$tableName,trim($attrs,','),trim($values,','));
        $stmt = self::prepare($query);
        foreach($valuesArray as $key=>$val){
            $stmt->bindValue($key + 1, $val);
        }
        $stmt->execute();
        return self::lastInsertId();
//        $stmt->bindValue(1, '4');
//        $stmt->execute();



//        self::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $valArray = [];
//        $attrs = '';
//        foreach($data as $key=>$val){
//            $valArray[":`$key`"] = $val;
//            $attrs .= "`$key`= :`$key`,";
//        }
//        $query = sprintf("INSERT INTO %s SET %s",$tableName,trim($attrs,','));
//        $result = self::prepare($query);
//        $result->bindValue(':`describe`', '1');
//        var_dump($result->queryString);
//        exit;

        //var_dump($valArray);
//        $valArray = array(
//            ":title"=>"1",
//            ":abstract"=>"1",
//            ":describe"=>"1"
//        );

//        $result->execute();
//        return self::lastInsertId();
    }
}