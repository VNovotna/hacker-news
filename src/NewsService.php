<?php

declare(strict_types=1);

namespace App;

class NewsService
{

    private const DEFAULT_NEWS_COUNT = 100;

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
        for ($i = 0; $i < min(count($ids), $limit); $i++) {
            $stories[] = $this->client->getStory($ids[$i]);
        }
        return $stories;
    }
}