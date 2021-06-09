<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

	public function testSessionContainsSecurityToken(): void
    {
        $client = self::createClient();

        self::assertUserIsNotAuthenticated();

        $client->loginUser(new InMemoryUser('admin', 'password', ['ROLE_ADMIN']));

        self::assertUserIsAuthenticated();
    }

    private static function session(): SessionInterface
    {
        return static::getContainer()->get(SessionInterface::class);
    }

    protected static function assertUserIsNotAuthenticated(): void
    {
        $token = self::session()->get('_security_main');

        self::assertNull($token, 'The user is authenticated');
    }

    protected static function assertUserIsAuthenticated(): void
    {
        $token = self::session()->get('_security_main');

        self::assertIsString($token, 'The user is not authenticated');
    }
}
