<?php


namespace MyApp\Controller;

use MyApp\Model\Accounts;

use MyApp\Model\Girokonten;

use MyApp\Library\View;

class IndexController
{
    protected $view;
    
    public function setView(View $view)
    {   
        $this->view = $view; 
    }

    public function editAction()
    {
        if (isset($_POST)) {
            var_dump($_POST) ;
        }
        
        //1 Möglichkeit
        $this->view->setData(array("name"=>$_POST['text1']));
        
        $_POST; //Gartsev
        $_POST["name"] = ";Update users where id= 1; set password = 1234"; //Gartsev

        //$this->view->render();

        $accountsModel = new Accounts();
        $account = $accountsModel->findFirst("1");
        $account->setFirstname($_POST["text1"]);
        $account->save();
    }


    public function indexAction()
    {
        $accountsModel = new Accounts();
        $collection = $accountsModel->find();
        $this->view->setData($collection);

        $girokontenModel = new Girokonten();
        //var_dump($girokontenModel->find());

        $options = array("id"=>1); 

        $collection = $girokontenModel->findFirst($options);
        
        $this->view->setData($options);
        
    }
    public function createAction()
    {
        
    }

    public function personenAction()
    {
        $personenModel = new Accounts() ;	

        $collection = $personenModel->find();

        foreach ($collection as $key => $value) {
            $this->personAction($value);
        }

    }

    public function personAction($value)
    {
        //var_dump($value);
        $this->view->setData($value);
    }
}