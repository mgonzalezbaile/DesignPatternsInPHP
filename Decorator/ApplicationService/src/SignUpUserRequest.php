<?php

namespace PhpPatterns\Decorator\ApplicationService;

class SignUpUserRequest implements Request
{
    /**
     * @var string
     */
    private $userId;

    /**
     * SignUpUserRequest constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function userId()
    {
        return $this->userId;
    }
}
