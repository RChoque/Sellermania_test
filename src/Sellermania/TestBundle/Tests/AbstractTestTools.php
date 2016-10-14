<?php

namespace Sellermania\TestBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;


class AbstractTestTools extends WebTestCase
{

    protected function getClient(){
        $client = static::createClient();
        return $client;
    }

    protected function getLoggedinClient(){
        $username = 'sellermania';
        $password = 'sellermania';

        $client = $this->getClient();
        $session = $client->getContainer()->get('session');
        $firewall = 'default';
        $token = new UsernamePasswordToken($username, $password, $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        return $client;
    }

    public function defaultAsserts($client){
        // Assert that the response status code is 2xx
        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}