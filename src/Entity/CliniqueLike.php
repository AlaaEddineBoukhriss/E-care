<?php

namespace App\Entity;

use App\Repository\CliniqueLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CliniqueLikeRepository::class)
 */
class CliniqueLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Clinique::class, inversedBy="likes")
     */
    private $cliniquelike;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliniquelike(): ?Clinique
    {
        return $this->cliniquelike;
    }

    public function setCliniquelike(?Clinique $cliniquelike): self
    {
        $this->cliniquelike = $cliniquelike;

        return $this;
    }
}
