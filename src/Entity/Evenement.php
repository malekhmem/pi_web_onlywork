<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="pk_foreigens", columns={"ids"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
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
    #[Assert\Length(max:30)]
    #[Assert\NotBlank (message:"veuillez saisir le titre ")]
    #[Groups("Evenement")]
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:200)]
    #[Assert\NotBlank (message:"veuillez saisir le description ")]
    #[Groups("Evenement")]
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nomss", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:30)]
    #[Assert\NotBlank (message:"veuillez saisir le nom ")]
    #[Groups("Evenement")]
    private $nomss;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="datee", type="date", nullable=true)
     */
    #[Assert\GreaterThanOrEqual ("today", message:"La date doit être aujourd'hui ou après.")]
    #[Groups("Evenement")]
    private $datee;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imagee", type="string", length=255, nullable=true)
     */
    #[Assert\NotBlank (message:"veuillez saisir le image ")]
    #[Groups("Evenement")]
    private $imagee;

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

    public function getDatee(): ?\DateTimeInterface
    {
        return $this->datee;
    }

    public function setDatee(?\DateTimeInterface $datee): self
    {
        $this->datee = $datee;

        return $this;
    }

    public function getImagee()
    {
        return $this->imagee;
    }

    public function setImagee( $imagee)
    {
        $this->imagee = $imagee;

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

    public function __construct()
    {
        $this->datee = new \DateTime('now');
    }

}
