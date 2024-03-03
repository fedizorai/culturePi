<?php

namespace App\Entity;
use App\Repository\ReservhebergementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservhebergementRepository::class)]
class Reservhebergement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le nom d'utilisateur ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: "Le nom d'utilisateur doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom d'utilisateur ne peut pas dépasser {{ limit }} caractères."
    )]
    private ?string $username = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "L'identifiant de l'hébergement ne peut pas être vide.")]
    #[Assert\Positive(message: "L'identifiant de l'hébergement doit être un nombre positif.")]
    private ?int $id_hebergement = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nombre de personnes ne peut pas être vide.")]
    #[Assert\Positive(message: "Le nombre de personnes doit être un nombre positif.")]
    private ?int $nbr_personne = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "La durée ne peut pas être vide.")]
    #[Assert\Positive(message: "La durée doit être un nombre positif.")]
    private ?int $duree = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le type de paiement ne peut pas être vide.")]
    #[Assert\Choice(choices: ["carte", "espèce", "chèque"], message: "Veuillez choisir un type de paiement valide.")]
    private ?string $type_paiement = null;

    



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getIdHebergement(): ?int
    {
        return $this->id_hebergement;
    }

    public function setIdHebergement(int $id_hebergement): static
    {
        $this->id_hebergement = $id_hebergement;

        return $this;
    }

    public function getNbrPersonne(): ?int
    {
        return $this->nbr_personne;
    }

    public function setNbrPersonne(int $nbr_personne): static
    {
        $this->nbr_personne = $nbr_personne;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getTypePaiement(): ?string
    {
        return $this->type_paiement;
    }

    public function setTypePaiement(string $type_paiement): static
    {
        $this->type_paiement = $type_paiement;

        return $this;
    }
}
