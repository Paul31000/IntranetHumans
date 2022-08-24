<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     */
    private $publierJusqua;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPublierJusqua(): ?\DateTimeInterface
    {
        return $this->publierJusqua;
    }

    public function setPublierJusqua(\DateTimeInterface $publierJusqua): self
    {
        $this->publierJusqua = $publierJusqua;

        return $this;
    }
}
