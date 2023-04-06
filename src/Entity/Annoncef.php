<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Annoncef
 *
 * @ORM\Table(name="annoncef", indexes={@ORM\Index(name="fk_ut", columns={"idu"})})
 * @ORM\Entity
 */
class Annoncef
{
    /**
     * @var int
     *
     * @ORM\Column(name="idf", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idf;

    /**
     * @var string
     *
     * @ORM\Column(name="nomf", type="string", length=255, nullable=false)
     */
    private $nomf;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="emailf", type="string", length=255, nullable=false)
     */
    private $emailf;

    /**
     * @var string
     *
     * @ORM\Column(name="descf", type="text", length=65535, nullable=false)
     */
    private $descf;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idu", referencedColumnName="id")
     * })
     */
    private $idu;

    public function getIdf(): ?int
    {
        return $this->idf;
    }

    public function getNomf(): ?string
    {
        return $this->nomf;
    }

    public function setNomf(string $nomf): self
    {
        $this->nomf = $nomf;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmailf(): ?string
    {
        return $this->emailf;
    }

    public function setEmailf(string $emailf): self
    {
        $this->emailf = $emailf;

        return $this;
    }

    public function getDescf(): ?string
    {
        return $this->descf;
    }

    public function setDescf(string $descf): self
    {
        $this->descf = $descf;

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


}
