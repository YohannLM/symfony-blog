<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\fr_FR\Address;

abstract class BaseFixture extends Fixture {
	
	/** @var ObjectManager */
	private $manager;
	
	/** @var Generator */
	protected $faker;
	
	abstract protected function loadData(ObjectManager $manager);
	
	/**
	 * @inheritDoc
	 */
	public function load( ObjectManager $manager ) {
		$this->manager = $manager;
		$this->faker = Factory::create('fr_FR');
		
		$this->loadData($manager);
	}
	
	protected function createMany(string $className, int $count, callable $factory)
	{
		for ($i = 0; $i < $count; $i++) {
			$entity = new $className();
			$factory($entity, $i);
			$this->manager->persist($entity);

		}
	}
}
