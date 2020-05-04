<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Test l'affichage de la page de login
     */
    public function testDisplayLogin()
    {
       $client = static::createClient();
       $client->request('GET', '/login');
       $this->assertSelectorTextContains('h3', 'Connexion');
       $this->assertResponseStatusCodeSame(Response::HTTP_OK);
       $this->assertSelectorNotExists('alert.alert-danger');
    }

    /**
     * Test l'affichage de la page de login
     */
    public function testLogin()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@admin.fr',
            'PHP_AUTH_PW'   => 'password',
        ]);
        $client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}