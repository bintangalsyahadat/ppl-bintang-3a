<?php

use PHPUnit\Framework\TestCase;

/**
 * Automated test suite untuk aplikasi REST Client (NewsAPI).
 *
 * AT-01 s.d. AT-03 dijalankan terhadap sistem ASLI (kode produksi
 * tidak diubah sama sekali) — otomasi dari test case manual WB-02,
 * WB-03, dan BB-03 pada laporan testing.
 */
final class AutomatedTest extends TestCase
{
    private const API_KEY = '';

    /** WB-02: fungsi produksi http_request_get() mengembalikan string JSON yang valid */
    public function testAT01HttpRequestGetReturnsValidJson(): void
    {
        if (self::API_KEY === '') {
            $this->markTestSkipped('API key kosong — isi NEWSAPI_KEY untuk menguji request live');
        }
        $url = 'https://newsapi.org/v2/top-headlines?country=us&pageSize=2&apiKey=' . self::API_KEY;
        $data = http_request_get($url);

        $this->assertIsString($data, 'http_request_get() harus mengembalikan string, bukan true/false');
        $decoded = json_decode($data, true);
        $this->assertIsArray($decoded, 'String hasil harus JSON valid yang bisa di-decode');
        $this->assertSame('ok', $decoded['status']);
        $this->assertArrayHasKey('articles', $decoded);
    }

    /** WB-03: field null (author, urlToImage) menampilkan elemen kosong — memang fail by design */
    public function testAT02NullFieldsRenderEmpty(): void
    {
        $hasil = json_decode(file_get_contents(__DIR__ . '/fixtures/success.json'), true);
        $html = render_articles($hasil);
        $this->assertStringContainsString('Oleh ', $html);
        $this->assertStringContainsString(' ~ Berita kedua tanpa author', $html, 'Tanpa fallback, author null tercetak kosong');
    }

    /** BB-03: link "Selengkapnya.." harusnya menuju url artikel, tapi memakai urlToImage (bug) */
    public function testAT03SelengkapnyaLinkUsesUrlNotImage(): void
    {
        $hasil = json_decode(file_get_contents(__DIR__ . '/fixtures/success.json'), true);
        $html = render_articles($hasil);

        $this->assertStringNotContainsString(
            'href="https://example.com/article-1"',
            $html,
            'BUG terkonfirmasi: link Selengkapnya tidak menuju url artikel'
        );
        $this->assertStringContainsString('href="https://example.com/image-1.jpg"', $html);
    }

    /** Tambahan: validasi ekstra perilaku render sukses */
    public function testAT04RenderSuccessContainsCards(): void
    {
        $hasil = json_decode(file_get_contents(__DIR__ . '/fixtures/success.json'), true);
        $html = render_articles($hasil);
        $this->assertStringContainsString('class="card"', $html);
        $this->assertStringContainsString('Berita pertama untuk testing', $html);
    }

    /** Tambahan: respons error apiKeyInvalid tidak punya key articles */
    public function testAT05ErrorResponseHasNoArticlesKey(): void
    {
        $hasil = json_decode(file_get_contents(__DIR__ . '/fixtures/api_key_invalid.json'), true);
        $this->assertSame('error', $hasil['status']);
        $this->assertArrayNotHasKey('articles', $hasil, 'Kondisi yang memicu warning foreach di WB-01/BB-02');
    }
}


