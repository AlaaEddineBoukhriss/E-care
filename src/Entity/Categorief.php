<?php

namespace App\Entity;

use App\Repository\CategoriefRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriefRepository::class)
 */
class Categorief
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
    private $descC;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescC(): ?string
    {
        return $this->descC;
    }

    public function setDescC(string $descC): self
    {
        $this->descC = $descC;

        return $this;
    }
    public function __toString() {
        return $this->descC;
    }
}
