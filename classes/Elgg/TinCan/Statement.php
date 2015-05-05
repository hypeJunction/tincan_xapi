<?php

namespace Elgg\TinCan;

use ElggAnnotation;
use ElggComment;
use ElggEntity;
use ElggUser;
use TinCan\LRSResponse;
use TinCan\Statement as TinCanStatement;

class Statement {

	protected $actor;
	protected $verb;
	protected $target;
	protected $result;
	protected $context;
	
	/**
	 * Sets an actor for an xAPI Statement
	 *
	 * @param mixed $actor User or group GUID or entity
	 * @return self
	 */
	public function setActor($actor = null) {
		if (is_numeric($actor)) {
			$actor = get_entity($actor);
		}

		$this->actor = new Agent($actor);
		return $this;
	}

	/**
	 * Returns an actor of the statement
	 * @return Agent
	 */
	public function getActor() {
		return ($this->actor) ? : new Agent();
	}

	/**
	 * Sets a verb for an xAPI Statement
	 * 
	 * @param string $verb
	 * @return self
	 */
	public function setVerb($verb = '') {
		$this->verb = new Verb($verb);
		return $this;
	}

	/**
	 * Returns a verb of the statement
	 * @return Verb
	 */
	public function getVerb() {
		return ($this->verb) ? : new Verb();
	}

	/**
	 * Sets the target activity
	 * 
	 * @param mixed $target Activity GUID or entity
	 * @return self
	 */
	public function setTarget($target = null) {

		if (is_numeric($target)) {
			$target = get_entity($target);
		}

		if ($target instanceof ElggUser) {
			$this->target = new Agent($target);
		} else if ($target instanceof ElggComment || $target instanceof ElggAnnotation) {
			$this->target = new Subactivity($target);
		}else if ($target instanceof ElggEntity) {
			$this->target = new Activity($target);
		}

		return $this;
	}

	/**
	 * Returns a target of the statement
	 * @return Activity
	 */
	public function getTarget() {
		return ($this->target) ? : new Activity();
	}

	/**
	 * Sets statement result properties
	 *
	 * @param array $result Result properties
	 * @return self
	 */
	public function setResult(array $result = array()) {
		$this->result = $result;
	}

	/**
	 * Returns result properties
	 * @return mixed
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Sets context properties
	 * @param array $context Context properties
	 */
	public function setContext(array $context = array()) {
		return $this->context = $context;
	}

	/**
	 * Returns context properties
	 * @return mixed
	 */
	public function getContext() {
		return $this->context;
	}

	/**
	 * Saves xAPI Statement to Remote LRS
	 * @return LRSResponse
	 */
	public function save() {

		$lrs = LRS::getRemoteLRS();
		$statement = new TinCanStatement(array_filter(array(
			'actor' => $this->getActor()->getProperties(),
			'verb' => $this->getVerb()->getProperties(),
			'object' => $this->getTarget()->getProperties(),
			'result' => $this->getResult(),
			'context' => $this->getContext(),
		)));
		return $lrs->saveStatement($statement);
	}

}
