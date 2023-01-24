<?php

namespace Jandanielcz\Positive;

class IdentityBuilder
{
    const SESSION_KEY = 'asdlkjasd979872SLNLWW';

    public static function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function build(): Identity
    {
        self::startSession();
        if (isset($_SESSION[self::SESSION_KEY])) {
            return new Identity($_SESSION[self::SESSION_KEY]['name'], $_SESSION[self::SESSION_KEY]['csrfToken']);
        }
        return new Identity();
    }

    public function store(Identity $identity): void
    {
        $_SESSION[self::SESSION_KEY] = [
            'name' => $identity->name,
            'csrfToken' => $identity->csrfToken
        ];
    }

    public function destroy(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
        session_destroy();
    }
}