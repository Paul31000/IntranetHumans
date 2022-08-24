<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page
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
    private $Image;

    /**
     * @ORM\ManyToMany(targetEntity=LienPage::class, inversedBy="pages" , cascade={"persist"})
     */
    private $liens;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomUrl;

    public function __construct()
    {
        $this->liens = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    /**
     * @return Collection<int, LienPage>
     */
    public function getLiens(): Collection
    {
        return $this->liens;
    }

    public function addLien(LienPage $lien): self
    {
        if (!$this->liens->contains($lien)) {
            $this->liens[] = $lien;
        }

        return $this;
    }

    public function removeLien(LienPage $lien): self
    {
        $this->liens->removeElement($lien);

        return $this;
    }
    
    public function  __toString(): string
    {
        return $this->getNom();
    }

    public function getNomUrl(): ?string
    {
        return $this->nomUrl;
    }

    public function setNomUrl(string $nomUrl): self
    {
        $this->nomUrl = $nomUrl;

        return $this;
    }
}
