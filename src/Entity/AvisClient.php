<?php

namespace App\Entity;

use App\Repository\AvisClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisClientRepository::class)
 */
class AvisClient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity=Pharmacie::class, inversedBy="AvisClient")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idRclient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descR;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdRclient(): ?string
    {
        return $this->idRclient;
    }

    public function setIdRclient(string $idRclient): self
    {
        $this->idRclient = $idRclient;

        return $this;
    }

    public function getDescR(): ?string
    {
        return $this->descR;
    }

    public function setDescR(string $descR): self
    {
        $this->descR = $descR;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
