<?php

namespace Database\Factories;

use App\Models\TicketDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;


class TicketDetailFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::inRandomOrder()->first()?->id ?? Ticket::factory(),
            'attachment_path' => fake()->optional()->filePath(),
            'more_information' => [
                'browser' => fake()->randomElement([
                    'Chrome',
                    'Firefox',
                    'Edge',
                    'Safari',
                ]),

                'operating_system' => fake()->randomElement([
                    'Windows 11',
                    'Ubuntu 24.04',
                    'macOS',
                ]),

                'priority' => fake()->randomElement([
                    'low',
                    'medium',
                    'high',
                    'critical',
                ]),

                'estimated_hours' => fake()->numberBetween(1, 40),
            ],
            'start_date' => fake()->optional()->dateTimeBetween('-1 month', 'now'),
            'end_date' => fake()->optional()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
