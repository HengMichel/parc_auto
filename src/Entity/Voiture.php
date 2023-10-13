<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $nb_km = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\OneToMany(mappedBy: 'voiture', targetEntity: Loueur::class)]
    private Collection $loueurs;

    public function __construct()
    {
        $this->loueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getNbKm(): ?int
    {
        return $this->nb_km;
    }

    public function setNbKm(int $nb_km): static
    {
        $this->nb_km = $nb_km;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection<int, Loueur>
     */
    public function getLoueurs(): Collection
    {
        return $this->loueurs;
    }

    public function addLoueur(Loueur $loueur): static
    {
        if (!$this->loueurs->contains($loueur)) {
            $this->loueurs->add($loueur);
            $loueur->setVoiture($this);
        }

        return $this;
    }

    public function removeLoueur(Loueur $loueur): static
    {
        if ($this->loueurs->removeElement($loueur)) {
            // set the owning side to null (unless already changed)
            if ($loueur->getVoiture() === $this) {
                $loueur->setVoiture(null);
            }
        }

        return $this;
    }
}
