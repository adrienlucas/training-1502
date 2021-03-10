<?php

declare(strict_types=1);

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    public function testItDeniesAccessToProtectedResource()
    {
        $client = self::createClient();
        $client->request('GET', '/admin');

        static::assertResponseRedirects('/login');
    }

    public function testItDeniesAccessToProtectedResourceWhenInsufficientRole()
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Sign in', [
            'username' => 'lucas',
            'password' => 'barfoo',
        ]);

        $client->request('GET', '/admin');
        static::assertResponseStatusCodeSame(403);
    }

    public function testItDeniesAccessToProtectedResourceWhenGivenBadCredentials()
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Sign in', [
            'username' => 'adrien',
            'password' => 'barfoo',
        ]);
        $client->followRedirect();

        static::assertSelectorTextSame(
            'body div.alert.alert-danger',
            'Invalid credentials.'
        );
    }

    public function testItGrantsAccessToProtectedResourceWhenGivenTheRightCredentials()
    {
        $client = self::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Sign in', [
            'username' => 'adrien',
            'password' => 'foobar',
        ]);

        $client->request('GET', '/admin');
        static::assertResponseIsSuccessful();
    }

    public function testItRedirectsToTheAdminPageWhenGivenTheRightCredentials()
    {

        $client = self::createClient();
        $client->request('GET', '/login');
        $client->submitForm('Sign in', [
            'username' => 'adrien',
            'password' => 'foobar',
        ]);

        static::assertResponseRedirects('/admin');

        $client->followRedirect();

        static::assertResponseIsSuccessful();
    }
}
