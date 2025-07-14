<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Artist;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Concert;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $locations = [
            ['name' => 'Madison Square Garden', 'address' => '4 Pennsylvania Plaza, New York, USA'],
            ['name' => 'The O2 Arena', 'address' => 'Peninsula Square, London, UK'],
            ['name' => 'Accor Arena', 'address' => '8 Boulevard de Bercy, Paris, France'],
            ['name' => 'Mercedes-Benz Arena', 'address' => 'Mercedes-Platz 1, Berlin, Germany'],
            ['name' => 'Ziggo Dome', 'address' => 'De Passage 100, Amsterdam, Netherlands'],
            ['name' => 'Altice Arena', 'address' => 'Rossio dos Olivais, Lisbon, Portugal'],
            ['name' => 'Palau Sant Jordi', 'address' => 'Passeig Olímpic 5, Barcelona, Spain'],
            ['name' => 'Royal Arena', 'address' => 'Hannemanns Allé 18, Copenhagen, Denmark'],
            ['name' => 'Staples Center', 'address' => '1111 S Figueroa St, Los Angeles, USA'],
            ['name' => 'Scotiabank Arena', 'address' => '40 Bay St, Toronto, Canada'],
        ];

        $locationIds = [];
        foreach ($locations as $loc) {
            $locationIds[] = Location::create($loc)->id;
        }

        $artists = [
            ['name' => 'Drake', 'genre' => 'Hip-Hop'],
            ['name' => 'Kendrick Lamar', 'genre' => 'Hip-Hop'],
            ['name' => 'Travis Scott', 'genre' => 'Hip-Hop'],
            ['name' => 'Post Malone', 'genre' => 'Hip-Hop'],
            ['name' => 'J. Cole', 'genre' => 'Hip-Hop'],
            ['name' => 'The Weeknd', 'genre' => 'R&B'],
            ['name' => 'Dua Lipa', 'genre' => 'Pop'],
            ['name' => 'Ed Sheeran', 'genre' => 'Pop'],
            ['name' => 'Billie Eilish', 'genre' => 'Pop'],
            ['name' => 'Bad Bunny', 'genre' => 'Reggaeton'],
        ];

        $artistIds = [];
        foreach ($artists as $art) {
            $artistIds[] = Artist::create($art)->id;
        }

        foreach ($artistIds as $index => $artistId) {
            $concert = Concert::create([
                'title' => $artists[$index]['name'] . ' Live Concert',
                'description' => 'Niesamowity występ na żywo artysty ' . $artists[$index]['name'] . '.',
                'tags' => 'music,live,concert',
                'location_id' => $locationIds[$index],
                'concert_date' => now()->addDays(rand(10, 100)),
                'ticket_limit' => rand(100, 500),
                'email' => strtolower(str_replace(' ', '', $artists[$index]['name'])) . '@musicfest.com',
                'website' => 'https://www.' . strtolower(str_replace(' ', '', $artists[$index]['name'])) . '.com',
                'user_id' => $admin->id,
            ]);

            $concert->artists()->attach($artistId);

            for ($j = 0; $j < $concert->ticket_limit; $j++) {
                $concert->tickets()->create([
                    'price' => rand(50, 200),
                ]);
            }
        }
    }
}
