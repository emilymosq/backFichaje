<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AutorizacionTest extends WebTestCase
{

    private KernelBrowser $client;
    private UserRepository|null $userRepo;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepo = static::$container->get(UserRepository::class);
    }

    /** @test */
    public function admin_ve_admin()
    {
        $testUser = $this->userRepo->findOneByEmail('testuser@gmail');

        //simulate login user in
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/crud/');

        $this->assertResponseIsSuccessful();
    }
}
