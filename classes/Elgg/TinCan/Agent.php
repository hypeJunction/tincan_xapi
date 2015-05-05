<?php

namespace Elgg\TinCan;

use ElggBatch;
use ElggEntity;
use ElggGroup;
use ElggUser;

class Agent {

	protected $entity;

	/**
	 * Constructor
	 * 
	 * @param ElggEntity $entity Agent entity
	 */
	public function __construct($entity = null) {
		if (!$entity) {
			$entity = elgg_get_logged_in_user_entity();
		}
		$this->entity = $entity;
	}

	/**
	 * Returns an Elgg entity
	 * @return ElggEntity
	 */
	public function getEntity() {
		return ($this->entity instanceof \ElggEntity) ? $this->entity : false;
	}

	/**
	 * Returns an xAPI definition
	 * @return array|false
	 */
	public function getProperties() {

		$entity = $this->getEntity();
		if (!$entity) {
			return false;
		}

		$properties = array(
			'objectType' => 'Agent',
			'name' => $entity->name,
		);

		if ($entity instanceof ElggUser) {
			$properties['mbox'] = "mailto:{$entity->email}";
		} else if ($entity instanceof ElggGroup) {
			$properties['account'] = array(
				'homePage' => elgg_get_site_url(),
				'name' => $entity->guid,
			);
			$properties['member'] = $this->getMembers();
		}

		return elgg_trigger_plugin_hook('tincan:properties', $entity->getType(), array(
			'entity' => $entity,
				), $properties);
	}

	/**
	 * Returns an array of members
	 * @return Agent[]
	 */
	public function getMembers() {

		$agents = array();
		$members = new ElggBatch('elgg_get_entities_from_relationship', array(
			'types' => 'user',
			'relationship' => 'member',
			'relationship_guid' => (int) $this->entity->guid,
			'inverse_relationship' => true,
			'limit' => 0,
		));

		foreach ($members as $member) {
			$agent = new Agent($member);
			$agents[] = $agent->getProperties();
		}

		return $agents;
	}

}
