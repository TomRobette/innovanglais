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
    private $nb_questions;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class, inversedBy="tests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbQuestions(): ?int
    {
        return $this->nb_questions;
    }

    public function setNbQuestions(int $nb_questions): self
    {
        $this->nb_questions = $nb_questions;

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
}
