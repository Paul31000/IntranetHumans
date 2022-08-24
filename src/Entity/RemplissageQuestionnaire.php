<?php

namespace App\Entity;

use App\Repository\RemplissageQuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RemplissageQuestionnaireRepository::class)
 */
class RemplissageQuestionnaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Questionnaire::class,inversedBy="RemplissageQuestionnaire")
     */
    private $questionnaire;

    /**
     * @ORM\Column(type="text")
     */
    private $valeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pseudo;

    public function __construct()
    {
        //$this->questionnaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getQuestionnaire(): ?Questionnaire
    {
        return $this->questionnaire;
    }

    public function setQuestionnaire(?Questionnaire $questionnaire): self
    {
        $this->questionnaire = $questionnaire;

        return $this;
    }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function  __toString(): string
    {
        return $this->getPseudo();
    }
}
