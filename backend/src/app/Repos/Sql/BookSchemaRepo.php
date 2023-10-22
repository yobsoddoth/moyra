<?php

namespace App\Repos\Sql;

use App\Models\Books\Episode as EloquentEpisode;
use App\Models\Books\Choice as EloquentChoice;
use Moyra\Interfaces\Repos\BookSchemaRepoInterface;

class BookSchemaRepo implements BookSchemaRepoInterface
{
    public function asGraphviz(string $bookId): array
    {
        return [
            'nodes' => $this->fetchNodes($bookId),
            'edges' => $this->fetchEdges($bookId),
        ];
    }

    private function fetchNodes(string $bookId): array
    {
        $episodes = EloquentEpisode::where('book_id', $bookId)
            ->select('id', 'summary')
            ->get()
            ->toArray();

        return array_map(function ($e) {
            return [
                'name' => $e['id'],
                'attributes' => [
                    'label' => $e['summary'],
                    'id' => $e['id']
                ]
            ];
        }, $episodes);
    }

    private function fetchEdges(string $bookId): array
    {
        $choices = EloquentChoice::whereHas(
            'episode',
            fn ($q) => $q->where('book_id', $bookId)
        )
            ->select('id', 'episode_id', 'towards_episode_id', 'summary')
            ->get()
            ->toArray();

        return array_map(function ($c) {
            return [
                'tail' => $c['episode_id'],
                'head' => $c['towards_episode_id'],
                'attributes' => [
                    'label' => $c['summary'],
                    'id' => $c['id']
                ]
            ];
        }, $choices);
    }
}
