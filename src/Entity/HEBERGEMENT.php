<?php

namespace App\Entity;

use App\Repository\HEBERGEMENTRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HEBERGEMENTRepository::class)]
class HEBERGEMENT
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
