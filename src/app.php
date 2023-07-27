#!/bin/php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\NewsClient;
use App\NewsService;
use GuzzleHttp\Client;
use App\Printer;

// this should be in DI container in real world
$config = [
    'api_uri' => 'https://hacker-news.firebaseio.com/v0/',
    'story_url' => 'https://news.ycombinator.com/item?id=',
];
$httpClient = new Client([
    'base_uri' => $config['api_uri'],
    'timeout' => 3.0,
]);
$service = new NewsService(new NewsClient($httpClient));
$printer = new Printer($config['story_url']);


$printer->dump($service->getStories());
