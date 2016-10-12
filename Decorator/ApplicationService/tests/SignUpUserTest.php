<?php

namespace PhpPatterns\Decorator\ApplicationService;

use Rhumsaa\Uuid\Uuid;

class SignUpUserTest extends \PHPUnit_Framework_TestCase
{
    public function testSignUpUser()
    {
        $signUpUserService = new SignUpUserService();

        $transactionalService = new TransactionalApplicationService(
            $signUpUserService,
            new DummyTransactionalSession()
        );

        $transactionalService->execute(new SignUpUserRequest(Uuid::uuid4()->toString()));
    }

    public function testSignUpUserOnError()
    {
        $signUpUserServiceWithException = new SignUpUserServiceWithException();

        $transactionalService = new TransactionalApplicationService(
            $signUpUserServiceWithException,
            new DummyTransactionalSession()
        );

        $this->expectException(\Exception::class);

        $transactionalService->execute(new SignUpUserRequest(Uuid::uuid4()->toString()));
    }
}
