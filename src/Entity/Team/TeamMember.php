<?php

namespace App\Entity\Team;

use App\Core\Services\DatabaseSchema;
use App\Core\Traits\Entity\DatetimeTrait;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Entity\User\User;
use App\Repository\Team\TeamMemberRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TeamMemberRepository::class)]
#[ORM\Table(name: 'team_members', schema: DatabaseSchema::TEAM)]
#[ORM\HasLifecycleCallbacks]
class TeamMember
{
    use PrimaryKeyTrait, DatetimeTrait;

    #[ORM\Column]
    private ?bool $active = null;


    /** Relations */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'teamMembers')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotBlank(message: "User must be selected")]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'teamMembers')]
    #[ORM\JoinColumn(name: 'team_id', referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotBlank(message: "Team must be selected")]
    private ?Team $team = null;


    #[ORM\ManyToOne(targetEntity: TeamMemberRole::class, inversedBy: 'teamMembers')]
    #[ORM\JoinColumn(name: 'team_member_role_id', referencedColumnName: "id", onDelete: "CASCADE")]
    #[Assert\NotBlank(message: "Team member role must be selected")]
    private ?TeamMemberRole $teamMemberRole = null;


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

    public function getTeamMemberRole(): ?TeamMemberRole
    {
        return $this->teamMemberRole;
    }

    public function setTeamMemberRole(?TeamMemberRole $teamMemberRole): static
    {
        $this->teamMemberRole = $teamMemberRole;

        return $this;
    }
}
