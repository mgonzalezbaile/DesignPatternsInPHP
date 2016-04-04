<?php

namespace PhpPatterns\Decorator\ApplicationService;

class SignUpUserServiceWithException implements ApplicationService
{
    /**
     * @param Request|SignUpUserRequest $request
     * @return void
     * @throws \Exception
     */
    public function execute(Request $request = null)
    {
        throw new \Exception('Error signing up user :'.$request->userId());
    }
}
