<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
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
     * Test la création d'un user valide
     */
    public function testUserNew()
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/user/create');
        $form = $crawler->selectButton('Valider')->form([
            'user[name]' => 'PHPUNITcreate',
            'user[email]' => 'PHPUNITcreate@TEST.fr',
            'user[role]' => 'ROLE_USER',
            'user[password]' => 'password'
        ]);
        $client->submit($form);
        $client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test la création d'un user valide
     */
    public function testUserEdit()
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/user/edit/21');
        $form = $crawler->selectButton('Valider')->form([
            'user[name]' => "PHPUNIT",
            'user[email]' => 'PHPUNIT@TEST.fr',
            'user[role]' => 'ROLE_USER',
            'user[password]' => 'password'
        ]);
        $client->submit($form);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Test de la function usersShow()
     */
    public function testUsersShow()
    {
        $client = $this->login();
        $client->request('GET', '/user/show');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

}