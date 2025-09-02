<?php

namespace App\Entity\Workspace;

use App\Core\Traits\Entity\DatetimeTrait;
use App\Core\Traits\Entity\DeleteAtTrait;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Entity\Team\Team;
use App\Entity\User\User;
use App\Repository\Workspace\WorkspaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceRepository::class)]
class Workspace
{
    use PrimaryKeyTrait, DatetimeTrait, DeleteAtTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\Column]
    private ?bool $active = null;



    /** Relations */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'workspaces')]
    #[ORM\JoinColumn(name: 'created_user_id', referencedColumnName: "id", onDelete: "SET NULL")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'workspaces')]
    #[ORM\JoinColumn(name: 'team_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Team $team = null;


    #[ORM\OneToMany(targetEntity: WorkspaceMember::class, mappedBy: 'workspace', cascade: ['persist', 'remove'])]
    private ?Collection $workspaceMembers;

    public function __construct()
    {
        $this->workspaceMembers = new ArrayCollection();
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

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
            $workspaceMember->setWorkspace($this);
        }

        return $this;
    }

    public function removeWorkspaceMember(WorkspaceMember $workspaceMember): static
    {
        if ($this->workspaceMembers->removeElement($workspaceMember)) {
            // set the owning side to null (unless already changed)
            if ($workspaceMember->getWorkspace() === $this) {
                $workspaceMember->setWorkspace(null);
            }
        }

        return $this;
    }
}
