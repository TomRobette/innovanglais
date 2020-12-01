<?php

namespace App\Entity;

use App\Repository\VocabulaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=VocabulaireRepository::class)
 * @ApiResource();
 */
class Vocabulaire
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
    private $mot;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="vocabulaires")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Langue::class, inversedBy="vocabulaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lang;

    /**
     * @ORM\ManyToMany(targetEntity=Liste::class, mappedBy="listeMots")
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

    public function getMot(): ?string
    {
        return $this->mot;
    }

    public function setMot(string $mot): self
    {
        $this->mot = $mot;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getLang(): ?Langue
    {
        return $this->lang;
    }

    public function setLang(?Langue $lang): self
    {
        $this->lang = $lang;

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
            $liste->addListeMot($this);
        }

        return $this;
    }

    public function removeListe(Liste $liste): self
    {
        if ($this->listes->removeElement($liste)) {
            $liste->removeListeMot($this);
        }

        return $this;
    }
}
