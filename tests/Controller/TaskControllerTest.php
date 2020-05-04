<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    /**
     * Permet de se connecter
     *
     * @return KernelBrowser
     */
    public function login()
    {
        return $client =  static::createClient([], [
            'PHP_AUTH_USER' => 'admin@admin.fr',
            'PHP_AUTH_PW'   => 'password',
        ]);
    }
    /**
     * Test de la route "/tasks"
     */
    public function testTaskList()
    {
        $client = $this->login();
        $client->request('GET', '/tasks');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test de la route "/tasks/user"
     */
    public function testTaskUserList()
    {
        $client = $this->login();
        $client->request('GET', '/tasks/user');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test de la route "/tasks/done"
     */
    public function testTaskDoneList()
    {
        $client = $this->login();
        $client->request('GET', '/tasks/done');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test la création d'une task valide
     */
    public function testTaskNewValid()
    {
        $client = $this->login();
        $client->request(
            'POST',
            '/tasks/new',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"PHPUNIT", "content": "voici un contenu assez long..."}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }

    /**
     * Test de la création d'une task invalide
     */
    public function testTaskNewInvalid()
    {
        $client = $this->login();
        $client->request(
            'POST',
            '/tasks/new',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"PHPUNIT", "content": ""}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }


    /**
     * Test de la modification d'une task invalide
     */
    public function testTaskEditValid()
    {
        $client = $this->login();
        $client->request(
            'PUT',
            '/tasks/edit/335',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"PHPUNIT", "content": "Voici un contenu assez long ..."}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test de la modification d'une task invalide
     */
    public function testTaskEditInvalid()
    {
        $client = $this->login();
        $client->request(
            'PUT',
            '/tasks/edit/335',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"PHPUNIT", "content": ""}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    /**
     * Test de la création d'une task invalide
     */
    public function testTaskIsDone()
    {
        $client = $this->login();
        $client->request(
            'PUT',
            '/tasks/isDone/335',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"isDone": false}'
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }


    /**
     * Test de la suppression d'une task invalide
     */
    /*public function testTaskDelete()
    {
        $client = $this->login();
        $client->request(
            'PUT',
            '/tasks/delete/353',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],

        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }*/
    //TODO: Decommenter et changer l'id de suppression lors du test

    /**
     * Test de la création d'une task invalide
     */
    public function testDashboardFindAll()
    {
        $client = $this->login();
        $client->request(
            'PUT',
            '/dashboard/findAllTasks',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],

        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test de la création d'une task invalide
     */
    public function testDashboardFindUserTasks()
    {
        $client = $this->login();
        $client->request(
            'PUT',
            '/dashboard/findUserTasks',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],

        );

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

}