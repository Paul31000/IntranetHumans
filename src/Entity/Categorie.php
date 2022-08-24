<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\ManyToMany(targetEntity=LienPage::class, mappedBy="categorie")
     */
    private $lienPages;

    public function __construct()
    {
        $this->lienPages = new ArrayCollection();
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
     * @return Collection<int, LienPage>
     */
    public function getLienPages(): Collection
    {
        return $this->lienPages;
    }

    public function addLienPage(LienPage $lienPage): self
    {
        if (!$this->lienPages->contains($lienPage)) {
            $this->lienPages[] = $lienPage;
            $lienPage->addCategorie($this);
        }

        return $this;
    }

    public function removeLienPage(LienPage $lienPage): self
    {
        if ($this->lienPages->removeElement($lienPage)) {
            $lienPage->removeCategorie($this);
        }

        return $this;
    }

    public function  __toString(): string
    {
        return $this->getNom();
    }

}
