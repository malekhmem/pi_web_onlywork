<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Annoncef
 *
 * @ORM\Table(name="annoncef", indexes={@ORM\Index(name="fk_ut", columns={"idu"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AnnoncefRepository")
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
    #[Assert\Length(min:2)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir le nom de l'annonce ")]
    private $nomf;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:3)]
    #[Assert\Length(max:30)]
    #[Assert\NotBlank (message:"veuillez saisir l'adresse de l'annonce ")]
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="emailf", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank (message:"veuillez saisir l'email ")]
    #[Assert\Email]
    private $emailf;

    /**
     * @var string
     *
     * @ORM\Column(name="descf", type="text", length=65535, nullable=false)
     */
    #[Assert\Length(min:10)]
    #[Assert\Length(max:200)]
    #[Assert\NotBlank (message:"veuillez saisir la description de l'annonce ")]
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
    
    public function __toString(): string
    {
        return $this->nomf;
    }

}
