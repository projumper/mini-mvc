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
