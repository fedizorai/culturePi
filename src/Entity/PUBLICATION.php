<?php

namespace App\Entity;

use App\Repository\PUBLICATIONRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PUBLICATIONRepository::class)]
class PUBLICATION
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CONTENUPUB = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DATEPUB = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message:"USERNAME cannot be empty")]
    private ?string $USERNAME = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"ID cannot be empty")]
    private ?int $USERID = null;

    #[ORM\OneToMany(mappedBy: 'pub', targetEntity: COMMENTAIRE::class)]
    private Collection $COMMENTAIRESLIST;

    #[ORM\OneToMany(mappedBy: 'PUB', targetEntity: COMMENTAIRE::class)]
    private Collection $LISTCOMMENTAIRE;

    public function __construct()
    {
        $this->COMMENTAIRESLIST = new ArrayCollection();
        $this->LISTCOMMENTAIRE = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCONTENUPUB(): ?string
    {
        return $this->CONTENUPUB;
    }

    public function setCONTENUPUB(string $CONTENUPUB): static
    {
        $this->CONTENUPUB = $CONTENUPUB;

        return $this;
        
    }
    

    public function getDATEPUB(): ?\DateTimeInterface
    {
        return $this->DATEPUB;
    }

    public function setDATEPUB(\DateTimeInterface $DATEPUB): static
    {
        $this->DATEPUB = $DATEPUB;

        return $this;
    }

    public function getUSERNAME(): ?string
    {
        return $this->USERNAME;
    }

    public function setUSERNAME(string $USERNAME): static
    {
        $this->USERNAME = $USERNAME;

        return $this;
    }

    public function getUSERID(): ?int
    {
        return $this->USERID;
    }

    public function setUSERID(int $USERID): static
    {
        $this->USERID = $USERID;

        return $this;
    }

    /**
     * @return Collection<int, COMMENTAIRE>
     */
    public function getCOMMENTAIRESLIST(): Collection
    {
        return $this->COMMENTAIRESLIST;
    }

    public function addCOMMENTAIRESLIST(COMMENTAIRE $cOMMENTAIRESLIST): static
    {
        if (!$this->COMMENTAIRESLIST->contains($cOMMENTAIRESLIST)) {
            $this->COMMENTAIRESLIST->add($cOMMENTAIRESLIST);
            $cOMMENTAIRESLIST->setPub($this);
        }

        return $this;
    }

    public function removeCOMMENTAIRESLIST(COMMENTAIRE $cOMMENTAIRESLIST): static
    {
        if ($this->COMMENTAIRESLIST->removeElement($cOMMENTAIRESLIST)) {
            // set the owning side to null (unless already changed)
            if ($cOMMENTAIRESLIST->getPub() === $this) {
                $cOMMENTAIRESLIST->setPub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, COMMENTAIRE>
     */
    public function getLISTCOMMENTAIRE(): Collection
    {
        return $this->LISTCOMMENTAIRE;
    }

    public function addLISTCOMMENTAIRE(COMMENTAIRE $lISTCOMMENTAIRE): static
    {
        if (!$this->LISTCOMMENTAIRE->contains($lISTCOMMENTAIRE)) {
            $this->LISTCOMMENTAIRE->add($lISTCOMMENTAIRE);
            $lISTCOMMENTAIRE->setPUB($this);
        }

        return $this;
    }

    public function removeLISTCOMMENTAIRE(COMMENTAIRE $lISTCOMMENTAIRE): static
    {
        if ($this->LISTCOMMENTAIRE->removeElement($lISTCOMMENTAIRE)) {
            // set the owning side to null (unless already changed)
            if ($lISTCOMMENTAIRE->getPUB() === $this) {
                $lISTCOMMENTAIRE->setPUB(null);
            }
        }

        return $this;
    }
    
    
    
}
