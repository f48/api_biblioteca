<?php

use Illuminate\Database\Seeder;
use App\Book;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = Book::all();

        foreach(range(1, 50) as $i) {
            $user = factory(\App\User::class)->create();

            $randomBooks = $books->random(rand(0, 2));

            $user->lends()->attach($randomBooks);
        }
    }
}
