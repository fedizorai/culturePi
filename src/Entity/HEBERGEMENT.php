<?php

namespace App\Entity;
use App\Repository\HEBERGEMENTRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HEBERGEMENTRepository::class)]
class HEBERGEMENT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_hebergement ;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide.")]
    #[Assert\Length(
        max: 20,
        maxMessage: "L'adresse ne peut pas dépasser {{ limit }} caractères.",
    )]
    private ?string $adresse = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Le type d'hébergement ne peut pas être vide.")]
    #[Assert\Choice(choices: ['Appartement', 'Maison', 'Studio', 'hotel'], message: 'Choisissez un type valide.')]
    private ?string $type = null;

    #[ORM\Column(type: Types::INTEGER)]
    #[Assert\NotBlank(message: "Le nombre de chambres ne peut pas être vide.")]
    #[Assert\PositiveOrZero(message: 'Le nombre de chambres doit être positif ou zéro.')]
    private ?int $nb_chambre = null;

    #[ORM\Column(type: Types::FLOAT)]
    #[Assert\NotBlank(message: "Le prix ne peut pas être vide.")]
    #[Assert\Positive(message: 'Le prix doit être positif.')]
    private ?float $prix = null;

    public function getId_hebergement(): ?int
    {
        return $this->id_hebergement;
    }
    public function setId_hebergement(int $id_hebergement): self
    {
        $this->id_hebergement = $id_hebergement;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getNbChambre(): ?int
    {
        return $this->nb_chambre;
    }

    public function setNbChambre(int $nb_chambre): self
    {
        $this->nb_chambre = $nb_chambre;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }
}
