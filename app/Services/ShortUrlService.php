<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Url;
use App\Repositories\UrlRepository;
use Illuminate\Support\Str;

final class ShortUrlService
{
    public function makeOrGetFirst(string $url): Url
    {
        $model = UrlRepository::getFirstByOriginUrl($url);

        if ($model) {
            return $model;
        }

        return $this->makeUrl($url);
    }

    private function makeUrl(string $url): Url
    {
        $shortUrl = Str::random(7);

        while (!$this->isShortUrlUnique($shortUrl)) {
            $shortUrl = Str::random(7);
        }

        return Url::create(['origin_url' => $url, 'short_url' => $shortUrl]);
    }

    private function isShortUrlUnique(string $shortUrl): bool
    {
        return !(bool)UrlRepository::getCountByShorUrl($shortUrl);
    }

}
