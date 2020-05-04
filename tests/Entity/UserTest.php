<?php

namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class UserTest extends KernelTestCase
{

    /**
     * Permet de récupérer un user type pour les tests
     * @return Task
     */
    public function getTask(): Task
    {
        return (new Task())
            ->setCreatedAt(new \DateTime('now'))
            ->setTitle('title')
            ->setContent('content')
            ->setIsDone(false);

    }

    /**
     * Permet de récupérer un user type pour les tests
     * @return User
     */
    public function getEntity(): User
    {
        return (new User())
            ->setName('test')
            ->setRole('ROLE_USER')
            ->setEmail('test@test.fr')
            ->setPassword('123456')
            ->addTask($this->getTask());

    }

    /**
     * Test le retour d'une erreur
     *
     * @param User $user
     * @param int $number
     */
    public function assertHasErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($user);

        $this->assertCount($number, $errors);
    }

    /**
     * Test des getters
     *
     */
    public function testGettersUser()
    {
        $entity = $this->getEntity();
        $this->assertSame(null, $this->getEntity()->getId());
        $this->assertSame('test', $entity->getName());
        $this->assertSame('test@test.fr', $entity->getUsername());
        $this->assertSame('ROLE_USER', $entity->getRole());
        $this->assertSame(['ROLE_USER'], $entity->getRoles());
        $this->assertSame('test@test.fr', $entity->getEmail());
        $this->assertSame('123456', $entity->getPassword());

    }

    /**
     * Teste les validations à la création d'un user
     */
    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    /**
     * Test de validation sur un password invalide
     */
    public function testInvalidPasswordEntity()
    {
        $password = $this->getEntity()->setPassword('12345');
        $this->assertHasErrors($password, 1);
    }

    /**
     * Test de validation sur un email invalide
     */
    public function testInvalidEmail()
    {
        $email = $this->getEntity()->setEmail('testEmail');
        $this->assertHasErrors($email, 1);
    }

    /**
     * Test de validation sur un role invalide
     */
    public function testInvalidRole()
    {
        $role = $this->getEntity()->setRole('');
        $this->assertHasErrors($role, 1);
    }


}