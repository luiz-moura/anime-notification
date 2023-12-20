<?php

namespace Infra\Integration\AnimeApi\Jikan\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection;
use Infra\Integration\AnimeApi\Jikan\Exceptions\JikanApiException;

class JikanApiService implements AnimeApiService
{
    public function getSchedulesByDay(string $day): AnimesCollection
    {
        $response = $this->client()
            ->withQueryParameters([
                'kids' => false,
                'filter' => $day,
            ])
            ->get('{+endpoint}/schedules');

        if ($response->failed()) {
            throw new JikanApiException($response->getStatusCode(), $response->getException());
        }

        return AnimesCollection::fromApi(
            $response->json()['data']
        );
    }

    private function client(): PendingRequest
    {
        return Http::withUrlParameters([
            'endpoint' => env('JIKAN_API_URI')
        ])->acceptJson();
    }
}
