<?php

class SyncPollController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->_helper->layout()->disableLayout();
    	Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);	   
    	$registry = Zend_Registry::getInstance();
    	$this->_em = $registry->entitymanager;
    	//$em = $this->_helper->EntityManager();
    	

    }

    public function indexAction()
    {
        // action body
        print("test");
        //$votequestion_model = $this->_em->getRepository('Application_Model_VoteQuestion');
        //print_r($votequestion_model);
    	
    }

    public function readAction()
    {
		print_r($_REQUEST);
    }

    public function postAction()
    {
		print_r($_REQUEST);
    }

    public function createPollAction()
    {
		print_r($_REQUEST);
    }

    public function createAction()
    {
        // action body
		print_r($_REQUEST);
    }

    public function updateAction()
    {
        // action body
        //$response = new Application_Model_VoteResponse;
        //$response->setQuestion_id($this->_request->getParam('id'));
        //if($this->_request->getParam('antwoord')=="ja")
        //	$response->setVote(1);
        //else
        //	$response->setVote(0);
        	
        //$response->setUser_id("1");
		//$this->_em->persist($response);
		//$this->_em->flush();
		
    	
   			
   		$stop=true;
   		$i=1;
   		

   		$db = Zend_Db::factory('Pdo_Mysql', array(
   				'host'     => 'localhost',
   				'username' => 'root',
   				'password' => 'password',
   				'dbname'   => 'intrafamiaal'
   		));
   		
   		if($this->_request->getParam('antwoord')=="ja")
   			$voteresponse=1;
   		else
   			$voteresponse=0;;
   		
   		$data = array(
   				'question_id'      => $this->_request->getParam('id'),
   				'user_id' => '1',
   				'vote'      => $voteresponse
   		);
   		
   		$db->insert('voteresponses', $data);
   		
   		
   		$result = $db->fetchAll('SELECT vote FROM voteresponses WHERE question_id = ' . $this->_request->getParam('id'));
   		
   		//$db->setFetchMode(Zend_Db::FETCH_OBJ);
 
	
   		
   		//$i=0;
   		
   		//while($stop)
   		//{
   		//	
  		//	
   		//	$result = $db->fetchRow('SELECT finished FROM votequestions WHERE id = ' . $this->_request->getParam('id'));			
		//
   		//	if($result->finished==1)
   		//		$stop=false;
   		//	else
   		//		sleep(3);
   		//}
   		
   		$stop=true;
   		$i=0;
   		
   		while($stop)
   		{
   		
   		
   			$result = $db->fetchAll('SELECT vote FROM voteresponses WHERE question_id = ' . $this->_request->getParam('id'));
   		
   			if(count($result)>=5)
   				$stop=false;
   			else
   				sleep(1);
   		}

		print_r(json_encode(array("status"=>"ok")));
    	
    }

    public function deleteAction()
    {
         //action body

    }

    public function fetchAction()
    {
        // action body
       
   		if($this->_request->getParam('gameid')!="" and $this->_request->getParam('lesson')!="")
   		{
   			$qb = $this->_em->createQueryBuilder();
   			$qb->add('select', 'a')
   			->add('from', 'Application_Model_VoteQuestion a')
   			->add('where', $qb->expr()->andx(
   					$qb->expr()->eq('a.game_id', $this->_request->getParam('gameid')),
   					$qb->expr()->eq('a.lesson_id', $this->_request->getParam('lesson'))
   			))
   			->add('orderBy', 'a.id ASC');
   			
   			
   			$query = $qb->getQuery();
   			$items = $query->getResult();
   			$output=array();
   			
   			foreach($items as $item)
   			{
   				array_push($output,array("id"=>$item->getId(),"question"=>$item->getQuestion()));
   			}
   			
   			
   			print(json_encode(array("status"=>"ok","data"=>$output)));
   			//print(json_encode($output));
   		}
   		else
   			//print(json_encode(null));
   			print(json_encode(array("status"=>"error","msg"=>"gameid enof lesson niet gedeclareerd"))); 

    }

    public function liveAction()
    {
       	$db = Zend_Db::factory('Pdo_Mysql', array(
   				'host'     => 'localhost',
   				'username' => 'root',
   				'password' => 'password',
   				'dbname'   => 'intrafamiaal'
   		));
   		
   		$db->setFetchMode(Zend_Db::FETCH_OBJ);
 
	
   		$stop=true;
   		$i=0;
   		
   		while($stop)
   		{
   			
  			
   			$result = $db->fetchAll('SELECT vote FROM voteresponses WHERE question_id = ' . $this->_request->getParam('id'));			
			
   			if(count($result)>=5)
   			{
   				$count=array();
   				foreach($result as $aresult)
   				{
					if(isset($count[$aresult->vote . "_"]))
   						$count[$aresult->vote . "_"]["count"]++;
					else
						$count[$aresult->vote . "_"]=array("vote"=>$aresult->vote,"count"=>1);
   				}
   				$stop=false;
   			}
   			else
   				sleep(1);
   		}
   		print_r(json_encode(array("status"=>"ok", "data"=>$count)));
    }


}













