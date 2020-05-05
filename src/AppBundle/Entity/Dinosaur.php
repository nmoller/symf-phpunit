<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dinosaurs")
 */
class Dinosaur
{

    const LARGE = 20;

    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCarnivour = false;

    /**
     * @ORM\Column(type="string")
     */
    private $genus = 'Unknown';

    public function __construct(string $genus = 'Unknown', bool $isCarnivour = false)
    {
        $this->genus = $genus;
        $this->isCarnivour = $isCarnivour;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length)
    {
        $this->length = $length;
        return $this;
    }

    public function getSpecification()
    {
        return sprintf(
            'The %s %s dinosaur is %d meters long',
            $this->genus,
            $this->isCarnivour? 'carnivour':'non-carnivorous',
            $this->length
        );
    }

    public function getGenus(): string
    {
        return $this->genus;
    }
}
