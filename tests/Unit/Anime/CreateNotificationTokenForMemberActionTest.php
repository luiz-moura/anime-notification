<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\CreateNotificationTokenForMemberAction;
use Domain\Animes\Contracts\NotificationTokenRepository;
use Domain\Animes\DTOs\NotificationTokenData;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\NotificationTokenDataMock;

class CreateNotificationTokenForMemberActionTest extends TestCase
{
    private CreateNotificationTokenForMemberAction $sut;
    private MockObject|NotificationTokenRepository $notificationTokenRepository;
    private NotificationTokenData $notificationToken;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var NotificationTokenRepository */
        $this->notificationTokenRepository = $this->createMock(NotificationTokenRepository::class);

        $this->sut = new CreateNotificationTokenForMemberAction(
            $this->notificationTokenRepository
        );

        $this->notificationToken = NotificationTokenDataMock::create();
    }

    public function testShouldRegisterANewTokenSuccessfully(): void
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

        $this->sut->run($this->notificationToken);
    }

    public function testShouldNotRegisterATokenThatAlreadyExists(): void
    {
        $this->notificationTokenRepository
            ->expects($this->once())
            ->method('tokenAlreadyExists')
            ->with($this->notificationToken->token)
            ->willReturn(true);

        $this->notificationTokenRepository
            ->expects($this->never())
            ->method('create');

        $this->sut->run($this->notificationToken);
    }
}
