<?php

namespace Illuminate\Auth\Events;

class Failed
{
    /**
     * The authentication guard name.
     *
     * @var string
     */
    public $guard;

    /**
     * The user the attempter was trying to authenticate as.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public $user;

    /**
     * @var
     */
    public $credentials;

    /**
     * Create a new event instance.
     *
     * @param string $guard
     * @param \Illuminate\Contracts\Auth\Authenticatable|null $user
     * @param array $credentials
     * @return void
     */
    public function __construct($guard, $user, $credentials)
    {
        $this->guard = $guard;
        $this->user = $user;
        $this->credentials = $credentials;
    }
}
