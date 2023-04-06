<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="idu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idu;

    /**
     * @var string
     *
     * @ORM\Column(name="nomu", type="string", length=255, nullable=false)
     */
    private $nomu;

    /**
     * @var string
     *
     * @ORM\Column(name="mailu", type="string", length=255, nullable=false)
     */
    private $mailu;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false)
     */
    private $mdp;

    /**
     * @var int
     *
     * @ORM\Column(name="numerou", type="integer", nullable=false)
     */
    private $numerou;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     */
    private $role;

    public function getIdu(): ?int
    {
        return $this->idu;
    }

    public function getNomu(): ?string
    {
        return $this->nomu;
    }

    public function setNomu(string $nomu): self
    {
        $this->nomu = $nomu;

        return $this;
    }

    public function getMailu(): ?string
    {
        return $this->mailu;
    }

    public function setMailu(string $mailu): self
    {
        $this->mailu = $mailu;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNumerou(): ?int
    {
        return $this->numerou;
    }

    public function setNumerou(int $numerou): self
    {
        $this->numerou = $numerou;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }


}
