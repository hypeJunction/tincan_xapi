<?php

namespace Elgg\TinCan;

$verb = get_input('verb');

echo json_encode(array(
	'name' => array(
		'en' => elgg_echo("tincan:$verb"),
	),
	'description' => array(
		'en' => elgg_echo("tincan:$verb:desc", array(), 'en')
	)
));
