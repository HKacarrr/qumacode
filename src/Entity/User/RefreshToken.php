<?php

namespace App\Entity\User;

use App\Core\Services\DatabaseSchema;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity]
#[ORM\Table(name: 'refresh_tokens', schema: DatabaseSchema::USER)]
class RefreshToken extends BaseRefreshToken
{
}
