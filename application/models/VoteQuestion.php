<?php

/**
 * 
 * @Entity @Table(name="votequestions")
 *
 */


class Application_Model_VoteQuestion
{
	/**
	 * @Id @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;
	
	
	/** @Column(type="decimal", length=11) */
	private $game_id;
	
	/** @Column(type="text") */
	private $question;
	
	/** @Column(type="decimal", length=11) */
	private $lesson_id;
	
	/** @Column(type="decimal", length=11) */
	private $finished;
	
	/**
	 * @return the $finished
	 */
	public function getFinished() {
		return $this->finished;
	}

	/**
	 * @param field_type $finished
	 */
	public function setFinished($finished) {
		$this->finished = $finished;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $game_id
	 */
	public function getGame_id() {
		return $this->game_id;
	}

	/**
	 * @return the $question
	 */
	public function getQuestion() {
		return $this->question;
	}

	/**
	 * @return the $lesson_id
	 */
	public function getLesson_id() {
		return $this->lesson_id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $game_id
	 */
	public function setGame_id($game_id) {
		$this->game_id = $game_id;
	}

	/**
	 * @param field_type $question
	 */
	public function setQuestion($question) {
		$this->question = $question;
	}

	/**
	 * @param field_type $lesson_id
	 */
	public function setLesson_id($lesson_id) {
		$this->lesson_id = $lesson_id;
	}

	
	
	
}

