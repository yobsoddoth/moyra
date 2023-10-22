<?php

namespace App\Repos\Sql;

use Moyra\Interfaces\Repos\BookRepoInterface;
use App\Models\Books\Episode as EloquentEpisode;

class BookRepo implements BookRepoInterface
{
    public function fetchEpisodeAndChoices(string $episodeId): array
    {
        $ep = EloquentEpisode::with([
                'i18n' => fn ($q) => $q->where('language_id', 1),
                'choices.i18n' => fn ($q) => $q->where('language_id', 1)
            ])
            ->where('id', $episodeId)
            ->first()
            ->toArray();

        return [
            'id' => $ep['id'],
            'summary' => $ep['summary'],
            'content' => $ep['i18n'][0]['content'],
            'choices' => array_map(function ($c) {
                return [
                    'id' => $c['id'],
                    'towardsEpisodeId' => $c['towards_episode_id'],
                    'summary' => $c['summary'],
                    'content' => $c['i18n'][0]['content'],
                ];
            }, $ep['choices']),
        ];
    }
}