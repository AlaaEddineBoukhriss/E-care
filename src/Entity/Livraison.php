<?php

namespace App\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\PaimentRepository;
use Doctrine\ORM\Mapping as ORM;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PaimentRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
    /**
     * @Assert\NotBlank (message="please enter ur name")
     * * @Assert\Length(
     *     min="3",
     * max="20",
     * minMessage="Nom doit être composé de min 3 caractere",
     * maxMessage="Nom doit être composé de max 20 caractere"
     * )
     * @ORM\Column(type="string", length=8)
     */

    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
    /**
     * @Assert\NotBlank (message="please enter ur adress")
     * @Assert\Length(
     *     min="4",
     * max="15",
     * minMessage="Adresse doit être composé de min 4 caractere",
     * maxMessage="Adresse doit être composé de max 15 caractere"
     * )
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="please enter ur number")
     * @Assert\Length(
     *     min="8",
     * max="8",
     * minMessage="numero doit être composé de 8 chiffres",
     * maxMessage="numero doit être composé de 8 chiffres"
     * )
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="please enter ur mail")
     * @Assert\Length(
     *     min="9",
     * max="25",
     * minMessage="mail doit être composé de min 9 caracteres",
     * maxMessage="mail doit être composé de max 25 caracteres"
     * )

     */

    private $mail;


    // ... //
    protected $captchaCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="please enter ur message")
     * @Assert\Length(
     *     min="8",
     * max="20",
     * minMessage="message doit être composé de min 8 caracteres",
     * maxMessage="mail doit être composé de max 25 caracteres"
     * )


     */
    private $message;

    /**
     * @ORM\OneToOne(targetEntity=Panier::class, cascade={"persist", "remove"})
     */
    private $Commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCommande(): ?panier
    {
        return $this->Commande;
    }

    public function setCommande(?panier $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }
}
