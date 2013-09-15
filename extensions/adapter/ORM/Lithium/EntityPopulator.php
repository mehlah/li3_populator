<?php

namespace li3_populator\extensions\adapter\ORM\Lithium;

use Faker\Guesser\Name;
use Faker\Generator;
use li3_populator\extensions\adapter\ORM\Lithium\ColumnTypeGuesser;
use lithium\core\Libraries;

class EntityPopulator {

	protected $_model;

	protected $columnFormatters = array();

	public function __construct($model) {
		$this->_model = Libraries::locate('models', $model);
	}

	public function model() {
		return $this->_model;
	}

	public function setColumnFormatters($columnFormatters) {
		$this->columnFormatters = $columnFormatters;
	}

	public function mergeColumnFormattersWith($columnFormatters) {
		$this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
	}

	public function guessColumnFormatters(Generator $generator) {
		$formatters = array();
		$model = $this->_model;

		$nameGuesser = new Name($generator);
		$columnTypeGuesser = new ColumnTypeGuesser($generator);

		foreach ($model::schema()->fields() as $field => $config) {
			if ($field == $model::key()) {
				continue;
			}

			if ($formatter = $nameGuesser->guessFormat($field)) {
				$formatters[$field] = $formatter;
				continue;
			}

			if ($formatter = $columnTypeGuesser->guessFormat($field, $config['type'])) {
				$formatters[$field] = $formatter;
				continue;
			}
		}

		return $formatters;
	}

	/**
	 * Insert one new record using the Entity class.
	 */
	public function execute($insertedEntities) {
		$model = $this->_model;
		$obj = $model::create();

		foreach ($this->columnFormatters as $field => $format) {
			if (null !== $format) {
				$obj->{$field} = is_callable($format) ? $format($insertedEntities, $obj) : $format;
			}
		}

		$obj->save();

		return $obj->_id;
	}
}

?>