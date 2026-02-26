<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\GuestEvent;
use App\Models\Invitation;
use App\Models\MessageTemplate;
use App\Models\Table;
use App\Models\User;
use App\Models\Wedding;
use App\Models\WeddingColor;
use App\Models\WeddingEvent;
use App\Models\WeddingPhoto;
use App\Models\WeddingService;
use Illuminate\Database\Seeder;

class WeddingDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@wedding.local'],
            [
                'name' => 'Wedding Admin',
                'phone_number' => '+243826869063',
                'password' => 'password',
                'is_active' => true,
            ]
        );

        $admin->assignRole('admin');

        $wedding = Wedding::query()->firstOrCreate(
            ['slug' => 'vincent-marie-demo'],
            [
                'groom_name' => 'Vincent',
                'bride_name' => 'Marie',
                'theme_color' => 'rose-gold',
                'created_by' => $admin->id,
            ]
        );

        foreach (range(1, 6) as $index) {
            WeddingPhoto::query()->firstOrCreate([
                'wedding_id' => $wedding->id,
                'photo_url' => 'https://picsum.photos/seed/wedding-' . $index . '/1400/1000',
            ]);
        }

        $eventsData = [
            [
                'name' => 'Mariage coutumier',
                'description' => 'Cérémonie traditionnelle en famille.',
                'event_date' => now()->addDays(20)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '12:30:00',
                'location' => 'Résidence familiale, Kinshasa',
                'is_public' => false,
                'max_guests' => 50,
            ],
            [
                'name' => 'Mariage civil',
                'description' => 'Cérémonie à la maison communale.',
                'event_date' => now()->addDays(27)->toDateString(),
                'start_time' => '11:00:00',
                'end_time' => '13:00:00',
                'location' => 'Maison Communale de Gombe',
                'is_public' => true,
                'max_guests' => 50,
            ],
            [
                'name' => 'Discours - Salle du Royaume',
                'description' => 'Discours de 30 minutes.',
                'event_date' => now()->addDays(30)->toDateString(),
                'start_time' => '16:00:00',
                'end_time' => '16:30:00',
                'location' => 'Salle du Royaume, Avenue Génèse, Bon Marché',
                'is_public' => true,
                'max_guests' => 500,
            ],
            [
                'name' => 'Réception privée',
                'description' => 'Soiree privee avec invitation.',
                'event_date' => now()->addDays(30)->toDateString(),
                'start_time' => '19:00:00',
                'end_time' => '23:00:00',
                'location' => 'Le Bellevue Event Hall',
                'is_public' => false,
                'max_guests' => 300,
            ],
        ];

        $events = collect();
        foreach ($eventsData as $eventData) {
            $event = WeddingEvent::query()->firstOrCreate([
                'wedding_id' => $wedding->id,
                'name' => $eventData['name'],
            ], $eventData);
            $events->push($event);
        }

        foreach ($events as $event) {
            foreach (['rose-gold', 'blue', 'green', 'black'] as $color) {
                WeddingColor::query()->firstOrCreate([
                    'wedding_event_id' => $event->id,
                    'color' => $color,
                ]);
            }
        }

        foreach ($events as $event) {
            foreach (['Accueil', 'Protocole', 'Restauration'] as $serviceName) {
                WeddingService::query()->firstOrCreate([
                    'wedding_event_id' => $event->id,
                    'name' => $serviceName,
                ], [
                    'description' => 'Equipe ' . $serviceName,
                ]);
            }
        }

        foreach (['save_the_date', 'invitation'] as $type) {
            MessageTemplate::query()->firstOrCreate([
                'wedding_id' => $wedding->id,
                'type' => $type,
            ], [
                'content' => 'Message ' . $type . ' pour ' . $wedding->groom_name . ' et ' . $wedding->bride_name,
            ]);
        }

        $tables = [
            "Paris",
            "Londres",
            "Berlin",
            "Moscou",
            "Tokyo",
            "Mexico",
            "Madrid",
            "Dakar",
            "Athènes",
            "Lisbonne",
            "Rome",
            "New York",
            "Rio",
            "Sydney",
            "Venise",
            "Prague",
            "Istanbul",
            "Marrakech",
            "Montréal",
            "Barcelone",
            "Vienne",
            "Budapest",
            "Amsterdam",
            "Séoul",
            "Le Caire"
        ];

        foreach ($tables as $table) {
            Table::query()->firstOrCreate([
                'name' => $table,
                'max_guests' => fake()->randomElement(['4', '6', '8', '10']),
                'status' => fake()->randomElement([Table::FREE_STATUS, Table::FULL_STATUS]),
            ]);
        }

        foreach (range(1, 12) as $i) {
            $invitation = Invitation::query()->create([
                'token' => bin2hex(random_bytes(32)),
                'max_guests' => 1,
                'table_id' => fake()->randomElement(Table::pluck('id')),
                'status' => Invitation::STATUS_PENDING,
            ]);

            $guest = Guest::query()->create([
                'invitation_id' => $invitation->id,
                'full_name' => fake()->name(),
                'phone_number' => fake()->phoneNumber(),
            ]);

            foreach ($events as $event) {
                if (!$event->is_public && fake()->boolean(40) === false) {
                    continue;
                }

                $service = WeddingService::query()->where('wedding_event_id', $event->id)->inRandomOrder()->first();

                GuestEvent::query()->firstOrCreate([
                    'wedding_event_id' => $event->id,
                    'guest_id' => $guest->id,
                ], [
                    'is_confirmed' => fake()->boolean(50),
                    'role_type' => fake()->randomElement(array: ['family', 'guest']),
                    'wedding_service_id' => $service?->id,
                ]);
            }

            $invitation->refreshStatusFromGuestEvents();
        }
    }
}
