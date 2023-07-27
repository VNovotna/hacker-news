<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;

class NewsClient
{

    public function __construct(private readonly Client $client)
    {
    }

    public function getTopstoriesIds(): array
    {
        $response = $this->client->get('topstories.json');
        return json_decode((string) $response->getBody(), flags: JSON_THROW_ON_ERROR);
    }

    public function getStory(int $id): PromiseInterface
    {
        return $this->client->getAsync("item/{$id}.json");
    }
}