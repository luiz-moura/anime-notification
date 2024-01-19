<?php

namespace Tests\Unit\Anime;

use Domain\Animes\Actions\NotifyMembersThatAnimeWillBeBroadcastAction;
use Domain\Animes\Contracts\MemberRepository;
use Domain\Animes\DTOs\Collections\ImagesCollection;
use Domain\Animes\DTOs\Collections\MembersCollection;
use Domain\Animes\DTOs\Models\AnimesModelData;
use Infra\Helpers\UrlHelper;
use Infra\Integration\Notification\Contracts\NoticationService;
use Tests\Mocks\AnimesModelDataMock;
use PHPUnit\Framework\TestCase;
use Tests\Mocks\MediasModelDataMock;
use Tests\Mocks\MembersModelDataMock;

class NotifyMembersThatAnimeWillBeBroadcastActionTest extends TestCase
{
    private $memberRepository;
    private $noticationService;
    private $urlHelper;
    private $notifyMembersThatAnimeWillBeBroadcastAction;
    private AnimesModelData $anime;

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

        $this->anime = AnimesModelDataMock::create();
        $media = MediasModelDataMock::create();
        $this->anime->images = ImagesCollection::fromModel([
            $media->toArray()
        ]);
    }

    public function test_should_release_notification_of_anime_being_broadcast_to_members()
    {
        $members = new MembersCollection([
            MembersModelDataMock::create()
        ]);

        $tokens = collect($members)->pluck('fcm_token')->all();

        $this->memberRepository
            ->expects($this->once())
            ->method('queryByAnimeId')
            ->with($this->anime->id)
            ->willReturn($members);

        $this->noticationService
            ->expects($this->once())
            ->method('sendMessage')
            ->with($tokens, 'New episode released', "New {$this->anime->title} episode released", 'http://image-url.com');

        $this->urlHelper->expects($this->once())
            ->method('url')
            ->with($this->anime->images->first()->path)
            ->willReturn('http://image-url.com');

        $this->notifyMembersThatAnimeWillBeBroadcastAction->run($this->anime);
    }
}
