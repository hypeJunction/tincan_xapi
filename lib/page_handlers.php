<?php

namespace Elgg\TinCan;

/**
 * Handles TinCan pages
 *
 * @param array  $segments   URL segments
 * @param string $identifier Page ID
 * @return boolean
 */
function page_handler($segments, $identifier) {

	$page = elgg_extract(0, $segments);

	switch ($page) {

		case 'verbs' :
			elgg_set_viewtype('json');
			set_input('verb', $segments[1]);
			echo elgg_view('resources/tincan/verbs');
			return true;

		case 'activities' :
			elgg_set_viewtype('json');
			set_input('activity', $segments[1]);
			echo elgg_view('resources/tincan/activities');
			return true;
	}

	return false;
}
