<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Language;
use App\Models\Books\Book;
use App\Models\Books\BookI18n;
use App\Models\Books\Episode;
use App\Models\Books\EpisodeI18n;
use App\Models\Books\Choice;
use App\Models\Books\ChoiceI18n;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test Author',
            'email' => 'test.author@example.com',
        ]);

        Language::factory()
            ->count(5)
            ->sequence(
                ['code' => 'en'],
                ['code' => 'bg'],
                ['code' => 'de'],
                ['code' => 'es'],
                ['code' => 'fr'],
            )
            ->create();

        $book = Book::create(['author_id' => $user->id]);
        $book->i18n()->save(new BookI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'title' => 'Scroll of Extras',
            'annotation' => 'Test book to sit in the list.'
        ]));

        $book = Book::create(['author_id' => $user->id]);
        $book->i18n()->saveMany([
            new BookI18n([
                'language_id' => 1,
                'creator_id' => $user->id,
                'title' => 'Scroll of Trials',
                'annotation' => 'Test book to FAFO'
            ]),
            new BookI18n([
                'language_id' => 2,
                'creator_id' => $user->id,
                'title' => '[bg] Scroll of Trials',
                'annotation' => '[bg] Test book to FAFO'
            ]),
            new BookI18n([
                'language_id' => 3,
                'creator_id' => $user->id,
                'title' => '[de] Scroll of Trials',
                'annotation' => '[de] Test book to FAFO'
            ]),
            new BookI18n([
                'language_id' => 5,
                'creator_id' => $user->id,
                'title' => '[fr] Scroll of Trials',
                'annotation' => '[fr] Test book to FAFO'
            ]),
        ]);

        $prologue = Episode::create([
            'book_id' => $book->id,
            'is_prologue' => true,
            'summary' => 'start at crossroads',
        ]);
        $prologue->i18n()->saveMany([
            new EpisodeI18n([
                'language_id' => 1,
                'creator_id' => $user->id,
                'content' => 'You are standing at a crossroad',
            ]),
            new EpisodeI18n([
                'language_id' => 2,
                'creator_id' => $user->id,
                'content' => '[bg] You are standing at a crossroad',
            ]),
        ]);

        $episodeTurnedLeft = Episode::create([
            'book_id' => $book->id,
            'summary' => 'turned left',
        ]);
        $episodeTurnedLeft->i18n()->save(new EpisodeI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'You go to the left. Nothing to see here.',
        ]));

        $episodeTurnedRight = Episode::create([
            'book_id' => $book->id,
            'summary' => 'turned right',
        ]);
        $episodeTurnedRight->i18n()->saveMany([
            new EpisodeI18n([
                'language_id' => 1,
                'creator_id' => $user->id,
                'content' => 'You go to the right. It\'s a meh.',
            ]),
            new EpisodeI18n([
                'language_id' => 3,
                'creator_id' => $user->id,
                'content' => '[de] You go to the right. It\'s a meh.',
            ]),
        ]);

        $episodeJunction = Episode::create([
            'book_id' => $book->id,
            'summary' => 'turned right',
        ]);
        $episodeJunction->i18n()->save(new EpisodeI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'You are staning at a T-junction. Five dragons pop up and fry your smartass.',
        ]));

        $choiceTurnLeft = Choice::create([
            'episode_id' => $prologue->id,
            'towards_episode_id' => $episodeTurnedLeft->id,
            'summary' => 'turn left',
        ]);
        $choiceTurnLeft->i18n()->save(new ChoiceI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'Turn left.',
        ]));

        $choiceTurnRight = Choice::create([
            'episode_id' => $prologue->id,
            'towards_episode_id' => $episodeTurnedRight->id,
            'summary' => 'turn right',
        ]);
        $choiceTurnRight->i18n()->save(new ChoiceI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'Turn right.',
        ]));

        $choiceJunction = Choice::create([
            'episode_id' => $prologue->id,
            'towards_episode_id' => $episodeJunction->id,
            'summary' => 'confront author',
        ]);
        $choiceJunction->i18n()->save(new ChoiceI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'That\'s a T-junction, dumbass!',
        ]));

        $choiceBack = Choice::create([
            'episode_id' => $episodeTurnedLeft->id,
            'towards_episode_id' => $prologue->id,
            'summary' => 'turn back',
        ]);
        $choiceBack->i18n()->save(new ChoiceI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'Turn back.',
        ]));

        $choiceBack = Choice::create([
            'episode_id' => $episodeTurnedRight->id,
            'towards_episode_id' => $prologue->id,
            'summary' => 'turn back',
        ]);
        $choiceBack->i18n()->save(new ChoiceI18n([
            'language_id' => 1,
            'creator_id' => $user->id,
            'content' => 'Turn back.',
        ]));
    }
}
