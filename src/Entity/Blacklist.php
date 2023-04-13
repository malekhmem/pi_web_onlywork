<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[Assert\Length(min:10)]
    #[Assert\Length(max:200)]
    #[Assert\NotBlank (message:"veuillez saisir la description du reclamation ")]
    private $descb;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrr", type="integer", nullable=false)
     */
    #[Assert\Length(min:1)]
    #[Assert\Length(max:2)]
    #[Assert\NotBlank (message:"veuillez saisir le numero des reclamation ")]
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
    public function __toString(): string
    {
        return  $this->descb;
        return $this->nbrr;
    }

}
