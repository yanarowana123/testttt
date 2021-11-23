<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUrlRequest;
use App\Http\Resources\UrlResource;
use App\Services\ShortUrlService;
use Illuminate\Http\Request;

class ShortUrlController extends Controller
{
    private ShortUrlService $shortUrlService;

    public function __construct(ShortUrlService $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
    }

    public function __invoke(StoreUrlRequest $request): UrlResource
    {
        $model = $this->shortUrlService->makeOrGetFirst($request->origin_url);
        return new UrlResource($model);
    }
}
