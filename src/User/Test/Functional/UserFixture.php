<?php

declare(strict_types=1);

namespace App\User\Test\Functional;

use App\User\Domain\Service\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserFixture extends Fixture
{
    private UserFactory $factory;

    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->factory->create('valid@email.com', 'valid123');

        $manager->persist($user);
        $manager->flush();
    }
}
