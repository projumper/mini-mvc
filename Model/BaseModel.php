<?php

namespace MyApp\Model;

use mysqli;
use MyApp\Controller;

abstract class BaseModel
{
    private $conn; //$pdo

    public function getConnection()
    {
        $this->conn = new mysqli("localhost", "root", "", "");
        $this->conn->select_db("bankomat");
        return $this->conn;
    }

    //Select * from tabelle where id=1
    public function findFirst($options)
    {
        $model = new static();

        $table = $model->getSource();

        $conn = $this->getConnection();

        //name=>ivan, email=>ivan@garstev.de  ---> name = 'ivan' AND email = 'ivan@garstev.de'

        $ops= '';

        foreach ($options as $key => $value) {
            $ops .= $key. '='. $value. ' AND ';
        }
        $ops = substr($ops,0,-4);

        $result = $conn->query("SELECT * FROM ". $table." where ". $ops);

        return $result->fetch_object();
        
    }
    
    //select * from tabelle
    public function find($options = "")
    {

        $collection = array();

        $model = new static();
        
        $table = $model->getSource();

        $conn = $this->getConnection();

        $ops= '';
        
        if(is_array($options))
        {
            foreach ($options as $key => $value) 
            {
                $ops .= $key. '='. $value. ' AND ';
            }
            $ops = substr($ops,0,-4);

            $ops = 'where '.$ops;
        }

        $result = $conn->query("SELECT * FROM ". $table ." ". $ops);

        while ($row = $result->fetch_object())
        {
            $collection[] = $row;
        }
        return $collection;
    }

    abstract public function getSource();

}


//Abstractes Beispiel 
/*
class test extends BaseModel
{
    public function getSource()
    {
        echo "hallo";
    }
}

class test2 extends BaseModel
{
    public function getSource()
    {
        echo "hi";
    }
}
*/