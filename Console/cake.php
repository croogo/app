#!/usr/bin/php -q
<?php
/**
 * Command-line code generation utility to automate programmer chores.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Console
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$ds = DIRECTORY_SEPARATOR;
$dispatcher = 'Cake' . $ds . 'Console' . $ds . 'ShellDispatcher.php';
$found = false;
$paths = explode(PATH_SEPARATOR, ini_get('include_path'));

foreach ($paths as $path) {
	if (file_exists($path . $ds . $dispatcher)) {
		$found = $path;
	}
}

if (!$found && function_exists('ini_set')) {
	$appDir = dirname(dirname(__FILE__));
	$vendorDir = $appDir . $ds . 'Vendor' . $ds;
	$root = dirname($appDir);
	ini_set('include_path',
		$root . $ds . 'lib' . PATH_SEPARATOR .
		$vendorDir . 'pear-pear.cakephp.org' . $ds . 'CakePHP' .  PATH_SEPARATOR .
		ini_get('include_path')
	);

	if (in_array('test', $argv) && in_array('croogo', $argv) && !defined('TESTS')) {
		$key = array_keys($argv, 'croogo');
		$argv[current($key)] = 'app';
		define('TESTS', $vendorDir . 'croogo' . $ds . 'croogo' . $ds . 'Test' . $ds);
	}
}

if (!include ($dispatcher)) {
	trigger_error('Could not locate CakePHP core files.', E_USER_ERROR);
}
unset($paths, $path, $found, $dispatcher, $root, $ds);

return ShellDispatcher::run($argv);
