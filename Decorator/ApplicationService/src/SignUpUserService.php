<?php

namespace PhpPatterns\Decorator\ApplicationService;

class SignUpUserService implements ApplicationService
{
    /**
     * @param Request|SignUpUserRequest $request
     * @return mixed
     */
    public function execute(Request $request = null)
    {
        echo 'signing up user: '.$request->userId()."\n";
        echo 'finished'."\n";
    }
}
