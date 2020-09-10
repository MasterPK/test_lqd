<?php

declare(strict_types=1);

namespace App\Security;

use App\Models\Orm\Orm;
use Nette;
use Nette\Security\Identity;
use Nette\Utils\Json;

/**
 * Class Authenticator
 * @package App\Security
 * @author Petr Křehlík
 */
class Authenticator implements Nette\Security\IAuthenticator
{

    /**
     * @inheritDoc
     */
    public function authenticate(array $credentials): \Nette\Security\IIdentity
    {
        [$user,$password] = $credentials;

        if ($password!="liquiddesign") {
            throw new Nette\Security\AuthenticationException('Chybé heslo!');
        }

        return new Identity($user);
    }
}
