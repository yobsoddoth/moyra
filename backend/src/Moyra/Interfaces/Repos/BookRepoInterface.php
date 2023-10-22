<?php

namespace Moyra\Interfaces\Repos;

interface BookRepoInterface
{
    public function fetchEpisodeAndChoices(string $episodeId): array;
}
