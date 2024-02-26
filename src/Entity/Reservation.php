<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nbrtickets = null;

    #[ORM\Column]
    private ?int $iduser = null;

    #[ORM\Column(length: 255)]
    private ?string $paiement = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Voyage $Voyage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrtickets(): ?int
    {
        return $this->nbrtickets;
    }

    public function setNbrtickets(int $nbrtickets): static
    {
        $this->nbrtickets = $nbrtickets;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): static
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getPaiement(): ?string
    {
        return $this->paiement;
    }

    public function setPaiement(string $paiement): static
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getVoyage(): ?Voyage
    {
        return $this->Voyage;
    }

    public function setVoyage(?Voyage $Voyage): static
    {
        $this->Voyage = $Voyage;

        return $this;
    }
}
