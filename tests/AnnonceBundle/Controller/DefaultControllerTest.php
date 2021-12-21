<?php

namespace AnnonceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
	/**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

     /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }

    public function ModifierTrajetTest()
    { 
    	$trajet = new Trajet();
    	$pays_depart ='Tunis';
    	$pays_destinataire ='Béja';
    	$trajet->setPaysDepart($pays_depart);
    	$trajet->setPaysDestination($pays_destinataire);
        $this->em->flush();
        $this->assertEquals($pays_depart,$trajet->getPaysDepart());
    }
    public function Modifier1TrajetAction()
    { 
    	$trajet = new Trajet();
    	$pays_depart ='Tunis';
    	$pays_destinataire ='Béja';
    	$trajet->setPaysDepart($pays_depart);
    	$trajet->setPaysDestination($pays_destinataire);
        $this->em->flush();
        $this->assertEquals($pays_depart,$trajet->getPaysDepart());
    }

     /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
