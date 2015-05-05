<?php
$entity = elgg_extract('entity', $vars);
?>
<fieldset class="elgg-fieldset">
	<legend><?php echo elgg_echo('tincan:xapi:lrs') ?></legend>
	<div>
		<label><?php echo elgg_echo('tincan:xapi:lrs_endpoint') ?></label>
		<div class="elgg-text-help"><?php echo elgg_echo('tincan:xapi:lrs_endpoint:help') ?></div>
		<?php
		echo elgg_view('input/text', array(
			'name' => 'params[lrs_endpoint]',
			'value' => $entity->lrs_endpoint,
		));
		?>
	</div>

	<div>
		<label><?php echo elgg_echo('tincan:xapi:lrs_username') ?></label>
		<div class="elgg-text-help"><?php echo elgg_echo('tincan:xapi:lrs_username:help') ?></div>
		<?php
		echo elgg_view('input/text', array(
			'name' => 'params[lrs_username]',
			'value' => $entity->lrs_username,
		));
		?>
	</div>

	<div>
		<label><?php echo elgg_echo('tincan:xapi:lrs_password') ?></label>
		<div class="elgg-text-help"><?php echo elgg_echo('tincan:xapi:lrs_password:help') ?></div>
		<?php
		echo elgg_view('input/text', array(
			'name' => 'params[lrs_password]',
			'value' => $entity->lrs_password,
		));
		?>
	</div>
</fieldset>