<?php

namespace App\Entity;

use App\Repository\CongeRepository;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass=CongeRepository::class)
 */
class Conge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $debut;

    /**
     * @ORM\Column(type="date")
     */
    private $fin;

    /**
     * @ORM\ManyToOne(targetEntity=EmployeeInformation::class, inversedBy="conges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $employeInformation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(\DateTimeInterface $fin): self
    {
        if($this->getDebut()->getTimestamp()>$fin->getTimestamp()){
            throw new Exception("La date de fin est avant la date de début");
        }
        $this->fin = $fin;

        return $this;
    }

    public function getEmployeInformation(): ?EmployeeInformation
    {
        return $this->employeInformation;
    }

    public function setEmployeInformation(?EmployeeInformation $employeInformation): self
    {
        $this->employeInformation = $employeInformation;

        return $this;
    }
}
