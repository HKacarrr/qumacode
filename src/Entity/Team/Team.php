<?php

namespace App\Entity\Team;

use App\Core\Traits\Entity\DatetimeTrait;
use App\Core\Traits\Entity\PrimaryKeyTrait;
use App\Entity\User\User;
use App\Repository\Team\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    use PrimaryKeyTrait, DatetimeTrait;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $uuid = null;


    /** Relations */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'teams')]
    #[ORM\JoinColumn(name: 'created_user_id', referencedColumnName: "id", onDelete: "CASCADE")]
    private ?User $user = null;


    #[ORM\ManyToOne(targetEntity: TeamMemberRole::class, inversedBy: 'teams')]
    #[ORM\JoinColumn(name: 'team_member_role_id', referencedColumnName: "id", onDelete: "SET NULL")]
    private ?TeamMemberRole $teamMemberRole = null;


    #[ORM\OneToMany(targetEntity: TeamInvite::class, mappedBy: 'team', cascade: ['persist', 'remove'])]
    private ?Collection $teamInvites;

    public function __construct()
    {
        $this->teamInvites = new ArrayCollection();
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

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): static
    {
        $this->uuid = $uuid;

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

    public function getTeamMemberRole(): ?TeamMemberRole
    {
        return $this->teamMemberRole;
    }

    public function setTeamMemberRole(?TeamMemberRole $teamMemberRole): static
    {
        $this->teamMemberRole = $teamMemberRole;

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
            $teamInvite->setTeam($this);
        }

        return $this;
    }

    public function removeTeamInvite(TeamInvite $teamInvite): static
    {
        if ($this->teamInvites->removeElement($teamInvite)) {
            // set the owning side to null (unless already changed)
            if ($teamInvite->getTeam() === $this) {
                $teamInvite->setTeam(null);
            }
        }

        return $this;
    }


}
