<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cinema
 *
 * @ORM\Table(name="cinema")
 * @ORM\Entity
 */
/**
 * @ORM\Entity
 * @UniqueEntity("num")
 */
class Cinema
{
    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=10, nullable=false)
     * @ORM\Id
     *
     */
    public $num;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heurep", type="time", nullable=false)
     */
    private $heurep;
    /**
     * @var ..\Film
     *
     * @ORM\ManyToOne(targetEntity="Film")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Film_id", referencedColumnName="idfilm")
     * })
     */
    private $film;

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeurep(): ?DateTimeInterface
    {
        return $this->heurep;
    }

    public function setHeurep(DateTimeInterface $heurep): self
    {
        $this->heurep = $heurep;

        return $this;
    }
    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): self
    {
        $this->film = $film;

        return $this;
    }

}
