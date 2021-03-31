<?php

namespace App\Entity;

use App\Repository\RepresentantCliniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RepresentantCliniqueRepository::class)
 */
class RepresentantClinique
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cin;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="representantClinique")
     */
    private $ic1;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $id1;

    public function __construct()
    {
        $this->ic1 = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getIc1(): Collection
    {
        return $this->ic1;
    }

    public function addIc1(user $ic1): self
    {
        if (!$this->ic1->contains($ic1)) {
            $this->ic1[] = $ic1;
            $ic1->setRepresentantClinique($this);
        }

        return $this;
    }

    public function removeIc1(user $ic1): self
    {
        if ($this->ic1->removeElement($ic1)) {
            // set the owning side to null (unless already changed)
            if ($ic1->getRepresentantClinique() === $this) {
                $ic1->setRepresentantClinique(null);
            }
        }

        return $this;
    }

    public function getId1(): ?user
    {
        return $this->id1;
    }

    public function setId1(?user $id1): self
    {
        $this->id1 = $id1;

        return $this;
    }
}
