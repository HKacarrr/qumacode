<?php

namespace App\Entity\Team;

use App\Core\Services\DatabaseSchema;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Repository\Team\TeamMemberRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamMemberRoleRepository::class)]
#[ORM\Table(name: 'team_member_roles', schema: DatabaseSchema::TEAM)]
class TeamMemberRole
{
    const TEAM_MEMBER_ROLES = [
        ['title' => 'Leader', 'alias' => 'leader', 'degree' => 1],
        ['title' => 'Manager', 'alias' => 'manager', 'degree' => 2],
        ['title' => 'Developer', 'alias' => 'developer', 'degree' => 3],
        ['title' => 'Designer', 'alias' => 'designer', 'degree' => 3],
        ['title' => 'Tester', 'alias' => 'tester', 'degree' => 3],
        ['title' => 'Support', 'alias' => 'support', 'degree' => 3]
    ];


    use PrimaryKeyTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    #[ORM\Column(length: 255)]
    private ?int $degree = null;


    /** Relations */
    #[ORM\OneToMany(targetEntity: TeamMember::class, mappedBy: 'teamMemberRole', cascade: ['persist', 'remove'])]
    private ?Collection $teamMembers;


    public function __construct()
    {
        $this->teamMembers = new ArrayCollection();
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
            $teamMember->setTeamMemberRole($this);
        }

        return $this;
    }

    public function removeTeamMember(TeamMember $teamMember): static
    {
        if ($this->teamMembers->removeElement($teamMember)) {
            // set the owning side to null (unless already changed)
            if ($teamMember->getTeamMemberRole() === $this) {
                $teamMember->setTeamMemberRole(null);
            }
        }

        return $this;
    }
}
