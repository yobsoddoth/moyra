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

    public function test_load_episode_and_choices_in_original_language(): void
    {
        $episodeId = \App\Models\Books\Episode::where('is_prologue', 1)->first()->id;
        $response = $this->get("/api/write/episode/{$episodeId}");
        $response->assertStatus(200);

        $this->assertJsonFootprint($response->getContent(), [
            'id' => '<uuid>',
            'summary' => '<text>',
            'content' => '<text>',
            'choices' => [
                [
                    'id' => '<uuid>',
                    'towardsEpisodeId' => '<uuid>',
                    'summary' => '<text>',
                    'content' => '<text>',
                ],
                [
                    'id' => '<uuid>',
                    'towardsEpisodeId' => '<uuid>',
                    'summary' => '<text>',
                    'content' => '<text>',
                ],
                [
                    'id' => '<uuid>',
                    'towardsEpisodeId' => '<uuid>',
                    'summary' => '<text>',
                    'content' => '<text>',
                ],
            ],
        ]);
    }
}
