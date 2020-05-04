<?php

namespace App\Tests\Entity;


use App\Entity\Task;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DateTime;


class TaskTest extends KernelTestCase
{

    /**
     * Permet de récupérer un user type pour les tests
     * @return User
     */
    public function getUser(): User
    {
        return (new User())
            ->setName('test')
            ->setRole('ROLE_USER')
            ->setEmail('test@test.fr')
            ->setPassword('123456');

    }

    /**
     * Permet de récupérer un user type pour les tests
     * @return Task
     */
    public function getTask(): Task
    {
        return (new Task())
            ->setUser($this->getUser())
            ->setCreatedAt(new \DateTime('now'))
            ->setTitle('title')
            ->setContent('content')
            ->setIsDone(false)

            ;

    }

    /**
     * @param Task $task
     * @param int $number
     */
    public function assertHasErrors(Task $task, int $number = 0)
    {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount($number, $error);
    }

    /**
     * Test des getters
     *
     */
    public function testGettersTask()
    {
        $this->assertSame('title', $this->getTask()->getTitle());
        $this->assertSame('content', $this->getTask()->getContent());
        $this->assertSame(false, $this->getTask()->getIsDone());
        $this->assertSame(null, $this->getTask()->getId());
        $this->assertEquals($this->getUser(), $this->getTask()->getUser());
        $this->assertInstanceOf('DateTime', $this->getTask()->getCreatedAt());
    }

    /**
     * Test des validations à la création d'une task
     */
    public function testValidEntitySetters()
    {
        $this->assertHasErrors($this->getTask(), 0);
    }

    /**
     * Test de validation d'un titre comprenant moins de 5 caractères
     */
    public function testTitleMinInvalid()
    {
        $title = $this->getTask()->setTitle('');
        $this->assertHasErrors($title, 1);
    }

    /**
     * Test de validation d'un titre qui comprend plus de 50 caractères
     */
    public function testTitleMaxInvalid()
    {
        $title = $this->getTask()->setTitle('Ceci est un texte qui comprend plus de 50 caractères');
        $this->assertHasErrors($title, 1);
    }

    /**
     * Test de validation d'une description de moins de 5 caractères
     */
    public function testContentMinInvalid()
    {
        $content = $this->getTask()->setContent('');
        $this->assertHasErrors($content, 1);
    }

    /**
     * Test de validation d'une description de plus de 250 caractères
     */
    public function testContentMaxInvalid()
    {
        $content = $this->getTask()->setContent(
            'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
            aaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        );
        $this->assertHasErrors($content, 1);
    }

    /**
     * Test si isDone est true
     */
    public function testIsDoneTrue()
    {
        $isDone = $this->getTask()->setIsDone(true);
        $this->assertHasErrors($isDone, 0);
    }

    /**
     * Test si isDone false
     */
    public function testIsDoneFalse()
    {
        $isDone = $this->getTask()->setIsDone(false);
        $this->assertHasErrors($isDone, 0);
    }

   

}
