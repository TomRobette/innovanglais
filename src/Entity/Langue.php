<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=LangueRepository::class)
 * @ApiResource();
 */
class Langue
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
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Vocabulaire::class, mappedBy="lang")
     */
    private $vocabulaires;

    public function __construct()
    {
        $this->vocabulaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Vocabulaire[]
     */
    public function getVocabulaires(): Collection
    {
        return $this->vocabulaires;
    }

    public function addVocabulaire(Vocabulaire $vocabulaire): self
    {
        if (!$this->vocabulaires->contains($vocabulaire)) {
            $this->vocabulaires[] = $vocabulaire;
            $vocabulaire->setLang($this);
        }

        return $this;
    }

    public function removeVocabulaire(Vocabulaire $vocabulaire): self
    {
        if ($this->vocabulaires->removeElement($vocabulaire)) {
            // set the owning side to null (unless already changed)
            if ($vocabulaire->getLang() === $this) {
                $vocabulaire->setLang(null);
            }
        }

        return $this;
    }
}
