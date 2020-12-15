<?php

namespace App\Entity;

use App\Repository\ListeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ListeRepository::class)
 * @ApiResource();
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

    /**
     * @ORM\OneToMany(targetEntity=Test::class, mappedBy="liste")
     */
    private $tests;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function __construct()
    {
        $this->listeMots = new ArrayCollection();
        $this->tests = new ArrayCollection();
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

    /**
     * @return Collection|Test[]
     */
    public function getTests(): Collection
    {
        return $this->tests;
    }

    public function addTest(Test $test): self
    {
        if (!$this->tests->contains($test)) {
            $this->tests[] = $test;
            $test->setListe($this);
        }

        return $this;
    }

    public function removeTest(Test $test): self
    {
        if ($this->tests->removeElement($test)) {
            // set the owning side to null (unless already changed)
            if ($test->getListe() === $this) {
                $test->setListe(null);
            }
        }

        return $this;
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
}
