<?php


namespace Tests\AppBundle\Service;

use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Security;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();

        $this->truncateEntities();
    }


    public function testItBuildsEnclosureWithDefaultSpecs()
    {
        /** @var EnclosureBuilderService $enclosureBuilderService */
//        $enclosureBuilderService = self::$kernel->getContainer()
//            ->get('test.' . EnclosureBuilderService::class);

        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects($this->any())
        ->method('growFromSpecification')
        ->willReturnCallback(function ($spec) {
            return new Dinosaur();
        });

        $enclosureBuilderService = new EnclosureBuilderService(
            $this->getEntityManager(),
            $dinoFactory
        );

        $enclosureBuilderService->buildEnclosure();

        /** @var EntityManager $em */
        $em = $this->getEntityManager();

        $count = (int) $em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('Count(s.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(1, $count);

        $count = (int) $em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('Count(d.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(3, $count);
    }

    // just copy this method! :)
    private function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {

        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();


    }
}