<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type_livraison;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="paniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


    /**
     * @ORM\OneToMany(targetEntity=CartePanier::class, mappedBy="panier", orphanRemoval=true, cascade={"persist","remove"})
     */
    private $cartePaniers;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $etat;

    public function __construct()
    {
        $this->cartePaniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeLivraison(): ?string
    {
        return $this->type_livraison;
    }

    public function setTypeLivraison(string $type_livraison): self
    {
        $this->type_livraison = $type_livraison;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


    /**
     * @return Collection|CartePanier[]
     */
    public function getCartePaniers(): Collection
    {
        return $this->cartePaniers;
    }

    public function addCartePanier(CartePanier $cartePanier): self
    {
        if (!$this->cartePaniers->contains($cartePanier)) {
            $this->cartePaniers[] = $cartePanier;
            $cartePanier->setPanier($this);
        }

        return $this;
    }

    public function removeCartePanier(CartePanier $cartePanier): self
    {
        if ($this->cartePaniers->removeElement($cartePanier)) {
            // set the owning side to null (unless already changed)
            if ($cartePanier->getPanier() === $this) {
                $cartePanier->setPanier(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}



