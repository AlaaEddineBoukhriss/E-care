<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce Champ est obligatoire")
     */
    private $CodePanier;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce Champ est obligatoire")
     */
    private $Quantite;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="ce Champ est obligatoire")
     */
    private $Prix_Tot;


    /**
     * @ORM\ManyToMany(targetEntity=Produit::class, inversedBy="paniers")
     */
    private $Ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Produits;

    public function __construct()
    {
        $this->Ref = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePanier()
    {
        return $this->CodePanier;
    }


    public function setCodePanier($CodePanier): void
    {
        $this->CodePanier = $CodePanier;
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

    public function getPrixTot(): ?float
    {
        return $this->Prix_Tot;
    }

    public function setPrixTot(float $Prix_Tot): self
    {
        $this->Prix_Tot = $Prix_Tot;

        return $this;
    }

    public function getProduitID(): ?Produit
    {
        return $this->ProduitID;
    }

    public function setProduitID(?Produit $ProduitID): self
    {
        $this->ProduitID = $ProduitID;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getRef(): Collection
    {
        return $this->Ref;
    }

    public function addRef(Produit $ref): self
    {
        if (!$this->Ref->contains($ref)) {
            $this->Ref[] = $ref;
        }

        return $this;
    }

    public function removeRef(Produit $ref): self
    {
        $this->Ref->removeElement($ref);

        return $this;
    }

    public function getProduits(): ?string
    {
        return $this->Produits;
    }

    public function setProduits(string $Produits): self
    {
        $this->Produits = $Produits;

        return $this;
    }
}
