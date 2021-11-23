<?php

namespace Tests\Feature;

use App\Services\ShortUrlService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShortUrlServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ShortUrlService $shortUrlService;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->shortUrlService = new ShortUrlService();
    }

    /**
     * @dataProvider urlProvider
     */
    public function test_short_link_created(string $url)
    {
        $shortUrl = $this->shortUrlService->makeOrGetFirst($url);
        $this->assertSame($shortUrl->origin_url, $url);
        $this->assertDatabaseCount('urls', 1);
    }

    /**
     * @dataProvider urlProvider
     */
    public function test_short_link_created_from_api(string $url)
    {
        /**@var TestResponse $response */
        $this->post('/api/shorten_url', ['origin_url' => $url]);
        $this->assertDatabaseCount('urls', 1);
    }

    public function urlProvider()
    {
        return [
            ['https://vk.com'],
            ['https://mail.ru'],
            ['https://youtube.com'],
            ['https://vk.com?id=3'],
        ];
    }
}
