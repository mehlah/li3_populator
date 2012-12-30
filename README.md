# Lithium Populator

`li3_populator` library let you generate fake data for your Lithium models and
save them in the database.
It provides a Lithium's ORM/ODM adapter to [Faker](http://github.com/fzaninotto/Faker).

## Usage Example

Here is an example showing how to populate 50 `People` data objects (instances of `lithium\data\entity\Record` or `lithium\data\entity\Document`), and save the
records or documents in the database.

```php
use faker\Factory;
use li3_populator\extensions\adapter\ORM\Lithium\Populator;

$generator = Factory::create();
$populator = new Populator($generator);
$populator->addEntity('People', 50);
$people_ids = $populator->execute();
```

The populator will guess the relevant data for each field based on your models schema definitions.

For a more advanced usage, take a look to [Faker](http://github.com/fzaninotto/Faker) docs.

## Installation

This library is installable via [Composer](https://getcomposer.org/) as [mehlah/li3_populator](https://packagist.org/packages/mehlah/li3_populator).

Don't forget to add the library to your application in `config/bootstrap/libraries.php`

    Libraries::add('li3_populator');

