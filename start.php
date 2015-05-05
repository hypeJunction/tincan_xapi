<?php

namespace Elgg\TinCan;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/events.php';
require_once __DIR__ . '/lib/hooks.php';
require_once __DIR__ . '/lib/page_handlers.php';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

/**
 * Initialize the plugin
 * @return void
 */
function init() {

	elgg_register_page_handler('xapi', __NAMESPACE__ . '\\page_handler');
	
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', __NAMESPACE__ . '\\public_pages_filter');

	elgg_register_event_handler('created', 'river', __NAMESPACE__ . '\\river_created_event');
	
}
