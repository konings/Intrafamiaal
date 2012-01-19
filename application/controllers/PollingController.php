<?php

class PollingController extends Zend_Controller_Action
{

    public function init()
    {
    	//$this->em = $this->_helper->EntityManager();
    	$this->_helper->layout()->disableLayout();
    	Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);	    
    }

    public function indexAction()
    {
        // action body
    }

    public function pollAction()
    {
        // action body

   
    }

    private function Testok()
    {
    	$contents=json_decode(file_get_contents("test.php"));
    
    	if($contents->push=="false")
    		return false;
    	else if($contents->push=="true")
    		return $contents;
    }

    public function poll1Action()
    {
    	$params = array('host'      =>'localhost',
    	
    			'username'  =>'root',
    	
    			'password'  =>'',
    	
    			'dbname'    =>'polling'
    	
    	);
    	
    	
    	$db= new Zend_Db_Adapter_Pdo_Mysql($params);
    	
    	$db->setFetchMode(Zend_Db::FETCH_OBJ);   

    	$data = array(
    		'name'      => $_GET["name"],
    			'ok' => false
    	);
    	
    	
    	$db->insert('polling', $data);
    	
        while(true)
        {
        	usleep(50000);
        	$testok=$this->Testok();
        	if($testok!=false)
        	{
        		echo json_encode($testok);
        		break;
        	}
        		
        }
    }


}





