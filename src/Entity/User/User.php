<?php

namespace App\Entity\User;

use App\Core\Services\DatabaseSchema;
use App\Core\Traits\Entity\DatetimeTrait;
use App\Core\Traits\Entity\DeleteAtTrait;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Entity\Team\Team;
use App\Entity\Team\TeamMember;
use App\Entity\Workspace\Workspace;
use App\Entity\Workspace\WorkspaceMember;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`', schema: DatabaseSchema::USER)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use PrimaryKeyTrait, DatetimeTrait, DeleteAtTrait;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    /** Relations */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Collection $teams;

    #[ORM\OneToMany(targetEntity: TeamMember::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Collection $teamMembers;

    #[ORM\OneToMany(targetEntity: Workspace::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Collection $workspaces;

    #[ORM\OneToMany(targetEntity: WorkspaceMember::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Collection $workspaceMembers;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->teamMembers = new ArrayCollection();
        $this->workspaces = new ArrayCollection();
        $this->workspaceMembers = new ArrayCollection();
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setUser($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getUser() === $this) {
                $team->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamMember>
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMembers;
    }

    public function addTeamMember(TeamMember $teamMember): static
    {
        if (!$this->teamMembers->contains($teamMember)) {
            $this->teamMembers->add($teamMember);
            $teamMember->setUser($this);
        }

        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): static
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getUser() === $this) {
                $teamMember->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Workspace>
     */
    public function getWorkspaces(): Collection
    {
        return $this->workspaces;
    }

    public function addWorkspace(Workspace $workspace): static
    {
        if (!$this->workspaces->contains($workspace)) {
            $this->workspaces->add($workspace);
            $workspace->setUser($this);
        }

        return $this;
    }

    public function removeWorkspace(Workspace $workspace): static
    {
        if ($this->workspaces->removeElement($workspace)) {
            // set the owning side to null (unless already changed)
            if ($workspace->getUser() === $this) {
                $workspace->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WorkspaceMember>
     */
    public function getWorkspaceMembers(): Collection
    {
        return $this->workspaceMembers;
    }

    public function addWorkspaceMember(WorkspaceMember $workspaceMember): static
    {
        if (!$this->workspaceMembers->contains($workspaceMember)) {
            $this->workspaceMembers->add($workspaceMember);
            $workspaceMember->setUser($this);
        }

        return $this;
    }

    public function removeWorkspaceMember(WorkspaceMember $workspaceMember): static
    {
        if ($this->workspaceMembers->removeElement($workspaceMember)) {
            // set the owning side to null (unless already changed)
            if ($workspaceMember->getUser() === $this) {
                $workspaceMember->setUser(null);
            }
        }

        return $this;
    }
}
