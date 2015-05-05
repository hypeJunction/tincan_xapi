<?php

namespace Elgg\TinCan;

/**
 * Adds TinCan API pages to public pages
 *
 * @param string $hook   "public_pages"
 * @param string $type   "walled_garden"
 * @param array  $return Public pages
 * @return array
 */
function public_pages_filter($hook, $type, $return) {

	$return[] = "xapi/.*";
	return $return;
}