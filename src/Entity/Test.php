<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbQuestions;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="tests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Liste::class, inversedBy="tests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $liste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbQuestions(): ?int
    {
        return $this->nbQuestions;
    }

    public function setNbQuestions(int $nbQuestions): self
    {
        $this->nbQuestions = $nbQuestions;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveau $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getListe(): ?Liste
    {
        return $this->liste;
    }

    public function setListe(?Liste $liste): self
    {
        $this->liste = $liste;

        return $this;
    }
}
