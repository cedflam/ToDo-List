<?php

namespace App\DataFixtures;

use App\Entity\RoleUser;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr-FR');


        $roleUser = new RoleUser();
        $roleUser->setAddRole(['ROLE_USER']);
        $manager->persist($roleUser);

        $roleAdmin = new RoleUser();
        $roleAdmin->setAddRole(['ROLE_ADMIN']);
        $manager->persist($roleAdmin);


        $user = new User();
        $user->setUsername('admin')
            ->setEmail('admin@admin.fr')
            ->setPassword($this->encoder->encodePassword($user, 'password'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setUsername($faker->userName)
                ->setRoles(['ROLE_USER']);

            for ($j = 0; $j < 5; $j++) {
                $task = new Task();
                $task->setTitle($faker->sentence(4))
                    ->setContent($faker->sentence(8))
                    ->setCreatedAt($faker->dateTimeBetween('-30 Days', 'now'))
                    ->setIsDone(false)
                    ->setUser($user);

                $manager->persist($task);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
