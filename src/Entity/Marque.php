<?php

namespace App\Entity;

use App\Repository\MarqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarqueRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Concessionnaire::class, mappedBy="marques")
     */
    private $concessionnaires;

    /**
     * @ORM\OneToMany(targetEntity=Modele::class, mappedBy="marque")
     */
    private $modeles;

    public function __construct()
    {
        $this->concessionnaires = new ArrayCollection();
        // $this->modeles = new ArrayCollection();
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
     * @return Collection|Concessionnaire[]
     */
    public function getConcessionnaires(): Collection
    {
        return $this->concessionnaires;
    }

    public function addConcessionnaire(Concessionnaire $concessionnaire): self
    {
        if (!$this->concessionnaires->contains($concessionnaire)) {
            $this->concessionnaires[] = $concessionnaire;
            $concessionnaire->addMarque($this);
        }

        return $this;
    }

    public function removeConcessionnaire(Concessionnaire $concessionnaire): self
    {
        if ($this->concessionnaires->removeElement($concessionnaire)) {
            $concessionnaire->removeMarque($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * @return Collection|Modele[]
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    public function addModele(Modele $modele): self
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles[] = $modele;
            $modele->setMarque($this);
        }

        return $this;
    }

    public function removeModele(Modele $modele): self
    {
        if ($this->modeles->removeElement($modele)) {
            // set the owning side to null (unless already changed)
            if ($modele->getMarque() === $this) {
                $modele->setMarque(null);
            }
        }

        return $this;
    }



}
