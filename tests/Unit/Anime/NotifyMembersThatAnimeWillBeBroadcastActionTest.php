<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\NotifyMembersThatAnimeWillBeBroadcastAction;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Collections\ImagesCollection;
use Domain\Animes\DTOs\Collections\MembersCollection;
use Domain\Animes\DTOs\Collections\NotificationTokensCollection;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Infra\Helpers\UrlHelper;
use Infra\Integration\Notification\Contracts\NotificationService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\MediaModelDataMock;
use Tests\Mocks\MemberModelDataMock;

class NotifyMembersThatAnimeWillBeBroadcastActionTest extends TestCase
{
    private NotifyMembersThatAnimeWillBeBroadcastAction $sut;
    private MockObject|MemberRepository $memberRepository;
    private MockObject|NotificationService $notificationService;
    private MockObject|UrlHelper $urlHelper;
    private AnimeModelData $anime;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var MemberRepository */
        $this->memberRepository = $this->createMock(MemberRepository::class);
        /** @var NotificationService */
        $this->notificationService = $this->createMock(NotificationService::class);
        /** @var UrlHelper */
        $this->urlHelper = $this->createMock(UrlHelper::class);

        $this->sut = new NotifyMembersThatAnimeWillBeBroadcastAction(
            $this->memberRepository,
            $this->notificationService,
            $this->urlHelper,
        );

        $this->anime = AnimeModelDataMock::create();
        $media = MediaModelDataMock::create();
        $this->anime->images = ImagesCollection::fromModel([
            $media->toArray(),
        ]);
    }

    public function testShouldReleaseNotificationOfAnimeBeingBroadcastToMembers(): void
    {
        $members = new MembersCollection([
            MemberModelDataMock::create(),
        ]);

        $tokens = collect($members)->pluck('notification_tokens')
            ->collapse()
            ->pluck('token')
            ->all();

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByAnimeId')
            ->with($this->anime->id)
            ->willReturn($members);

        $this->notificationService
            ->expects($this->once())
            ->method('sendMessage')
            ->with($tokens, 'New episode released', "New {$this->anime->title} episode released", 'http://image-url.com');

        $this->urlHelper
            ->expects($this->once())
            ->method('url')
            ->with($this->anime->images->first()->path)
            ->willReturn('http://image-url.com');

        $this->sut->run($this->anime);
    }

    public function testShouldNotNotifyWhenNoMembersAreFound(): void
    {
        $members = new MembersCollection();

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByAnimeId')
            ->with($this->anime->id)
            ->willReturn($members);

        $this->notificationService
            ->expects($this->never())
            ->method('sendMessage');

        $this->urlHelper
            ->expects($this->never())
            ->method('url');

        $this->sut->run($this->anime);
    }

    public function testShouldNotNotifyWhenThereAreNoTokensRegistered(): void
    {
        $members = new MembersCollection([
            MemberModelDataMock::create(['notification_tokens' => new NotificationTokensCollection()]),
        ]);

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByAnimeId')
            ->with($this->anime->id)
            ->willReturn($members);

        $this->notificationService
            ->expects($this->never())
            ->method('sendMessage');

        $this->urlHelper
            ->expects($this->never())
            ->method('url');

        $this->sut->run($this->anime);
    }
}
