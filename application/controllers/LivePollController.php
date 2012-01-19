<?php

class LivePollController extends Zend_Controller_Action
{

    public function init()
    {
    	$layout=$this->_helper->layout();
    	$layout->setLayout('game');
    }

    public function indexAction()
    {
        // action body
       $this->view->gameconsole="test";
    }


}

