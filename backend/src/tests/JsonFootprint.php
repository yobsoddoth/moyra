<?php

namespace Tests;

trait JsonFootprint
{
    public function assertJsonFootprint(string|array $json, array $footprint): void
    {
        $decoded = is_string($json) ? json_decode($json, true) : $json;
        foreach ($footprint as $key => $type) {
            $this->assertArrayHasKey($key, $decoded);
            $value = $decoded[$key];

            if (is_array($type)) {
                $this->assertJsonFootprint($value, $type);
            } else {
                $this->assertJsonValueFootprint($value, $type);
            }
        }
    }

    private function assertJsonValueFootprint(mixed $value, string $type): void
    {
        switch ($type) {
            case '<int>':
                $this->assertTrue(is_integer($value), "Failed asserting that `{$value}` is type {$type}");
                break;
            case '<text>':
                $this->assertTrue(is_string($value), "Failed asserting that `{$value}` is type {$type}");
                break;
            case '<uuid>':
                $this->assertTrue(
                    preg_match("/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/", $value) === 1,
                    "Failed asserting that `{$value}` is {$type}"
                );
                break;
            default:
                new \Exception("Type {$type} is not supported by JsonFootprint.");
        }
    }
}