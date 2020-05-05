<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function testSettingLength()
    {
        $dinausaur = new Dinosaur();
        $this->assertSame(0, $dinausaur->getLength());

        $dinausaur->setLength(9);
        $this->assertSame(9, $dinausaur->getLength());
    }

    public function testReturnsFullSpecificationForTyrannosaurus()
    {
        $dinosaur = new Dinosaur();
        $this->assertSame(
            'The Unknown non-carnivorous dinosaur is 0 meters long',
            $dinosaur->getSpecification()
        );

        $dinosaur = new Dinosaur('Tyrannosaurus', true);

        $dinosaur->setLength(12);
        $this->assertSame(
            'The Tyrannosaurus carnivour dinosaur is 12 meters long',
            $dinosaur->getSpecification()
        );
    }
}