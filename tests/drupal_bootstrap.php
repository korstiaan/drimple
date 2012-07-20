<?php

define('DRUPAL_ROOT',realpath(__DIR__.'/../vendor/drupal/drupal'));
if (!is_dir(DRUPAL_ROOT)) {
	return false;
}

copy(__DIR__.'/baseline/drupal.db',__DIR__.'/db/drupal.db');

$GLOBALS['databases'] = array(
	'default' => array(
		'default' => array(
			'driver' 	=> 'sqlite',
			'database' 	=> __DIR__.'/db/drupal.db',
		),
	),
);

$link = DRUPAL_ROOT.'/sites/all/modules/drimple_test';

if (!is_dir($link)) {
	symlink(__DIR__.'/drimple_test', $link);
}

$link = DRUPAL_ROOT.'/sites/all/modules/drimple';
if (!is_dir($link)) {
	mkdir($link);
	symlink(__DIR__.'/../drimple.info', $link.'/drimple.info');
	symlink(__DIR__.'/../drimple.module', $link.'/drimple.module');
}
chdir(DRUPAL_ROOT);

$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

include('includes/bootstrap.inc');

drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
module_enable(array('drimple','drimple_test'));