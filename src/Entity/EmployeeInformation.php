<?php

namespace App\Entity;

use App\Repository\EmployeeInformationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeInformationRepository::class)
 */
class EmployeeInformation
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
    private $prenom;

    
    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleur_css;

    /**
     * @ORM\OneToMany(targetEntity=Conge::class, mappedBy="employeInformation")
     */
    private $conges;

    /**
     * @ORM\OneToMany(targetEntity=OccupationSalle::class, mappedBy="EmployeOccupant", orphanRemoval=true)
     */
    private $occupationSalles;

    public function __construct()
    {
        $this->conges = new ArrayCollection();
        $this->occupationSalles = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getCouleurCss(): ?string
    {
        return $this->couleur_css;
    }

    public function setCouleurCss(?string $couleur_css): self
    {
        $this->couleur_css = $couleur_css;

        return $this;
    }

    /**
     * @return Collection<int, Conge>
     */
    public function getConges(): Collection
    {
        return $this->conges;
    }

    public function addConge(Conge $conge): self
    {
        if (!$this->conges->contains($conge)) {
            $this->conges[] = $conge;
            $conge->setEmployeInformation($this);
        }

        return $this;
    }

    public function removeConge(Conge $conge): self
    {
        if ($this->conges->removeElement($conge)) {
            // set the owning side to null (unless already changed)
            if ($conge->getEmployeInformation() === $this) {
                $conge->setEmployeInformation(null);
            }
        }

        return $this;
    }

    public function  __toString(): string
    {
        return $this->getNom()."_".$this->getPrenom();
    }

    /**
     * @return Collection<int, OccupationSalle>
     */
    public function getOccupationSalles(): Collection
    {
        return $this->occupationSalles;
    }

    public function addOccupationSalle(OccupationSalle $occupationSalle): self
    {
        if (!$this->occupationSalles->contains($occupationSalle)) {
            $this->occupationSalles[] = $occupationSalle;
            $occupationSalle->setEmployeOccupant($this);
        }

        return $this;
    }

    public function removeOccupationSalle(OccupationSalle $occupationSalle): self
    {
        if ($this->occupationSalles->removeElement($occupationSalle)) {
            // set the owning side to null (unless already changed)
            if ($occupationSalle->getEmployeOccupant() === $this) {
                $occupationSalle->setEmployeOccupant(null);
            }
        }

        return $this;
    }
}
