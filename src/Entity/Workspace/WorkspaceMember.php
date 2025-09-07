<?php

namespace App\Entity\Workspace;

use App\Core\Services\DatabaseSchema;
use App\Core\Traits\Entity\DatetimeTrait;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Entity\User\User;
use App\Repository\Workspace\WorkspaceMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceMemberRepository::class)]
#[ORM\Table(name: '`workspace_members`', schema: DatabaseSchema::WORKSPACE)]
class WorkspaceMember
{
    use PrimaryKeyTrait, DatetimeTrait;

    #[ORM\Column]
    private ?bool $active = null;


    /** Relations */
    #[ORM\ManyToOne(targetEntity: Workspace::class, inversedBy: 'workspaceMembers')]
    #[ORM\JoinColumn(name: 'workspace_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Workspace $workspace = null;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'workspaceMembers')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?User $user = null;


    #[ORM\ManyToOne(targetEntity: WorkspaceMemberRole::class, inversedBy: 'workspaceMembers')]
    #[ORM\JoinColumn(name: 'workspace_member_role_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?WorkspaceMemberRole $workspaceMemberRole = null;


    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getWorkspace(): ?Workspace
    {
        return $this->workspace;
    }

    public function setWorkspace(?Workspace $workspace): static
    {
        $this->workspace = $workspace;

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

    public function getWorkspaceMemberRole(): ?WorkspaceMemberRole
    {
        return $this->workspaceMemberRole;
    }

    public function setWorkspaceMemberRole(?WorkspaceMemberRole $workspaceMemberRole): static
    {
        $this->workspaceMemberRole = $workspaceMemberRole;

        return $this;
    }
}
