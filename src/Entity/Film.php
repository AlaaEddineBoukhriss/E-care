<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity
 */
class Film
{
    /**
     * @var int
     *
     * @ORM\Column(name="idfilm", type="integer", nullable=false )
     * @ORM\Id
     * @Assert\NotBlank(message="Champ requis")
     */
    public $idfilm;

    /**
     * @var string
     * @Assert\NotBlank(message="Champ requis")
     * @ORM\Column(name="nomfilm", type="string", length=30, nullable=false)
     */
    private $nomFilm;

    /**
     * @var \DateTime
     *@Assert\NotBlank(message="Champ requis")
     * @ORM\Column(name="datesortie", type="date", nullable=false)
     */
    private $dateSortie;


    /**
     * @var ..\Categorief
     *
     * @ORM\OneToOne(targetEntity="Categorief")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id", referencedColumnName="id")
     * })
     */
    private $categorie;


    public function getIdFilm(): ?int
    {
        return $this->idfilm;
    }

    public function getNomFilm(): ?string
    {
        return $this->nomFilm;
    }

    public function setNomFilm(string $nomFilm): self
    {
        $this->nomFilm = $nomFilm;

        return $this;
    }

    public function getDateSortie(): ?DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    public function getCategorieFilm(): ?string
    {
        return $this->categorieFilm;
    }

    public function setCategorieFilm(string $categorieFilm): self
    {
        $this->categorieFilm = $categorieFilm;

        return $this;
    }
    public function __toString() {
        return $this->nomFilm;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie): void
    {
        $this->categorie = $categorie;
    }

}
