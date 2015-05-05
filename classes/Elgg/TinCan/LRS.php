<?php

namespace Elgg\TinCan;

use TinCan\RemoteLRS;

class LRS {

	const VERSION = '1.0.1';

	/**
	 * Returns a remote LRS
	 * @return RemoteLRS
	 */
	public function getRemoteLRS() {
		$endpoint = self::getSetting('lrs_endpoint');
		$username = self::getSetting('lrs_username');
		$password = self::getSetting('lrs_password');

		$lrs = new RemoteLRS(array(
			'endpoint' => $endpoint,
			'version' => self::VERSION,
			'username' => $username,
			'password' => $password
		));

		return $lrs;
	}

	/**
	 * Returns a plugin setting value by name
	 *
	 * @param string $name Setting name
	 * @return mixed
	 */
	private function getSetting($name) {
		return elgg_get_plugin_setting($name, 'tincan_xapi');
	}

}
