<?php

declare(strict_types=1);

namespace App;

use DateTimeInterface;

class NewsStory
{

    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly ?string $url,
        public readonly DateTimeInterface $created,
    ) {
    }
}