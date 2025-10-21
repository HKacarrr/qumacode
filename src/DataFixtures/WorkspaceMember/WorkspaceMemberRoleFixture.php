<?php

namespace App\DataFixtures\WorkspaceMember;

use App\Entity\Team\TeamMemberRole;
use App\Entity\Workspace\WorkspaceMemberRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WorkspaceMemberRoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $workspaceMemberRoles = WorkspaceMemberRole::WORKSPACE_MEMBER_ROLES;
        foreach ($workspaceMemberRoles as $wmr)
        {
            $title = @$wmr["title"];
            $alias = @$wmr["alias"];
            $degree = @$wmr["degree"];

            $workspaceMemberRole = @$manager->getRepository(WorkspaceMemberRole::class)->findOneBy(["alias" => $alias]);
            if (!$workspaceMemberRole){
                $workspaceMemberRole = new WorkspaceMemberRole();
            }

            $workspaceMemberRole->setTitle($title);
            $workspaceMemberRole->setAlias($alias);
            $workspaceMemberRole->setDegree($degree);

            $manager->persist($workspaceMemberRole);
        }

        $manager->flush();
    }
}
