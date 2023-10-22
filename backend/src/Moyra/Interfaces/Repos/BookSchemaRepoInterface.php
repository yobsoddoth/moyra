<?php

namespace Moyra\Interfaces\Repos;

interface BookSchemaRepoInterface
{
    public function asGraphviz(string $bookId): array;
}
