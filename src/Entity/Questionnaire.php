<?php

namespace App\Entity;

use App\Repository\QuestionnaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionnaireRepository::class)
 */
class Questionnaire
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
    private $sujet;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomTechnique;

    /**
     * @ORM\OneToMany(targetEntity=Champ::class, mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    private $champs;

    /**
     * @ORM\OneToMany(targetEntity=RemplissageQuestionnaire::class, mappedBy="questionnaire", cascade={"persist", "remove"})
     */
    private $remplissageQuestionnaire;

    public function __construct()
    {
        $this->nomTechnique= uniqid();
        $this->champs = new ArrayCollection();
        $this->remplissageQuestionnaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getNomTechnique(): ?string
    {
        return $this->nomTechnique;
    }

    public function setNomTechnique(string $nomTechnique): self
    {
        $this->nomTechnique = $nomTechnique;

        return $this;
    }

    /**
     * @return Collection<int, Champ>
     */
    public function getChamps(): Collection
    {
        return $this->champs;
    }

    public function getChampsOrdered()
    {
        $champs=$this->getChamps()->getValues();
        usort($champs, array($this, "orderByInt"));
        return $champs;
    }

    public function addChamp(Champ $champ): self
    {
        if (!$this->champs->contains($champ)) {
            $this->champs[] = $champ;
            $champ->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeChamp(Champ $champ): self
    {
        if ($this->champs->removeElement($champ)) {
            // set the owning side to null (unless already changed)
            if ($champ->getQuestionnaire() === $this) {
                $champ->setQuestionnaire(null);
            }
        }

        return $this;
    }
        /**
     * @return Collection<int, remplissageQuestionnaire>
     */
    public function getRemplissages(): Collection
    {
        return $this->remplissageQuestionnaire;
    }

    public function addRemplissage(RemplissageQuestionnaire $remplissageQuestionnaire): self
    {
        if (!$this->remplissageQuestionnaire->contains($remplissageQuestionnaire)) {
            $this->remplissageQuestionnaire[] = $remplissageQuestionnaire;
            $remplissageQuestionnaire->setQuestionnaire($this);
        }

        return $this;
    }

    public function removeRemplissage(RemplissageQuestionnaire $remplissageQuestionnaire): self
    {
        if ($this->remplissageQuestionnaire->removeElement($remplissageQuestionnaire)) {
            // set the owning side to null (unless already changed)
            if ($remplissageQuestionnaire->getQuestionnaire() === $this) {
                $remplissageQuestionnaire->setQuestionnaire(null);
            }
        }

        return $this;
    }
    
    public function  __toString(): string
    {
        return $this->getSujet();
    }

    public function orderByInt($a, $b) {
        //retourner 0 en cas d'égalité
        if ($a->getOrdre() == $b->getOrdre()) {
            return 0;
        } else if ($a->getOrdre() < $b->getOrdre()) {//retourner -1 en cas d’infériorité
            return -1;
        } else {//retourner 1 en cas de supériorité
            return 1;
        }
    }
}
