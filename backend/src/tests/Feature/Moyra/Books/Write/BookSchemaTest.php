<?php

namespace Tests\Feature\Moyra\Books\Write;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\JsonFootprint;
use Tests\TestCase;

class BookSchemaTest extends TestCase
{
    use JsonFootprint;

    public function test_fetches_book_schema_as_viz_graph_json(): void
    {
        $bookId = \App\Models\Books\Book::whereHas(
            'i18n',
            fn ($query) => $query->where('title', 'Scroll of Trials')
        )->first()->id;

        $response = $this->get("/api/write/schema/{$bookId}");
        $response->assertStatus(200);

        $this->assertJsonFootprint($response->getContent(), [
            'nodes' => [
                [
                    'name' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>',
                    ]
                ],
                [
                    'name' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>',
                    ]
                ],
                [
                    'name' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>',
                    ]
                ],
                [
                    'name' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>',
                    ]
                ],
            ],

            'edges' => [
                [
                    'tail' => '<uuid>',
                    'head' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>'
                    ]
                ],
                [
                    'tail' => '<uuid>',
                    'head' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>'
                    ]
                ],
                [
                    'tail' => '<uuid>',
                    'head' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>'
                    ]
                ],
                [
                    'tail' => '<uuid>',
                    'head' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>'
                    ]
                ],
                [
                    'tail' => '<uuid>',
                    'head' => '<uuid>',
                    'attributes' => [
                        'label' => '<text>',
                        'id' => '<uuid>'
                    ]
                ],
            ],
        ]);
    }
}
