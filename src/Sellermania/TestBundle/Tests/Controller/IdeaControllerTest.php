<?php

namespace Sellermania\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Sellermania\TestBundle\Tests\AbstractTestTools;
use Sellermania\TestBundle\Entity\Idea;
use Doctrine\ORM\Tools\SchemaTool;

class IdeaControllerTest extends AbstractTestTools
{
       

    public function setUp(){
        $em = $this->getContainer()->get('doctrine')->getManager();
        if (!isset($metadatas)) {
            $metadatas = $em->getMetadataFactory()->getAllMetadata();
        }
        $schemaTool = new SchemaTool($em);
        $schemaTool->dropDatabase();
        if (!empty($metadatas)) {
            $schemaTool->createSchema($metadatas);
        }
        $this->loadFixtures(['Sellermania\TestBundle\DataFixtures\ORM\LoadData']);
    }

    public function testCreate(){
        $client = $this->getLoggedinClient();
        $crawler = $client->request('GET', '/idea/new');
        $this->assertContains("Idea creation", $client->getResponse()->getContent());
        $button = $crawler->selectButton('Create');
        $form = $button->form();

        // set some values
        $form['sellermania_idea[title]'] = "Test Idea 2";
        $form['sellermania_idea[content]'] = "Content test idea 2 : Lorem Ipsum";
        $form['sellermania_idea[author]'] = "Test";

        $client->submit($form);
        $client->followRedirect();

        $this->defaultAsserts($client);

        $this->assertContains("Id", $client->getResponse()->getContent());

    }

    public function testEdit(){
        $client = $this->getLoggedinClient();
        $em = $client->getContainer()->get('doctrine')->getManager();
        $ideas = $em->getRepository('SellermaniaTestBundle:Idea')->findAll();
        $idea = $ideas[0];

        $crawler = $client->request('GET', 'idea/'.$idea->getId().'/edit');
        $this->assertContains("Idea edit", $client->getResponse()->getContent());
        $button = $crawler->selectButton('Edit');
        $form = $button->form();

        // set some values
        $form['sellermania_idea[content]'] = "Modified content test idea 1 : Lorem Ipsum";

        $client->submit($form);
        $client->followRedirect();

        $this->defaultAsserts($client);

        $this->assertContains("Id", $client->getResponse()->getContent());

    }

    public function testAddComment(){
        $client = $this->getLoggedinClient();
        $em = $client->getContainer()->get('doctrine')->getManager();
        $ideas = $em->getRepository('SellermaniaTestBundle:Idea')->findAll();
        $idea = $ideas[0];

        $crawler = $client->request('GET', 'idea/'.$idea->getId().'/add_comment');
        $this->assertContains("Add comment for idea", $client->getResponse()->getContent());
        $button = $crawler->selectButton('Create');
        $form = $button->form();

        // set some values
        $form['sellermania_comment[content]'] = "comment test : Lorem Ipsum";

        $client->submit($form);
        $client->followRedirect();

        $this->defaultAsserts($client);

        $this->assertContains("Id", $client->getResponse()->getContent());

    }

    public function testDelete(){
        $client = $this->getLoggedinClient();
        $em = $client->getContainer()->get('doctrine')->getManager();
        $ideas = $em->getRepository('SellermaniaTestBundle:Idea')->findAll();
        $idea = $ideas[0];

        $crawler = $client->request('GET', 'idea/'.$idea->getId().'/edit');
        $this->assertContains("Idea edit", $client->getResponse()->getContent());
        $button = $crawler->selectButton('Delete');
        $form = $button->form();
        $client->submit($form);
        $client->followRedirect();

        $this->defaultAsserts($client);

        $this->assertContains("Idea list", $client->getResponse()->getContent());
    }
}
