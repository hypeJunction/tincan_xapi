<?php

namespace Elgg\TinCan;

use ElggComment;
use ElggRiverItem;

/**
 * Creates and saves xAPI statements whenever new items are created
 *
 * @param string         $event "created"
 * @param string         $type  "river"
 * @param ElggRiverItem $river River item
 * @return bool
 */
function river_created_event($event, $type, $river) {

	$subject = $river->getSubjectEntity();
	$object = $river->getObjectEntity();
	if (!$subject || !$object) {
		return true;
	}

	try {

		$verb = Verb::getVerbFromAction($river->action_type, $object->getType(), $object->getSubtype());

		$statement = new Statement();
		$statement->setActor($subject);
		$statement->setVerb($verb);

		$annotation = $river->getAnnotation();
		if ($annotation) {
			$statement->setTarget($annotation);
			$statement->setResult(array('response' => $annotation->value));
		} else {
			$statement->setTarget($object);
			if ($object instanceof ElggComment) {
				$statement->setResult(array('response' => $object->description));
			}
		}

		$response = $statement->save();

		if ($response->success) {
			// store TinCan Statement reference so that we can recycle it
			if ($river->action_type == 'create') {
				$object->__tincan_uuid = $response->content->getId();
			}
		} else {
			elgg_log("TinCan xAPI Error: " . print_r($response->httpResponse, true), 'ERROR');
		}
	} catch (\Exception $ex) {
		elgg_log("TinCan xAPI Fatal Error: " . $ex->getMessage(), 'ERROR');
	}

	return true;
}
