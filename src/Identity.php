<?php

namespace Jandanielcz\Positive;

class Identity
{
    public function __construct(
        public ?string $name = null,
        public ?string $csrfToken = null
    ){}

    public function isLoggedIn(): bool
    {
        return ($this->csrfToken !== null && $this->name !== null);
    }
}