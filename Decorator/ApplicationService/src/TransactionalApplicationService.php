<?php

namespace PhpPatterns\Decorator\ApplicationService;

class TransactionalApplicationService implements ApplicationService
{
    /**
     * @var ApplicationService
     */
    private $applicationService;
    /**
     * @var TransactionalSession
     */
    private $transactionalSession;

    /**
     * TransactionalApplicationService constructor.
     * @param ApplicationService $applicationService
     * @param TransactionalSession $transactionalSession
     */
    public function __construct(ApplicationService $applicationService, TransactionalSession $transactionalSession)
    {

        $this->applicationService = $applicationService;
        $this->transactionalSession = $transactionalSession;
    }
    
    /**
     * @param Request $request
     * @return mixed
     */
    public function execute(Request $request = null)
    {
        $executeCallback = function () use ($request) {
            return $this->applicationService->execute($request);
        };

        return $this->transactionalSession->executeAtomically($executeCallback);
    }
}
