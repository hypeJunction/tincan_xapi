<?php

namespace Elgg\TinCan;

use ElggEntity;
use ElggFile;

class Activity {

	protected $entity;

	/**
	 * Constructor
	 *
	 * @param ElggEntity $entity Activity object
	 */
	public function __construct($entity) {
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
	 * @return array
	 */
	public function getProperties() {

		$entity = $this->getEntity();
		if (!$entity) {
			return false;
		}

		$properties = array(
			'objectType' => 'Activity',
			'id' => $entity->getURL(),
			'definition' => array(
				'name' => array(
					'en' => $entity->getDisplayName(),
				),
				'type' => $this->getActivityType(),
				'extensions' => array()
			),
		);

		return elgg_trigger_plugin_hook('tincan:properties', $entity->getType(), array(
			'entity' => $entity,
				), $properties);
	}

	/**
	 * Returns a more sensible activity type from entity subtype
	 * @return string
	 */
	private function getActivityType() {

		$entity = $this->getEntity();
		if (!$entity) {
			return false;
		}

		$namespaces = array('tincan', 'activity');

		if ($entity instanceof ElggFile) {
			$namespaces[] = 'object';
			$namespaces[] = 'file';
			$namespaces[] = $entity->simpletype;
		} else {
			$namespaces[] = $entity->getType();
			$namespaces[] = $entity->getSubtype();
		}

		$activity = elgg_echo(implode(':', array_filter($namespaces)), array(), 'en');

		$iri = elgg_normalize_url("xapi/activities/$activity");
		
		return elgg_trigger_plugin_hook('tincan:type', 'activity', array(
			'entity' => $entity,
				), $iri);
	}

}
