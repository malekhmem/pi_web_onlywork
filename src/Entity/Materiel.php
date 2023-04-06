<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel", indexes={@ORM\Index(name="fk_mat", columns={"idff"})})
 * @ORM\Entity
 */
class Materiel
{
    /**
     * @var int
     *
     * @ORM\Column(name="idm", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idm;

    /**
     * @var string
     *
     * @ORM\Column(name="nomm", type="string", length=255, nullable=false)
     */
    private $nomm;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="descrp", type="text", length=65535, nullable=false)
     */
    private $descrp;

    /**
     * @var \Annoncef
     *
     * @ORM\ManyToOne(targetEntity="Annoncef")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idff", referencedColumnName="idf")
     * })
     */
    private $idff;

    public function getIdm(): ?int
    {
        return $this->idm;
    }

    public function getNomm(): ?string
    {
        return $this->nomm;
    }

    public function setNomm(string $nomm): self
    {
        $this->nomm = $nomm;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescrp(): ?string
    {
        return $this->descrp;
    }

    public function setDescrp(string $descrp): self
    {
        $this->descrp = $descrp;

        return $this;
    }

    public function getIdff(): ?Annoncef
    {
        return $this->idff;
    }

    public function setIdff(?Annoncef $idff): self
    {
        $this->idff = $idff;

        return $this;
    }


}
