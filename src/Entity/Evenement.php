<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="pk_foreigens", columns={"ids"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ide", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ide;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir le titre de l'evenement ")]
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:255)]
    #[Assert\NotBlank (message:"veuillez saisir la description de l'evenement ")]
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nomss", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de l'annonce ")]
    private $nomss;

    /**
     * @var \Annonces
     *
     * @ORM\ManyToOne(targetEntity="Annonces")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ids", referencedColumnName="ids")
     * })
     */
    private $ids;

    public function getIde(): ?int
    {
        return $this->ide;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNomss(): ?string
    {
        return $this->nomss;
    }

    public function setNomss(string $nomss): self
    {
        $this->nomss = $nomss;

        return $this;
    }

    public function getIds(): ?Annonces
    {
        return $this->ids;
    }

    public function setIds(?Annonces $ids): self
    {
        $this->ids = $ids;

        return $this;
    }


}
