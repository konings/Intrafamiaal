<?php

/**
 *
 * @Entity @Table(name="voteresponses")
 *
 */


class Application_Model_VoteResponse
{
	/**
	 * @Id @Column(type="integer")
	 * @GeneratedValue(strategy="AUTO")
	 */
	private $id;


	/** @Column(type="decimal", length=11) */
	private $question_id;

	/** @Column(type="decimal", length=11) */
	private $user_id;

	/** @Column(type="decimal", length=11) */
	private $vote;
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return the $question_id
	 */
	public function getQuestion_id() {
		return $this->question_id;
	}

	/**
	 * @return the $user_id
	 */
	public function getUser_id() {
		return $this->user_id;
	}

	/**
	 * @return the $vote
	 */
	public function getVote() {
		return $this->vote;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @param field_type $question_id
	 */
	public function setQuestion_id($question_id) {
		$this->question_id = $question_id;
	}

	/**
	 * @param field_type $user_id
	 */
	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	/**
	 * @param field_type $vote
	 */
	public function setVote($vote) {
		$this->vote = $vote;
	}

	
}
