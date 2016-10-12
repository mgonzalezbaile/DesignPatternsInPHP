<?php

namespace PhpPatterns\Decorator\ApplicationService;

interface ApplicationService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function execute(Request $request = null);
}
