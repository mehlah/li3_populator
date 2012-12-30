<?php

namespace li3_populator\extensions\adapter\ORM\Lithium;

use Faker\Generator;

class ColumnTypeGuesser {

	protected $_generator;

	public function __construct(Generator $generator) {
		$this->_generator = $generator;
	}

	public function guessFormat($field, $type) {
		$generator = $this->_generator;

		switch ($type) {
			case 'boolean':
				return function() use ($generator) { return $generator->boolean; };
			case 'integer':
				return function() { return mt_rand(0,intval('4294967295')); };
			case 'float':
				return function() { return mt_rand(0,intval('4294967295'))/mt_rand(1,intval('4294967295')); };
			case 'string':
				return function() use ($generator) { return $generator->sentence(); };
			case 'date':
				return function() use ($generator) { return $generator->dateTimeThisYear(); };
			default:
				// no smart way to guess what the user expects here
				return null;
		}
	}
}

?>