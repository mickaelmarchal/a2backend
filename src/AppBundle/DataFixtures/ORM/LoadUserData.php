<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setEmail('test@test.com');
        $userAdmin->setPassword('$2y$12$wd9qBFFmBWqew2wOplz3GOnea6igQrkM2bTPsHZxmSu4ycUmt8gP2'); // "test"
        $userAdmin->setFirstName('John');
        $userAdmin->setLastName('Smith');

        $manager->persist($userAdmin);
        $manager->flush();
    }
}