<?php

namespace App\Entity;

use App\Repository\COMMENTAIRERepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: COMMENTAIRERepository::class)]
class COMMENTAIRE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CONTENUCOM = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATECOM = null;

    #[ORM\Column(length: 20)]
    private ?string $NAME = null;

    #[ORM\Column]
    private ?int $PUBID = null;

    #[ORM\ManyToOne(inversedBy: 'COMMENTAIRESLIST')]
    private ?PUBLICATION $pub = null;

    #[ORM\ManyToOne(inversedBy: 'LISTCOMMENTAIRE')]
    private ?PUBLICATION $PUB = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCONTENUCOM(): ?string
    {
        return $this->CONTENUCOM;
    }

    public function setCONTENUCOM(string $CONTENUCOM): static
    {
        $this->CONTENUCOM = $CONTENUCOM;

        return $this;
    }

    public function getDATECOM(): ?\DateTimeInterface
    {
        return $this->DATECOM;
    }

    public function setDATECOM(\DateTimeInterface $DATECOM): static
    {
        $this->DATECOM = $DATECOM;

        return $this;
    }

    public function getNAME(): ?string
    {
        return $this->NAME;
    }

    public function setNAME(string $NAME): static
    {
        $this->NAME = $NAME;

        return $this;
    }

    public function getPUBID(): ?int
    {
        return $this->PUBID;
    }

    public function setPUBID(int $PUBID): static
    {
        $this->PUBID = $PUBID;

        return $this;
    }

    public function getPub(): ?PUBLICATION
    {
        return $this->pub;
    }

    public function setPub(?PUBLICATION $pub): static
    {
        $this->pub = $pub;

        return $this;
    }
}
