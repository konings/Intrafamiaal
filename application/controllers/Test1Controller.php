<?php

class Test1Controller extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$layout=$this->_helper->layout();
    	$layout->setLayout('html5boilerplate');
    }

    public function indexAction()
    {
        // action body
        
    }


}

