<?php

namespace App\Entity;

use App\Repository\CliniqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CliniqueRepository::class)
 */
class Clinique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $nomcl;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $adressecl;

    /**
     *  @Assert\Length(
     *      min =8,
     *      max = 8,
     *      minMessage = "Votre numéro de téléphone ne contient pas {{ limit }} nombres",
     *      maxMessage = "Votre numéro ne doit pas dépasser  {{ limit }} nombres"
     * )
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $numerocl;

    /**
    
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs est obligatoire")
     */
    private $desccl;

    /**
     * @ORM\OneToMany(targetEntity=Medecin::class, mappedBy="clinique")
     */
    private $medecins;

    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="clinique")
     */
    private $patients;


    public function __construct()
    {
        $this->medecins = new ArrayCollection();
        $this->patients = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomcl(): ?string
    {
        return $this->nomcl;
    }

    public function setNomcl(string $nomcl): self
    {
        $this->nomcl = $nomcl;

        return $this;
    }

    public function getAdressecl(): ?string
    {
        return $this->adressecl;
    }

    public function setAdressecl(string $adressecl): self
    {
        $this->adressecl = $adressecl;

        return $this;
    }

    public function getNumerocl(): ?int
    {
        return $this->numerocl;
    }

    public function setNumerocl(int $numerocl): self
    {
        $this->numerocl = $numerocl;

        return $this;
    }

    public function getDesccl(): ?string
    {
        return $this->desccl;
    }

    public function setDesccl(string $desccl): self
    {
        $this->desccl = $desccl;

        return $this;
    }

    /**
     * @return Collection|Medecin[]
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(Medecin $medecin): self
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins[] = $medecin;
            $medecin->setClinique($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): self
    {
        if ($this->medecins->removeElement($medecin)) {
            // set the owning side to null (unless already changed)
            if ($medecin->getClinique() === $this) {
                $medecin->setClinique(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setClinique($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->removeElement($patient)) {
            // set the owning side to null (unless already changed)
            if ($patient->getClinique() === $this) {
                $patient->setClinique(null);
            }
        }

        return $this;
    }
    public function __toString() 
{
    try {
       return (string) $this->attributeToReturn; // If it is possible, return a string value from object.
    } catch (Exception $e) {
       return get_class($this).'@'.spl_object_hash($this); // If it is not possible, return a preset string to identify instance of object, e.g.
    }
}

}
