<?php

declare(strict_types=1);

namespace App\Repositories;


use App\Models\Url;

final class UrlRepository
{
    public static function getFirstByOriginUrl(string $url): ?Url
    {
        /**@var Url $model */
        $model = Url::query()
            ->where('origin_url', $url)
            ->first();
        return $model;
    }

    public static function getCountByShorUrl(string $shortUrl): int
    {
        return Url::query()
            ->where('short_url', $shortUrl)
            ->count();
    }
}
