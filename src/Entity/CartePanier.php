<?php

namespace App\Entity;

use App\Repository\CartePanierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartePanierRepository::class)
 */
class CartePanier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Panier::class, inversedBy="cartePaniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $panier;

    /**
     * @ORM\ManyToOne(targetEntity=Carte::class, inversedBy="cartePaniers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cartes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        $this->panier = $panier;

        return $this;
    }

    public function getCartes(): ?Carte
    {
        return $this->cartes;
    }

    public function setCartes(?Carte $cartes): self
    {
        $this->cartes = $cartes;

        return $this;
    }
}
