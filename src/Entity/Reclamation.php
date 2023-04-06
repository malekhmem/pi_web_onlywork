<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="pk_foreigenb", columns={"idb"}), @ORM\Index(name="fk_utill", columns={"idu"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idr", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idr;

    /**
     * @var string
     *
     * @ORM\Column(name="descr", type="text", length=65535, nullable=false)
     */
    private $descr;

    /**
     * @var string
     *
     * @ORM\Column(name="nomr", type="string", length=255, nullable=false)
     */
    private $nomr;

    /**
     * @var string
     *
     * @ORM\Column(name="emailr", type="string", length=255, nullable=false)
     */
    private $emailr;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idu", referencedColumnName="id")
     * })
     */
    private $idu;

    /**
     * @var \Blacklist
     *
     * @ORM\ManyToOne(targetEntity="Blacklist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idb", referencedColumnName="idb")
     * })
     */
    private $idb;

    public function getIdr(): ?int
    {
        return $this->idr;
    }

    public function getDescr(): ?string
    {
        return $this->descr;
    }

    public function setDescr(string $descr): self
    {
        $this->descr = $descr;

        return $this;
    }

    public function getNomr(): ?string
    {
        return $this->nomr;
    }

    public function setNomr(string $nomr): self
    {
        $this->nomr = $nomr;

        return $this;
    }

    public function getEmailr(): ?string
    {
        return $this->emailr;
    }

    public function setEmailr(string $emailr): self
    {
        $this->emailr = $emailr;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIdu(): ?Utilisateur
    {
        return $this->idu;
    }

    public function setIdu(?Utilisateur $idu): self
    {
        $this->idu = $idu;

        return $this;
    }

    public function getIdb(): ?Blacklist
    {
        return $this->idb;
    }

    public function setIdb(?Blacklist $idb): self
    {
        $this->idb = $idb;

        return $this;
    }


}
