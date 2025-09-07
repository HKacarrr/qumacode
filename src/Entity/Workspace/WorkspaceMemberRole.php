<?php

namespace App\Entity\Workspace;

use App\Core\Services\DatabaseSchema;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Repository\Workspace\WorkspaceMemberRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkspaceMemberRoleRepository::class)]
#[ORM\Table(name: '`workspace_member_roles`', schema: DatabaseSchema::WORKSPACE)]
class WorkspaceMemberRole
{
    use PrimaryKeyTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    #[ORM\Column]
    private ?int $degree = null;


    /** Relations */
    #[ORM\OneToMany(targetEntity: WorkspaceMember::class, mappedBy: 'workspaceMemberRole', cascade: ['persist', 'remove'])]
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function getDegree(): ?int
    {
        return $this->degree;
    }

    public function setDegree(int $degree): static
    {
        $this->degree = $degree;

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
            $workspaceMember->setWorkspaceMemberRole($this);
        }

        return $this;
    }

    public function removeWorkspaceMember(WorkspaceMember $workspaceMember): static
    {
        if ($this->workspaceMembers->removeElement($workspaceMember)) {
            // set the owning side to null (unless already changed)
            if ($workspaceMember->getWorkspaceMemberRole() === $this) {
                $workspaceMember->setWorkspaceMemberRole(null);
            }
        }

        return $this;
    }
}
