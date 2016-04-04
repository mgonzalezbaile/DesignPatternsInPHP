<?php

namespace PhpPatterns\Decorator\ApplicationService;

interface TransactionalSession
{
    /**
     * @param callable $executeCallback
     * @return mixed
     */
    public function executeAtomically(callable $executeCallback);
}
