<?php

declare(strict_types=1);

namespace App;

class Printer
{

    public function __construct(private readonly string $storyUrl)
    {
    }

    /**
     * @param NewsStory[] $stories
     */
    public function dump(array $stories): void
    {
        foreach ($stories as $item) {
            print $item->title . " from " . $item->created->format(DATE_ATOM) . PHP_EOL .
                $this->storyUrl . $item->id . PHP_EOL .
                $item->url . PHP_EOL;
            print "---" . PHP_EOL;
        }
    }
}