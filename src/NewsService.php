<?php

declare(strict_types=1);

namespace App;

use GuzzleHttp\Promise;

class NewsService
{

    private const DEFAULT_NEWS_COUNT = 100;

    private const BATCH_SIZE = 10;

    public function __construct(private readonly NewsClient $client)
    {
    }

    /**
     * @return NewsStory[]
     */
    public function getStories(int $limit = self::DEFAULT_NEWS_COUNT): array
    {
        $ids = $this->client->getTopstoriesIds();
        $stories = [];

        $cycleLimit = min(count($ids), $limit);
        for ($i = 0; $i < $cycleLimit; $i += self::BATCH_SIZE) {
            $promises = [];
            for ($j = 0; $j < min(self::BATCH_SIZE, $cycleLimit - $i); $j++) {
                $promises[] = $this->client->getStory($ids[$i + $j]);
            }

            $responses = Promise\Utils::unwrap($promises);
            foreach ($responses as $response) {
                $data = json_decode((string) $response->getBody(), true, flags: JSON_THROW_ON_ERROR);
                $stories[] = new NewsStory(
                    $data['id'],
                    $data['title'],
                    $data['url'] ?? null,
                    (new \DateTimeImmutable)->setTimestamp($data['time']),
                );
            }
        }
        return $stories;
    }
}