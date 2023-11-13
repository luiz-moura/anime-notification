<?php

namespace Infra\Api\Jikan\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Infra\Api\Contracts\AnimeApiService;
use Infra\Api\DTOs\Collections\AnimesCollection;
use Infra\Api\Jikan\Exceptions\JikanApiException;

class JikanApiService implements AnimeApiService
{
    public function searchByTerm(string $term): AnimesCollection
    {
        $response = $this->client()
            ->withQueryParameters(['q' => $term])
            ->get(env('JIKAN_API_URI') . '/anime');

        if ($response->failed()) {
            throw new JikanApiException($response->getStatusCode(), $response->getException());
        }

        return AnimesCollection::fromApi(
            $response->json()['data']
        );
    }

    public function getSchedulesByDay(string $day): AnimesCollection
    {
        $response = $this->client()
            ->withQueryParameters([
                'kids' => false,
                'filter' => $day,
            ])
            ->get(env('JIKAN_API_URI') . '/schedules');

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
        ]);
    }
}
