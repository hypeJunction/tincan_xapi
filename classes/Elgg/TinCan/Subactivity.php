<?php

namespace Elgg\TinCan;

use ElggEntity;
use ElggExtender;

class Subactivity extends Activity {

	/**
	 * Returns an Elgg entity
	 * @return ElggEntity|ElggExtender
	 */
	public function getEntity() {
		$entity = $this->entity;
		if ($entity instanceof ElggEntity) {
			$parent = $entity->getContainerEntity();
		} else if ($entity instanceof ElggExtender) {
			$parent = $entity->getEntity();
		}
		return ($parent instanceof ElggEntity) ? $parent : false;
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

		if (!$entity->__tincan_uuid) {
			return false;
		}

		$properties = array(
			'objectType' => 'StatementRef',
			'id' => $entity->__tincan_uuid,
		);

		return elgg_trigger_plugin_hook('tincan:properties', 'statement_ref', array(
			'entity' => $entity,
				), $properties);
	}

}
