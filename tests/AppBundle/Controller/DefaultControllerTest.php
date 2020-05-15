<?php


namespace Tests\AppBundle\Controller;


use AppBundle\DataFixtures\ORM\LoadBasicParkData;
use AppBundle\DataFixtures\ORM\LoadSecurityData;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class DefaultControllerTest extends WebTestCase
{
    use FixturesTrait;
    public function testEnclosuresAreShownOnTheHomepage()
    {
        $client = $this->makeClient();

        $this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class
        ]);
        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $table = $crawler->filter('.table-enclosures');
        $this->assertCount(3, $table->filter('tbody tr'));
    }

    public function testThatThereIsAnAlarmButtonWithoutSecurity()
    {
        $client = $this->makeClient();

        $fixtures = $this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class
        ])->getReferenceRepository();

        $crawler = $client->request('GET', '/');

        $enclosure = $fixtures->getReference('carnivorous-enclosure');
        $selector = sprintf('#enclosure-%s .button-alarm', $enclosure->getId());

        $this->assertGreaterThan(0, $crawler->filter($selector)->count());
    }

    public function testItGrowsADinosaurFromSpecification()
    {
        $client = $this->makeClient();
        $client->followRedirects();

        $this->loadFixtures([
            LoadBasicParkData::class,
            LoadSecurityData::class
        ]);
        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('Grow dinosaur')->form();
        $form['enclosure']->select(3);
        $form['specification']->setValue('large herbivore');

        $client->submit($form);

        $this->assertStringContainsString(
            'Grew a large herbivore in enclosure #3',
            $client->getResponse()->getContent()
        );
    }
}