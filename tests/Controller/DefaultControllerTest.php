<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\InMemoryUser;

class DefaultControllerTest extends WebTestCase
{
	public function test()
	{
		$client = self::createClient();

		$client->loginUser(new InMemoryUser('admin', 'password', ['ROLE_ADMIN']));
		$client->request('GET', '/admin-page');
        self::assertResponseIsSuccessful();

		$client->loginUser(new InMemoryUser('other', 'password', ['ROLE_OTHER']));
		$client->request('GET', '/admin-page');
        self::assertResponseStatusCodeSame(403);
	}
}
