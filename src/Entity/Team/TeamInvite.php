<?php

namespace App\Entity\Team;

use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Entity\User\User;
use App\Repository\Team\TeamInviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamInviteRepository::class)]
class TeamInvite
{
    use PrimaryKeyTrait;

    #[ORM\Column]
    private ?bool $active = null;


    /** Relations */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'teamInvites')]
    #[ORM\JoinColumn(name: 'invited_user_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?User $invitedUser = null;


    #[ORM\ManyToOne(targetEntity: Team::class, inversedBy: 'teamInvites')]
    #[ORM\JoinColumn(name: 'team_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?Team $team = null;


    #[ORM\ManyToOne(targetEntity: TeamMemberRole::class, inversedBy: 'teamInvites')]
    #[ORM\JoinColumn(name: 'team_member_role_id', referencedColumnName: "id", onDelete: "CASCADE")]
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

    public function getInvitedUser(): ?User
    {
        return $this->invitedUser;
    }

    public function setInvitedUser(?User $invitedUser): static
    {
        $this->invitedUser = $invitedUser;

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
