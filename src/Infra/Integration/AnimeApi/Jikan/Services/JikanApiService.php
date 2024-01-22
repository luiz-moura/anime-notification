<?php

namespace Infra\Integration\AnimeApi\Jikan\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Infra\Integration\AnimeApi\Contracts\AnimeApiService;
use Infra\Integration\AnimeApi\DTOs\Collections\AnimesCollection;
use Infra\Integration\AnimeApi\Jikan\Exceptions\JikanApiException;

class JikanApiService implements AnimeApiService
{
    public function getSchedulesByDay(string $day): AnimesCollection
    {
        $data = [];
        $hasNextPage = true;
        $page = 1;

        while ($hasNextPage) {
            $response = $this->client()
                ->withQueryParameters([
                    'page' => $page,
                    'filter' => $day,
                ])
                ->get('{+endpoint}/schedules');

            if ($response->failed()) {
                throw new JikanApiException($response->toException());
            }

            $data[] = $response->json()['data'];

            $hasNextPage = $response->json()['pagination']['has_next_page'];
            $page++;
        }

        return AnimesCollection::fromApi(
            Arr::collapse($data)
        );
    }

    private function client(): PendingRequest
    {
        return Http::withUrlParameters([
            'endpoint' => env('JIKAN_API_URI'),
        ])->acceptJson();
    }
}
