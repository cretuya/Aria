<?php

use Illuminate\Database\Seeder;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->delete();

        $genres = array([
        	'genre_id' => null,
        	'genre_name' => 'Alternative',
        	'genre_desc' => 'alternative',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Blues',
        	'genre_desc' => 'Blues',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Classical',
        	'genre_desc' => 'Classical',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Country',
        	'genre_desc' => 'Country',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Dance',
        	'genre_desc' => 'Dance',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Electronic',
        	'genre_desc' => 'Electronic',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Hiphop',
        	'genre_desc' => 'Hiphop',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Inspirational',
        	'genre_desc' => 'Inspirational',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Jazz',
        	'genre_desc' => 'Jazz',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Opera',
        	'genre_desc' => 'Opera',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Pop',
        	'genre_desc' => 'Pop',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Punk',
        	'genre_desc' => 'Punk',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'R&B',
        	'genre_desc' => 'R&B',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Rap',
        	'genre_desc' => 'Rap',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Reggae',
        	'genre_desc' => 'Reggae',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Rock',
        	'genre_desc' => 'Rock',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Romance',
        	'genre_desc' => 'Romance',
        ],
        [
        	'genre_id' => null,
        	'genre_name' => 'Soul',
        	'genre_desc' => 'Soul',
        ]);

        DB::table('genres')->insert($genres);
    }


}
