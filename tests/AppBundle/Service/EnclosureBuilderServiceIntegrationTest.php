<?php


namespace Tests\AppBundle\Service;

use AppBundle\Service\EnclosureBuilderService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    public function testItBuildsEnclosureWithDefaultSpecs()
    {
        self::bootKernel();
        $enclosureBuilderService = self::$kernel->getContainer()
            ->get('test.' . EnclosureBuilderService::class);
    }
}