<?php

namespace li3_populator\extensions\adapter\ORM\Lithium;

use Faker\Generator;
use li3_populator\extensions\adapter\ORM\Lithium\EntityPopulator;

class Populator {

	protected $_generator;
	protected $_entities = array();
	protected $_quantities = array();

	public function __construct(Generator $generator) {
		$this->_generator = $generator;
	}

	public function addEntity($entity, $number, $customColumnFormatters = array()) {
		if (!$entity instanceof EntityPopulator) {
			$entity = new EntityPopulator($entity);
		}

		$entity->setColumnFormatters($entity->guessColumnFormatters($this->_generator));
		if ($customColumnFormatters) {
			$entity->mergeColumnFormattersWith($customColumnFormatters);
		}

		$model = $entity->model();
		$name = $model::meta('name');
		$this->_entities[$name] = $entity;
		$this->_quantities[$name] = $number;
	}

	public function execute() {
		$insertedEntities = array();
		foreach ($this->_quantities as $name => $total) {
			for ($i = 0; $i < $total; $i++) {
				$insertedEntities[$name][]= $this->_entities[$name]->execute($insertedEntities);
			}
		}

		return $insertedEntities;
	}

}

?>