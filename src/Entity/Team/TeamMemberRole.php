<?php

namespace App\Entity\Team;

use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Repository\Team\TeamMemberRoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamMemberRoleRepository::class)]
class TeamMemberRole
{
    use PrimaryKeyTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $alias = null;

    #[ORM\Column(length: 255)]
    private ?int $degree = null;


    /** Relations */
    #[ORM\OneToMany(targetEntity: Team::class, mappedBy: 'teamMemberRole', cascade: ['persist', 'remove'])]
    private ?Collection $teams;

    #[ORM\OneToMany(targetEntity: TeamInvite::class, mappedBy: 'teamMemberRole', cascade: ['persist', 'remove'])]
    private ?Collection $teamInvites;

    #[ORM\OneToMany(targetEntity: TeamMember::class, mappedBy: 'teamMemberRole', cascade: ['persist', 'remove'])]
    private ?Collection $teamMembers;


    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->teamInvites = new ArrayCollection();
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
            $team->setTeamMemberRole($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getTeamMemberRole() === $this) {
                $team->setTeamMemberRole(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamInvite>
     */
    public function getTeamInvites(): Collection
    {
        return $this->teamInvites;
    }

    public function addTeamInvite(TeamInvite $teamInvite): static
    {
        if (!$this->teamInvites->contains($teamInvite)) {
            $this->teamInvites->add($teamInvite);
            $teamInvite->setTeamMemberRole($this);
        }

        return $this;
    }

    public function removeTeamInvite(TeamInvite $teamInvite): static
    {
        if ($this->teamInvites->removeElement($teamInvite)) {
            // set the owning side to null (unless already changed)
            if ($teamInvite->getTeamMemberRole() === $this) {
                $teamInvite->setTeamMemberRole(null);
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
