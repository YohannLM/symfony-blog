<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends BaseFixture {
	
	public function loadData( ObjectManager $manager ) {
		// Admin user
		$this->createMany(User::class, 1, function (User $user) {
			$user->setEmail('admin@admin.com')
			     ->setFullName($this->faker->name())
			     ->setPseudo($this->faker->firstName() . mt_rand(0, 100))
			     ->setPlainPassword('demo')
			     ->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
			
			
		});
		// User
		$this->createMany(User::class, 10, function (User $user) {
			$user->setEmail($this->faker->email())
				->setFullName($this->faker->name())
				->setPseudo($this->faker->firstName() . mt_rand(0, 100))
				->setPlainPassword('demo')
				->setRoles(['ROLE_USER']);
			
			
		});
		
		$manager->flush();
	}
}
