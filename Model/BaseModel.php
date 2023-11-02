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

        //echo "SELECT * FROM ". $table." where ". $ops;

        $result = $conn->query("SELECT * FROM ". $table." where ". $ops);

        while ($row = $result->fetch_object())
        {
            $collection = $row;
        }
        return $collection;
        
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

    /**
     *
     * save all data 
     * 
     */
    public function save()
    {
        $conn = $this->getConnection();
        
        $table = $this->getSource();

        $thisData = array();

        //kopieren wir die Daten aus $this -> $thisData
        foreach ($this as $key => $value) {
            $thisData[$key]=$value;
        }
        
        if(isset($thisData["id"])){
            //Update
            //$values = firstname='$firstname', surename='$surename', email='$email'
            $values = "";

            foreach ($thisData as $key => $value) {
                
                if(($key != "id") && ($key != "conn")){
                   
                    $values .= $key."='". $value. "', ";
             
                }
            }

            $values = substr($values,0,-2);

            $conn->query("UPDATE ". $table ." SET ".$values." WHERE id=".$thisData['id']);

        }else{
            //insert
            //$columns = "firstname, surename, email, girokonto_id, sparbuch_id";
            $columns = "";
            //$values = '".$_POST['firstname']."', '".$_POST['surename']."', '".$_POST['email']."', NULL, NULL
            $values = "";

            foreach ($thisData as $key => $value) {
                
                if(($key != "id") && ($key != "conn")){
                   
                    $columns .= $key." , ";

                    $values .= "'".$value."', ";
                }
            }
           
            $columns = substr($columns,0,-2);
            
            $values = substr($values,0,-2);
            
            $conn->query("INSERT INTO ".$table." (".$columns.") VALUES (". $values .")");
        }
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