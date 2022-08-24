<?php

namespace App\Entity;

use App\Repository\OccupationSalleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;

/**
 * @ORM\Entity(repositoryClass=OccupationSalleRepository::class)
 */
class OccupationSalle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creneau;

    /**
     * @ORM\Column(type="datetime")
     */
    private $finCreneau; 


    /**
     * @ORM\ManyToMany(targetEntity=Salle::class, mappedBy="occupationSalle")
     */
    private $salle;

    /**
     * @ORM\ManyToOne(targetEntity=EmployeeInformation::class, inversedBy="occupationSalles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employeOccupant;

    public function __construct()
    {
        $this->salle = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreneau(): ?\DateTimeInterface
    {
        return $this->creneau;
    }

    public function setCreneau(\DateTimeInterface $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }
    public function getFinCreneau(): ?\DateTimeInterface
    {
        return $this->finCreneau;
    }

    public function setFinCreneau(\DateTimeInterface $creneau): self
    {
        if($this->getCreneau()->getTimestamp()>$creneau->getTimestamp()){
            throw new Exception("La date de fin est avant la date de début");
        }
        $this->finCreneau = $creneau;

        return $this;
    }


    public function getSalle(): Collection
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        if (!$this->salle->contains($salle)) {
            $this->salle[] = $salle;
        }

        return $this;
    }

    public function getEmployeOccupant(): ?EmployeeInformation
    {
        return $this->employeOccupant;
    }

    public function setEmployeOccupant(?EmployeeInformation $employeOccupant): self
    {
        $this->employeOccupant = $employeOccupant;

        return $this;
    }
}
