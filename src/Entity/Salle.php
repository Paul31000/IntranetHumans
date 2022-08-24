<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\OccupationSalle;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=SalleRepository::class)
 */
class Salle
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
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\ManyToMany(targetEntity=OccupationSalle::class, inversedBy="salle")
     * 
     */
    private $occupationSalle;

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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }
    
    /**
     * @return Collection<int, OccupationSalle>
     */
    public function getOccupationSalle(): Collection
    {
        return $this->occupationSalle;
    }

    public function setOccupationSalle(?occupationSalle $occupationSalle): self
    {
        if (!$this->occupationSalle->contains($occupationSalle)) {
            $this->occupationSalle[] = $occupationSalle;
        }

        return $this;
    }

    public function  __toString(): string
    {
        return $this->getNom();
    }
}
