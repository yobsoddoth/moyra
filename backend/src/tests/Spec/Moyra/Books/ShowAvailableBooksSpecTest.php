<?php

namespace Tests\Specs\Moyra\Books;

use Tests\Spec\MoyraSpecTestCase;

class ShowAvailableBooksSpecTest extends MoyraSpecTestCase
{
    public function test_show_list_of_all_available_books_as_json(): void
    {
        $result = $this->dsl->listAllBooksInOriginalLanguage();
        $this->assertJsonIsArray($result);

        $book = $this->jsonArrayElementAt($result, 0);
        $this->assertJsonFootprint($book, [
            'id' => '<uuid>',
            'language' => [
                'id' => '<int>',
                'code' => '<text>'
            ],
            'title' => '<text>',
            'annotation' => '<text>'
        ]);
    }
}
