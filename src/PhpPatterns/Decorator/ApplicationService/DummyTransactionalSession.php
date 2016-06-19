<?php

namespace PhpPatterns\Decorator\ApplicationService;

class DummyTransactionalSession implements TransactionalSession
{
    /**
     * @param callable $executeCallback
     * @return mixed
     * @throws \Exception
     */
    public function executeAtomically(callable $executeCallback)
    {
        echo "Transaction starts\n";

        try {
            $return = call_user_func($executeCallback);

            echo "commit transaction\n";

            return $return;
        } catch (\Exception $ex) {
            echo "close transaction \n";
            echo "rollback\n";

            throw $ex;
        }
    }
}
