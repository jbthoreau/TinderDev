<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'There is already an account with this name')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $name = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $mail = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'idAmi')]
    private Collection $ami;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'ami')]
    private Collection $idAmi;

    #[ORM\ManyToMany(targetEntity: langage::class, inversedBy: 'idLangage')]
    private Collection $langage;

    public function __construct()
    {
        $this->ami = new ArrayCollection();
        $this->idAmi = new ArrayCollection();
        $this->langage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->name;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return array
     */
    public function getMail(): array
    {
        return $this->mail;
    }

    /**
     * @param array $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return Collection<int, self>
     */
    public function getAmi(): Collection
    {
        return $this->ami;
    }

    public function addAmi(self $ami): self
    {
        if (!$this->ami->contains($ami)) {
            $this->ami->add($ami);
        }

        return $this;
    }

    public function removeAmi(self $ami): self
    {
        $this->ami->removeElement($ami);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getIdAmi(): Collection
    {
        return $this->idAmi;
    }

    public function addIdAmi(self $idAmi): self
    {
        if (!$this->idAmi->contains($idAmi)) {
            $this->idAmi->add($idAmi);
            $idAmi->addAmi($this);
        }

        return $this;
    }

    public function removeIdAmi(self $idAmi): self
    {
        if ($this->idAmi->removeElement($idAmi)) {
            $idAmi->removeAmi($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, langage>
     */
    public function getLangage(): Collection
    {
        return $this->langage;
    }

    public function addLangage(langage $langage): self
    {
        if (!$this->langage->contains($langage)) {
            $this->langage->add($langage);
        }

        return $this;
    }

    public function removeLangage(langage $langage): self
    {
        $this->langage->removeElement($langage);

        return $this;
    }
}
