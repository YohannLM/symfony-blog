<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;

class PropertyFixtures extends BaseFixture {
	
	protected function loadData( ObjectManager $manager ) {
		$this->createMany(Property::class, 100, function (Property $property) {
			$property->setTitle($this->faker->words(3, true))
				->setSurface($this->faker->numberBetween(25, 200))
				->setPrice($this->faker->randomNumber(6, true))
				->setRooms($this->faker->numberBetween(1, 7))
				->setBedrooms($this->faker->numberBetween(1, 5))
				->setHeat($this->faker->numberBetween(0,count(Property::HEAT) - 1))
				->setFloor($this->faker->numberBetween(0, 10))
				->setAddress($this->faker->streetAddress())
				->setCity($this->faker->city())
				->setPostalCode($this->faker->randomNumber(5, true))
				->setDescription($this->faker->paragraph(2, false));
		});
		
		$manager->flush();
	}
}
