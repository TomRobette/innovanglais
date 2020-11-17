<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 */
class Liste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="listes")
     */
    private $idEntreprise;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class, inversedBy="listes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $theme;

    /**
     * @ORM\ManyToMany(targetEntity=Vocabulaire::class, inversedBy="listes")
     */
    private $listeMots;

    public function __construct()
    {
        $this->listeMots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEntreprise(): ?Entreprise
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(?Entreprise $idEntreprise): self
    {
        $this->idEntreprise = $idEntreprise;

        return $this;
    }

    public function getTheme(): ?Theme
    {
        return $this->theme;
    }

    public function setTheme(?Theme $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return Collection|Vocabulaire[]
     */
    public function getListeMots(): Collection
    {
        return $this->listeMots;
    }

    public function addListeMot(Vocabulaire $listeMot): self
    {
        if (!$this->listeMots->contains($listeMot)) {
            $this->listeMots[] = $listeMot;
        }

        return $this;
    }

    public function removeListeMot(Vocabulaire $listeMot): self
    {
        $this->listeMots->removeElement($listeMot);

        return $this;
    }
}
