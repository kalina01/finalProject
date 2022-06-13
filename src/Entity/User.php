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
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[ORM\ManyToOne(targetEntity: Group::class, inversedBy: 'students')]
    private $groupStudent;

    #[ORM\ManyToMany(targetEntity: Subject::class, mappedBy: 'teachers')]
    private $subjectsTeacher;

    public function __construct()
    {
        $this->subjectsTeacher = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function isAdmin()
    {
        return in_array('ROLE_ADMIN', $this->roles);
    }

    public function isStudent()
    {
        return in_array('ROLE_STUDENT', $this->roles);
    }

    public function isTeacher()
    {
        return in_array('ROLE_TEACHER', $this->roles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGroupStudent(): ?Group
    {
        return $this->groupStudent;
    }

    public function setGroupStudent(?Group $groupStudent): self
    {
        $this->groupStudent = $groupStudent;

        return $this;
    }

    /**
     * @return Collection<int, Subject>
     */
    public function getSubjectsTeacher(): Collection
    {
        return $this->subjectsTeacher;
    }

    public function addSubjectsTeacher(Subject $subjectsTeacher): self
    {
        if (!$this->subjectsTeacher->contains($subjectsTeacher)) {
            $this->subjectsTeacher[] = $subjectsTeacher;
            $subjectsTeacher->addTeacher($this);
        }

        return $this;
    }

    public function removeSubjectsTeacher(Subject $subjectsTeacher): self
    {
        if ($this->subjectsTeacher->removeElement($subjectsTeacher)) {
            $subjectsTeacher->removeTeacher($this);
        }

        return $this;
    }
}
