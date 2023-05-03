<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert; 
/**
 * Materiel
 *
 * @ORM\Table(name="materiel", indexes={@ORM\Index(name="fk_mat", columns={"idff"}), @ORM\Index(name="fk_uu", columns={"idu"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\MaterielRepository")
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
    #[Assert\Length(min:2)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de materiel ")]
    private $nomm;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:2)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir la marque de l'annonce ")]
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:2)]
    #[Assert\Length(max:25)]
    #[Assert\Regex(pattern: '/^\d+$/', message: 'Le prix doit contenir uniquement des chiffres')]
    #[Assert\NotBlank (message:"veuillez saisir le prix")]
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="descm", type="text", length=65535, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:100)]
    #[Assert\NotBlank (message:"veuillez saisir la description ")]
    private $descm;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var \Annoncef
     *
     * @ORM\ManyToOne(targetEntity="Annoncef")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idff", referencedColumnName="idf")
     * })
     */
    private $idff;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idu", referencedColumnName="id")
     * })
     */
    private $idu;

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

    public function getDescm(): ?string
    {
        return $this->descm;
    }

    public function setDescm(string $descm): self
    {
        $this->descm = $descm;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
