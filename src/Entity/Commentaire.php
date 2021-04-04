<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
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
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min="1",
     * max="12",
     *      )
     */
    private $sujet;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     * min="1",
     * max="800",
     *      )
     */
    private $question;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $medecin;

    //...//
    private $captchaCode;

    /**
     * @ORM\OneToOne(targetEntity=Reponse::class, mappedBy="commentaire", cascade={"persist", "remove"})
     */
    private $reponse;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;

    }



    public function getMedecin(): ?string
    {
        return $this->medecin;
    }

    public function setMedecin(string $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode( $captchaCode)
    {
        $this->captchaCode = $captchaCode;

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        // unset the owning side of the relation if necessary
        if ($reponse === null && $this->reponse !== null) {
            $this->reponse->setCommentaire(null);
        }

        // set the owning side of the relation if necessary
        if ($reponse !== null && $reponse->getCommentaire() !== $this) {
            $reponse->setCommentaire($this);
        }

        $this->reponse = $reponse;

        return $this;
    }


}
