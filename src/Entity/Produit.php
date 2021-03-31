<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
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
    private $prix;

    /**
     * @ORM\Column(type="integer")

     */
    private $Quantite;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Disponible;

    /**
     * @ORM\ManyToMany(targetEntity=Panier::class, mappedBy="Ref")
     */
    private $paniers;



    public function __construct()
    {
        $this->Ref = new ArrayCollection();
        $this->cartes = new ArrayCollection();
        $this->paniers = new ArrayCollection();
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->Quantite;
    }

    public function setQuantite(int $Quantite): self
    {
        $this->Quantite = $Quantite;

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getRef(): Collection
    {
        return $this->Ref;
    }

    public function addRef(Panier $ref): self
    {
        if (!$this->Ref->contains($ref)) {
            $this->Ref[] = $ref;
            $ref->setProduitID($this);
        }

        return $this;
    }

    public function removeRef(Panier $ref): self
    {
        if ($this->Ref->removeElement($ref)) {
            // set the owning side to null (unless already changed)
            if ($ref->getProduitID() === $this) {
                $ref->setProduitID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Carte[]
     */
    public function getCartes(): Collection
    {
        return $this->cartes;
    }

    public function addCarte(Carte $carte): self
    {
        if (!$this->cartes->contains($carte)) {
            $this->cartes[] = $carte;
            $carte->addQuantite($this);
        }

        return $this;
    }

    public function removeCarte(Carte $carte): self
    {
        if ($this->cartes->removeElement($carte)) {
            $carte->removeQuantite($this);
        }

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->Disponible;
    }

    public function setDisponible(?bool $Disponible): self
    {
        $this->Disponible = $Disponible;

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers[] = $panier;
            $panier->addRef($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            $panier->removeRef($this);
        }

        return $this;
    }
}
