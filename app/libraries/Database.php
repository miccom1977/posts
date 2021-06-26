<?php

class Database{
    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;

    private $statement;
    private $dbHandler;
    private $error;


    public function __construct(){
        $conn = 'mysql:host='.$this->dbHost.';dbname='.$this->dbName;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        try{
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        }
        catch(PDOExeption $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    public function query( $sql ){
        $this->statement  = $this->dbHandler->prepare($sql);
    }

    public function bind( $parameter, $value, $type = null ){
        switch(is_null($type)){
            case is_int($value):
                $type = PDO::PARAM_INT;
            break;
            case is_bool($value):
                $type = PDO::PARAM_BOLL;
            break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
            break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    public function execute(){
        return $this->statement->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
}