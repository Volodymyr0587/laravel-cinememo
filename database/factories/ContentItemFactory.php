<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\ContentItem;
use App\Models\ContentType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContentItemFactory extends Factory
{
    protected $model = ContentItem::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'user_id' => User::factory(),
            'content_type_id' => ContentType::factory(),

            'title' => $title,
            'original_title' => fake()->optional()->sentence(3),
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 9999),

            'description' => fake()->optional()->paragraph(),
            'video_url' => fake()->optional()->url(),
            'video_id' => fake()->optional()->regexify('[A-Za-z0-9]{11}'),

            'duration_in_seconds' => fake()->optional()->numberBetween(60, 7200),
            'release_date' => fake()->optional()->date(),

            'number_of_seasons' => fake()->optional()->numberBetween(1, 10),
            'season_number' => fake()->optional()->numberBetween(1, 10),
            'number_of_series_of_season' => fake()->optional()->numberBetween(1, 24),

            'country_of_origin' => fake()->optional()->country(),
            'language' => fake()->optional()->languageCode(),

            'image' => fake()->optional()->imageUrl(),

            'status' => fake()->randomElement(ContentStatus::values()),
            'is_public' => fake()->boolean(),

            'deleted_at' => null,
        ];
    }
}
