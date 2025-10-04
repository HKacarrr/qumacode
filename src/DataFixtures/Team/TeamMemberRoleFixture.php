<?php

namespace App\DataFixtures\Team;

use App\Entity\Team\TeamMemberRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamMemberRoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $teamMemberRoles = TeamMemberRole::TEAM_MEMBER_ROLES;
        foreach ($teamMemberRoles as $tmr)
        {
            $title = @$tmr["title"];
            $alias = @$tmr["alias"];
            $degree = @$tmr["degree"];

            $teamMemberRole = @$manager->getRepository(TeamMemberRole::class)->findOneBy(["alias" => $alias]);
            if (!$teamMemberRole){
                $teamMemberRole = new TeamMemberRole();
            }

            $teamMemberRole->setTitle($title);
            $teamMemberRole->setAlias($alias);
            $teamMemberRole->setDegree($degree);

            $manager->persist($teamMemberRole);
        }

        $manager->flush();
    }
}
