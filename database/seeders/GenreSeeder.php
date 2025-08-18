<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            // Main
            'Action', 'Adventure', 'Comedy', 'Drama', 'Fantasy', 'Horror', 'Mystery',
            'Romance', 'Sci-Fi', 'Thriller', 'Crime', 'Historical', 'War',
            'Western', 'Musical', 'Documentary', 'Animation',

            // Subgenres
            'Martial Arts', 'Superhero', 'Spy', 'Disaster', 'Survival',
            'Parody', 'Satire', 'Slapstick', 'Dark Comedy', 'Romantic Comedy',
            'Melodrama', 'Legal Drama', 'Medical Drama', 'Period Drama',
            'High Fantasy', 'Urban Fantasy', 'Dark Fantasy',
            'Supernatural Horror', 'Slasher', 'Psychological Horror', 'Monster Horror',
            'Zombie', 'Found Footage',
            'Whodunit', 'Detective', 'Noir',
            'Teen Romance', 'Tragic Romance', 'Yaoi', 'Yuri',
            'Cyberpunk', 'Space Opera', 'Time Travel', 'Dystopian', 'Post-Apocalyptic',
            'Psychological Thriller', 'Political Thriller', 'Techno-Thriller', 'Conspiracy',
            'Gangster', 'Heist', 'Mafia', 'True Crime',
            'Biopic', 'Epic', 'Historical Romance', 'Docudrama',
            'Anti-War', 'Resistance', 'Spy War',
            'Classic Western', 'Neo-Western', 'Spaghetti Western', 'Samurai Western',
            'Jukebox Musical', 'Rock Opera', 'Bollywood',
            'Nature Doc', 'Biography Doc', 'True Crime Doc', 'Mockumentary',

            // Anime/Manga
            'Shonen', 'Shojo', 'Seinen', 'Josei', 'Isekai',
            'Slice of Life', 'Mecha', 'Magical Girl', 'Harem', 'Reverse Harem',
            'Sports', 'Idol/Music',

            // Hybrid
            'Steampunk', 'Dieselpunk', 'Supernatural Romance',
            'Horror Comedy', 'Sci-Fi Western', 'Fantasy Adventure',
            'Action Comedy', 'Romantic Thriller', 'Sci-Fi Horror',
            'Dark Fantasy', 'Post-Apocalyptic Horror',
            'Mystery Thriller', 'Psychological Drama',
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(['name' => $genre]);
        }
    }
}
