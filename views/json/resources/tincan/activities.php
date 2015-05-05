<?php

namespace Elgg\TinCan;

$activity = get_input('activity');

echo json_encode(array(
	'name' => array(
		'en' => $activity,
	),
	'description' => array(
		'en' => elgg_echo("$activity:desc", array(), 'en')
	)
));
