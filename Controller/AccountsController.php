<?php


namespace MyApp\Controller;

use MyApp\Model\Accounts;

use MyApp\Model\Girokonten;

use MyApp\Library\View;

class AccountsController 
{

    protected $view;
    
    public function setView(View $view)
    {   
        $this->view = $view;
        
    }
    public function indexAction()
    {
        $accounts = new Accounts();
        $collection = $accounts->find();
        //var_dump($collection);
        $this->view->setDataCollection($collection);

    }

    //insert
    public function createAction()
    {
        if($_POST["submit"]){

            $data = $_POST;

            $account = new Accounts();
            $account->setId(22);
            $account->setFirstname("Günbay");
            //$account->setEmail("");
            $account->save();

            $giro = new Girokonten();
            $giro->balance=1000;
            $giro->account_nr=2;
           // $giro->save();

        }
    }

    public function updateAction()
    {
        $account = new Accounts();

        if(isset($_GET['id'])){
            
            $id = $_GET['id'];

            $obj = $account->find(array("id"=>$id));

            $this->view->setDataCollection($obj);

        }

        if (isset($_POST["submit"])){
            
            $data = $_POST;

            $account->setId($data["id"]);
            $account->setEmail($data["email"]);
            $account->setFirstname($data["name"]);
            $account->save();

            header("Location: index.php?controller=accounts&action=index");

        }
    }
}