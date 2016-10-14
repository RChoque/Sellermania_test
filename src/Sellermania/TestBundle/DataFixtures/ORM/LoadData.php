<?php

namespace Sellermania\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sellermania\TestBundle\Entity\Idea;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Retrieve one random item of given class from ORM repository.
     *
     * @param string $class The class name to retrieve items from
     * @return object
     */
    private function _getRandomDoctrineItem($class)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $counter = (int) $em->createQuery(
            'SELECT COUNT(c) FROM '. $class .' c'
        )->getSingleScalarResult();
        if ($counter === 0) {
            return null;
        }
        return $em
            ->createQuery('SELECT c FROM ' . $class .' c ORDER BY c.id ASC')
            ->setMaxResults(1)
            ->setFirstResult(mt_rand(0, $counter - 1))
            ->getSingleResult()
            ;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=10; $i++) {
            $idea = new Idea();
            $idea->setTitle("Title Test ".$i);
            $idea->setContent("Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
            $idea->setAuthor("Rémi");
            
            $manager->persist($idea);
            $manager->flush();
        }   

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}