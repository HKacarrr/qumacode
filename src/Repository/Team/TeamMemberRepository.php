<?php

namespace App\Repository\Team;

use App\Entity\Team\Team;
use App\Entity\Team\TeamMember;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamMember>
 */
class TeamMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamMember::class);
    }


    public function coreQb(): QueryBuilder
    {
        return $this->createQueryBuilder('teamMember')
            ->leftJoin('teamMember.team', 'team')
            ->leftJoin('teamMember.user', 'user');
    }


    public function getMemberByTeamAndUser(Team $team, User $user): ?TeamMember
    {
        return $this->coreQb()
            ->where('team = :team')->setParameter('team', $team)
            ->andWhere('user = :user')->setParameter('user', $user)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
