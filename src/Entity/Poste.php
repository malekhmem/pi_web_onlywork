<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Poste
 *
 * @ORM\Table(name="poste", indexes={@ORM\Index(name="fk_cat", columns={"idcc"}), @ORM\Index(name="fk_utilisateur", columns={"idu"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PosteRepository")
 */
class Poste
{
    /**
     * @var int
     *
     * @ORM\Column(name="idp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var string
     *
     * @ORM\Column(name="nomp", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:5)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir le nom du poste ")]
    private $nomp;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine", type="string", length=255, nullable=false)
     */
    #[Assert\Length(min:3)]
    #[Assert\Length(max:25)]
    #[Assert\NotBlank (message:"veuillez saisir le domaine")]

    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="descp", type="text", length=65535, nullable=false)
     */

     #[Assert\Length(min:5)]
    #[Assert\Length(max:200)]
    #[Assert\NotBlank (message:"veuillez saisir la description")]
    private $descp;

    /**
     * @var string
     *
     * @ORM\Column(name="emailp", type="string", length=255, nullable=false)
     */
    #[Assert\NotBlank (message:"veuillez saisir l'email ")]
    #[Assert\Email]

    private $emailp;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcc", referencedColumnName="idc")
     * })
     */
    private $idcc;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idu", referencedColumnName="id")
     * })
     */
    private $idu;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getNomp(): ?string
    {
        return $this->nomp;
    }

    public function setNomp(string $nomp): self
    {
        $this->nomp = $nomp;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getDescp(): ?string
    {
        return $this->descp;
    }

    public function setDescp(string $descp): self
    {
        $this->descp = $descp;

        return $this;
    }

    public function getEmailp(): ?string
    {
        return $this->emailp;
    }

    public function setEmailp(string $emailp): self
    {
        $this->emailp = $emailp;

        return $this;
    }

    public function getIdcc(): ?Categorie
    {
        return $this->idcc;
    }

    public function setIdcc(?Categorie $idcc): self
    {
        $this->idcc = $idcc;

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
