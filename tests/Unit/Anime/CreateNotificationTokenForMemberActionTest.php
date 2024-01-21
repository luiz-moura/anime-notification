<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\CreateNotificationTokenForMemberAction;
use Domain\Animes\Contracts\NotificationTokenRepository;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\NotificationTokenDataMock;

class CreateNotificationTokenForMemberActionTest extends TestCase
{
    private $notificationTokenRepository;
    private $createNotificationTokenForMemberAction;
    private $notificationToken;

    protected function setUp(): void
    {
        parent::setUp();

        $this->notificationTokenRepository = $this->createMock(NotificationTokenRepository::class);

        $this->createNotificationTokenForMemberAction = new CreateNotificationTokenForMemberAction(
            $this->notificationTokenRepository
        );

        $this->notificationToken = NotificationTokenDataMock::create();
    }

    public function test_should_register_a_new_token_successfully()
    {
        $this->notificationTokenRepository
            ->expects($this->once())
            ->method('tokenAlreadyExists')
            ->with($this->notificationToken->token)
            ->willReturn(false);

        $this->notificationTokenRepository
            ->expects($this->once())
            ->method('create')
            ->with($this->notificationToken);

        $this->createNotificationTokenForMemberAction->run($this->notificationToken);
    }

    public function test_should_not_register_a_token_that_already_exists()
    {
        $this->notificationTokenRepository
            ->expects($this->once())
            ->method('tokenAlreadyExists')
            ->with($this->notificationToken->token)
            ->willReturn(true);

        $this->notificationTokenRepository
            ->expects($this->never())
            ->method('create');

        $this->createNotificationTokenForMemberAction->run($this->notificationToken);
    }
}
