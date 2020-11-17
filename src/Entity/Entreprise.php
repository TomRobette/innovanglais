<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $raisonSociale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adrVille;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adrCp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adrRue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adrNo;

    /**
     * @ORM\OneToMany(targetEntity=Liste::class, mappedBy="idEntreprise")
     */
    private $listes;

    public function __construct()
    {
        $this->listes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    public function getAdrVille(): ?string
    {
        return $this->adrVille;
    }

    public function setAdrVille(string $adrVille): self
    {
        $this->adrVille = $adrVille;

        return $this;
    }

    public function getAdrCp(): ?string
    {
        return $this->adrCp;
    }

    public function setAdrCp(string $adrCp): self
    {
        $this->adrCp = $adrCp;

        return $this;
    }

    public function getAdrRue(): ?string
    {
        return $this->adrRue;
    }

    public function setAdrRue(string $adrRue): self
    {
        $this->adrRue = $adrRue;

        return $this;
    }

    public function getAdrNo(): ?string
    {
        return $this->adrNo;
    }

    public function setAdrNo(string $adrNo): self
    {
        $this->adrNo = $adrNo;

        return $this;
    }

    /**
     * @return Collection|Liste[]
     */
    public function getListes(): Collection
    {
        return $this->listes;
    }

    public function addListe(Liste $liste): self
    {
        if (!$this->listes->contains($liste)) {
            $this->listes[] = $liste;
            $liste->setIdEntreprise($this);
        }

        return $this;
    }

    public function removeListe(Liste $liste): self
    {
        if ($this->listes->removeElement($liste)) {
            // set the owning side to null (unless already changed)
            if ($liste->getIdEntreprise() === $this) {
                $liste->setIdEntreprise(null);
            }
        }

        return $this;
    }
}
