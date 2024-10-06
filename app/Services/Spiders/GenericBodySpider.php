<?php

namespace App\Services\Spiders;

use Generator;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class GenericBodySpider extends BasicSpider
{
    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $body = $response->filter('body')->html();

        // Remove <script>
        $body = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i', '', $body);

        // Remove <svg>
        $body = preg_replace('/<svg\b[^<]*(?:(?!<\/svg>)<[^<]*)*<\/svg>/i', '', $body);

        // Remove <style>
        $body = preg_replace('/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/i', '', $body);

        yield $this->item([
            'body' => $body,
        ]);
    }
}
