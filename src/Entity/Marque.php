<?php

namespace App\Entity;

use App\Repository\modeleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=modeleRepository::class)
 */
class Marque
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $concessionnaire;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $modele;

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

    public function getConcessionnaire(): ?string
    {
        return $this->concessionnaire;
    }

    public function setConcessionnaire(string $concessionnaire): self
    {
        $this->concessionnaire = $concessionnaire;

        return $this;
    }

    public function getmodele(): ?string
    {
        return $this->modele;
    }

    public function setmodele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }
}
