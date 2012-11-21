<?php
/**
 * Numword
 *
 * Converts a number to its word form.
 *
 * @author 		Miles Johnson - http://milesj.me
 * @copyright	Copyright 2006-2011, Miles Johnson, Inc.
 * @license 	http://opensource.org/licenses/mit-license.php - Licensed under The MIT License
 * @link		http://milesj.me/code/php/numword
 */

// Turn on errors
error_reporting(E_ALL);
setlocale(LC_ALL, 'en_US.utf8');

function debug($var) {
	echo '<pre>' . print_r($var, true) . '</pre>';
}

// Include class and instantiate
include_once '../Numword.php';

use \mjohnson\numword\Numword;

// Convert a single number
debug(Numword::single(1337));

// Convert multiple numbers
debug(Numword::multiple(array(1, 50, 125, 5034)));

// Convert numbers within a block sentence
debug(Numword::block('I am 25 years, 15 days and 62 minutes years old.'));

// Convert currency
debug(Numword::currency('$593,423.05'));

// Convert currency (dollar symbol based on PHP locale setting)
debug(Numword::currency('48,530.38', array('dollar' => 'pound(s)', 'cent' => 'pence')));

// Convert large numbers (must be strings becaused of 32 bit integers)
debug(Numword::multiple(array(
	'8234780234',
	'64382348',
	'6945293483491',
	'5483432432667606',
	'594954944045845945454'
)));