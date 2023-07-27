<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Client;

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

    public function getStory(int $id): NewsStory
    {
        $response = $this->client->get("item/{$id}.json");
        $data = json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR);
        return new NewsStory(
            $data['id'],
            $data['title'],
            $data['url'] ?? null,
            (new \DateTimeImmutable)->setTimestamp($data['time']),
        );
    }
}