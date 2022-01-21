<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
#[ApiResource(normalizationContext: ['groups' => ['client']]),]

class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    #[Groups("client")]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups("client")]
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups("client")]
    private $prenom;

    /**
     * @ORM\OneToOne(targetEntity=Modele::class, cascade={"persist", "remove"})
     */
    #[Groups("client")]
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getModele(): ?Modele
    {
        return $this->modele;
    }

    public function setModele(?Modele $modele): self
    {
        $this->modele = $modele;

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
