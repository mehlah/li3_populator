<?php

use lithium\core\Libraries;

$library = Libraries::get('faker');

if (empty($library)) {
	Libraries::add('faker', array(
		'path' => LITHIUM_APP_PATH . '/vendor/fzaninotto/faker',
		'bootstrap' => 'src/autoload.php'
	));
}
?>