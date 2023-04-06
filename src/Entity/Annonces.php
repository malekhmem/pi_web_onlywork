<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonces
 *
 * @ORM\Table(name="annonces", indexes={@ORM\Index(name="fk_util", columns={"idu"})})
 * @ORM\Entity
 */
class Annonces
{
    /**
     * @var int
     *
     * @ORM\Column(name="ids", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ids;

    /**
     * @var string
     *
     * @ORM\Column(name="noms", type="string", length=255, nullable=false)
     */
    private $noms;

    /**
     * @var string
     *
     * @ORM\Column(name="emails", type="string", length=255, nullable=false)
     */
    private $emails;

    /**
     * @var int
     *
     * @ORM\Column(name="numeros", type="integer", nullable=false)
     */
    private $numeros;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresses", type="string", length=255, nullable=true)
     */
    private $adresses;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idu", referencedColumnName="id")
     * })
     */
    private $idu;

    public function getIds(): ?int
    {
        return $this->ids;
    }

    public function getNoms(): ?string
    {
        return $this->noms;
    }

    public function setNoms(string $noms): self
    {
        $this->noms = $noms;

        return $this;
    }

    public function getEmails(): ?string
    {
        return $this->emails;
    }

    public function setEmails(string $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    public function getNumeros(): ?int
    {
        return $this->numeros;
    }

    public function setNumeros(int $numeros): self
    {
        $this->numeros = $numeros;

        return $this;
    }

    public function getAdresses(): ?string
    {
        return $this->adresses;
    }

    public function setAdresses(?string $adresses): self
    {
        $this->adresses = $adresses;

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
