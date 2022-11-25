<?php

namespace App\Entity;

use App\Repository\LangageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangageRepository::class)]
class Langage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'langage')]
    private Collection $idLangage;

    public function __construct()
    {
        $this->idLangage = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getIdLangage(): Collection
    {
        return $this->idLangage;
    }

    public function addIdLangage(User $idLangage): self
    {
        if (!$this->idLangage->contains($idLangage)) {
            $this->idLangage->add($idLangage);
            $idLangage->addLangage($this);
        }

        return $this;
    }

    public function removeIdLangage(User $idLangage): self
    {
        if ($this->idLangage->removeElement($idLangage)) {
            $idLangage->removeLangage($this);
        }

        return $this;
    }
}
