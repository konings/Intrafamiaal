<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $registry = Zend_Registry::getInstance();
        $this->_em = $registry->entitymanager;
    }
    

    public function indexAction()
    {
        $testEntity = new Application_Model_VoteQuestion;
        $testEntity->setQuestion('test vraag');
        $testEntity->setGame_id('4');
        $testEntity->setLesson_id('4');
        $this->_em->persist($testEntity);
        $this->_em->flush();
    }

}


