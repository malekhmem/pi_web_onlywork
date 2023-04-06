<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Blacklist
 *
 * @ORM\Table(name="blacklist")
 * @ORM\Entity
 */
class Blacklist
{
    /**
     * @var int
     *
     * @ORM\Column(name="idb", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idb;

    /**
     * @var string
     *
     * @ORM\Column(name="descb", type="text", length=65535, nullable=false)
     */
    private $descb;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrr", type="integer", nullable=false)
     */
    private $nbrr;

    public function getIdb(): ?int
    {
        return $this->idb;
    }

    public function getDescb(): ?string
    {
        return $this->descb;
    }

    public function setDescb(string $descb): self
    {
        $this->descb = $descb;

        return $this;
    }

    public function getNbrr(): ?int
    {
        return $this->nbrr;
    }

    public function setNbrr(int $nbrr): self
    {
        $this->nbrr = $nbrr;

        return $this;
    }


}
