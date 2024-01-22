<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\NotifyMembersThatAnimeWillBeBroadcastAction;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Collections\ImagesCollection;
use Domain\Animes\DTOs\Collections\MembersCollection;
use Domain\Animes\DTOs\Collections\NotificationTokensCollection;
use Domain\Animes\DTOs\Models\AnimeModelData;
use Infra\Helpers\UrlHelper;
use Infra\Integration\Notification\Contracts\NoticationService;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\AnimeModelDataMock;
use Tests\Mocks\MediaModelDataMock;
use Tests\Mocks\MemberModelDataMock;

class NotifyMembersThatAnimeWillBeBroadcastActionTest extends TestCase
{
    private $memberRepository;
    private $noticationService;
    private $urlHelper;
    private $notifyMembersThatAnimeWillBeBroadcastAction;
    private AnimeModelData $anime;

    protected function setUp(): void
    {
        parent::setUp();

        $this->memberRepository = $this->createMock(MemberRepository::class);
        $this->noticationService = $this->createMock(NoticationService::class);
        $this->urlHelper = $this->createMock(UrlHelper::class);

        $this->notifyMembersThatAnimeWillBeBroadcastAction = new NotifyMembersThatAnimeWillBeBroadcastAction(
            $this->memberRepository,
            $this->noticationService,
            $this->urlHelper,
        );

        $this->anime = AnimeModelDataMock::create();
        $media = MediaModelDataMock::create();
        $this->anime->images = ImagesCollection::fromModel([
            $media->toArray(),
        ]);
    }

    public function testShouldReleaseNotificationOfAnimeBeingBroadcastToMembers()
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

        $this->noticationService
            ->expects($this->once())
            ->method('sendMessage')
            ->with($tokens, 'New episode released', "New {$this->anime->title} episode released", 'http://image-url.com');

        $this->urlHelper
            ->expects($this->once())
            ->method('url')
            ->with($this->anime->images->first()->path)
            ->willReturn('http://image-url.com');

        $this->notifyMembersThatAnimeWillBeBroadcastAction->run($this->anime);
    }

    public function testShouldNotNotifyWhenNoMembersAreFound()
    {
        $members = new MembersCollection();

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByAnimeId')
            ->with($this->anime->id)
            ->willReturn($members);

        $this->noticationService
            ->expects($this->never())
            ->method('sendMessage');

        $this->urlHelper
            ->expects($this->never())
            ->method('url');

        $this->notifyMembersThatAnimeWillBeBroadcastAction->run($this->anime);
    }

    public function testShouldNotNotifyWhenThereAreNoTokensRegistered()
    {
        $members = new MembersCollection([
            MemberModelDataMock::create(['notification_tokens' => new NotificationTokensCollection()]),
        ]);

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByAnimeId')
            ->with($this->anime->id)
            ->willReturn($members);

        $this->noticationService
            ->expects($this->never())
            ->method('sendMessage');

        $this->urlHelper
            ->expects($this->never())
            ->method('url');

        $this->notifyMembersThatAnimeWillBeBroadcastAction->run($this->anime);
    }
}
