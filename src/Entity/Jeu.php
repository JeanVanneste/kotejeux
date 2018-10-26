<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Editeur;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JeuRepository")
 */
class Jeu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editeur", inversedBy="jeux")
     * @ORM\JoinColumn(nullable=false)
     */
    private $editeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $gameDuration;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $playerMax;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $boxPicture;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $interiorPicture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEditeur(): ?editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getGameDuration(): ?int
    {
        return $this->gameDuration;
    }

    public function setGameDuration(?int $gameDuration): self
    {
        $this->gameDuration = $gameDuration;

        return $this;
    }

    public function getPlayerMin(): ?int
    {
        return $this->playerMin;
    }

    public function setPlayerMin(int $playerMin): self
    {
        $this->playerMin = $playerMin;

        return $this;
    }

    public function getPlayerMax(): ?int
    {
        return $this->playerMax;
    }

    public function setPlayerMax(int $playerMax): self
    {
        $this->playerMax = $playerMax;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBoxPicture(): ?string
    {
        return $this->boxPicture;
    }

    public function setBoxPicture(?string $boxPicture): self
    {
        $this->boxPicture = $boxPicture;

        return $this;
    }

    public function getInteriorPicture(): ?string
    {
        return $this->interiorPicture;
    }

    public function setInteriorPicture(?string $interiorPicture): self
    {
        $this->interiorPicture = $interiorPicture;

        return $this;
    }
}
