<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
 
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Type(type={"alpha", "digit"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type(type="float")
     */
    private $price;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Attention ce fichier doit être une image ou un PDF.")
     * @Assert\File(mimeTypes={ "application/pdf", "image/jpeg", "image/png", "image/gif" })
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Store::class, inversedBy="products")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     */
    private $store;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
}
