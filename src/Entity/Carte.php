<?php

namespace App\Entity;

use App\Repository\CarteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarteRepository::class)
 */
class Carte
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $attribut;

    /**
     * @ORM\Column(type="integer")
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $archetype;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $rarete;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Set::class, inversedBy="cartes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $set_id;

    /**
     * @ORM\OneToMany(targetEntity=CartePanier::class, mappedBy="cartes", orphanRemoval=true)
     */
    private $cartePaniers;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $libelle;

    public function __construct()
    {
        $this->cartePaniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getAttribut(): ?string
    {
        return $this->attribut;
    }

    public function setAttribut(string $attribut): self
    {
        $this->attribut = $attribut;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getArchetype(): ?string
    {
        return $this->archetype;
    }

    public function setArchetype(string $archetype): self
    {
        $this->archetype = $archetype;

        return $this;
    }

    public function getRarete(): ?string
    {
        return $this->rarete;
    }

    public function setRarete(string $rarete): self
    {
        $this->rarete = $rarete;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

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

    public function getSetId(): ?Set
    {
        return $this->set_id;
    }

    public function setSetId(?Set $set_id): self
    {
        $this->set_id = $set_id;

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
            $cartePanier->setCartes($this);
        }

        return $this;
    }

    public function removeCartePanier(CartePanier $cartePanier): self
    {
        if ($this->cartePaniers->removeElement($cartePanier)) {
            // set the owning side to null (unless already changed)
            if ($cartePanier->getCartes() === $this) {
                $cartePanier->setCartes(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }
}
