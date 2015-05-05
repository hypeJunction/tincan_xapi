Elgg TinCan xAPI
================

This plugin integrates TinCan Experience API and transmits TinCan statements to
an LRS of your choosing.

The plugin has been commissioned and sponsored by Bodyology School of Massage.

TODO:

- Implement Interaction Activity API
- Implement Attachment API
- Implement Extensions https://registry.tincanapi.com/#home/extensions


### Defining Verbs

To define a verb, you will need to add name and definition to your language files,
e.g. to define ```created```, add the following strings to your language files:

```php
$en = array(
	'tincan:verb:answered' => 'created',
	'tincan:verb:answered:desc' => 'Indicates the actor responded to a Question.',
);
```

### Definiting Activities

To define an activity, you will need to add name and definition to your language files,
e.g. to define a Elgg object with subtype question, add the following strings to your language files:

```php
$en = array(
	'tincan:activity:object:question' => 'question',
	'tincan:activity:object:question:desc' => 'A question is typically part of an assessment and requires a response from the learner, a response that is then evaluated for correctness.',
);
```
