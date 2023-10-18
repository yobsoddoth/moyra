<?php

namespace Tests\Spec;

use PHPUnit\Framework\TestCase;
use Tests\JsonFootprint;

class DSL
{
    public function listAllBooksInOriginalLanguage(): string
    {
        return json_encode([
            [
                "id" => "00000000-0001-0000-0000-000000000000",
                "language" => [
                    "id" => 1,
                    "code" => "en",
                ],
                "title" => "Scroll of Trials",
                "annotation" => "Test book to FAFO",
            ],
            [
                "id" => "00000000-0002-0000-0000-000000000000",
                "language" => [
                    "id" => 1,
                    "code" => "en",
                ],
                "title" => "Scroll of Extras",
                "annotation" => "Test book to take up space in lists",
            ],
        ]);
    }
}

class MoyraSpecTestCase extends TestCase
{
    use JsonFootprint;

    protected DSL $dsl;

    protected function setUp(): void
    {
        $this->dsl = new DSL();
    }

    public function assertJsonIsArray(string $json): void
    {
        $this->assertJson($json);
        $this->assertTrue(
            strpos($json, '[') === 0,
            sprintf("Failed asserting that `%s...` is json array", substr($json, 0, 20))
        );
    }

    public function jsonArrayElementAt(string $json, int $index): mixed
    {
        $decoded = json_decode($json, true);

        $this->assertArrayHasKey($index, $decoded);
        return $decoded[$index];
    }
}
