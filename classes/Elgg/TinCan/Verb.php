<?php

namespace Elgg\TinCan;

class Verb {

	static $action_map;
	protected $verb;

	/**
	 * Constructor
	 *
	 * @param string $verb
	 */
	public function __construct($verb = '') {
		$this->verb = $verb;
	}

	/**
	 * Return properties of a verb
	 * @return array|false
	 */
	public function getProperties() {
		if (!$this->verb) {
			return false;
		}
		return array(
			'id' => $this->getId(),
			'display' => $this->getDisplay(),
		);
	}

	/**
	 * Map an Elgg action, event or river type to a more common TinCan Registry alternative
	 *
	 * @param string $action         Elgg action name
	 * @param string $entity_type    Entity type
	 * @param string $entity_subtype Entity subtype
	 * @return string
	 */
	public function getVerbFromAction($action, $entity_type = '', $entity_subtype = '') {

		$verbs = array(
			'create' => 'created',
			'update' => 'updated',
			'comment' => 'commented',
			'like' => 'liked',
			'tag' => 'tagged',
		);

		$map = self::getActionMap();

		$entity_subtype = ($entity_subtype) ? : 'default';
		if (isset($map[$entity_type][$entity_subtype][$action])) {
			$verbs[$action] = $map[$entity_type][$entity_subtype][$action];
		}

		return elgg_extract($action, $verbs, $action);
	}

	/**
	 * Get a mapping of actions to verbs
	 * @return array
	 */
	private function getActionMap() {

		$action_map = array(
			'object' => array(
				'blog' => array(
					'create' => 'published',
				),
				'file' => array(
					'create' => 'uploaded',
				),
				'image' => array(
					'create' => 'uploaded',
				),
				'forum' => array(
					'create' => 'asked',
				),
				'page' => array(
					'create' => 'authored',
				),
				'page_top' => array(
					'create' => 'authored',
				)
			),
			'user' => array(
				'default' => array(
					'friend' => 'made friend',
				),
			),
			'group' => array(
				'default' => array(
					'join' => 'joined',
				),
			)
		);

		return elgg_trigger_plugin_hook('tincan:actions', 'verb', null, $action_map);
	}

	/**
	 * Returns an ID of the verb
	 * @return string
	 */
	private function getId() {
		$id = elgg_normalize_url("xapi/verbs/$this->verb");
		return elgg_trigger_plugin_hook('tincan:id', 'verb', array(
			'verb' => $this->verb,
				), $id);
	}

	/**
	 * Returns display properties of the verb
	 * @return array
	 */
	private function getDisplay() {
		$key = "tincan:verb:$this->verb";
		$string = elgg_echo($key, array(), 'en');

		$display = array(
			'en' => ($key == $string) ? $this->verb : $string
		);
		
		return elgg_trigger_plugin_hook('tincan:display', 'verb', array(
			'verb' => $this->verb,
				), $display);
	}

}
