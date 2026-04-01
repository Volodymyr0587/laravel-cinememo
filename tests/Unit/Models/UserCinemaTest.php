<?php

use App\Models\ContentItem;
use App\Models\User;

describe('cinema level', function () {

    it('returns beginner level for 1 item', function () {
        $user = User::factory()->create();

        ContentItem::factory()->count(1)->create([
            'user_id' => $user->id,
        ]);

        $level = $user->fresh()->cinema_level;

        expect($level['count'])->toBe(1)
            ->and($level['min'])->toBe(1)
            ->and($level['toNext'])->toBe(10) // до 11
            ->and($level['nextLevel'])->not->toBeNull();
    });

    it('returns master level when user has 101 items', function () {
        $user = User::factory()->create();

        ContentItem::factory()->count(101)->create([
            'user_id' => $user->id,
        ]);

        $level = $user->fresh()->cinema_level;

        expect($level['count'])->toBe(101)
            ->and($level['toNext'])->toBeNull()
            ->and($level['nextLevel'])->toBeNull();
    });

    it('returns empty level when no items', function () {
        $user = User::factory()->create();

        $level = $user->cinema_level;

        expect($level['count'])->toBe(0)
            ->and($level['level'])->toBeNull()
            ->and($level['toNext'])->toBe(1);
    });

});

describe('cinema levels list', function () {

    it('marks levels as unlocked correctly', function () {
        $user = User::factory()->create();

        ContentItem::factory()->count(30)->create([
            'user_id' => $user->id,
        ]);

        $levels = $user->fresh()->cinema_levels;

        expect($levels)->toHaveCount(5);

        // beginner
        expect($levels[0]['unlocked'])->toBeTrue();

        // enthusiast (11)
        expect($levels[1]['unlocked'])->toBeTrue();

        // cinephile (26)
        expect($levels[2]['unlocked'])->toBeTrue();

        // archivist (51)
        expect($levels[3]['unlocked'])->toBeFalse();
    });

    it('marks current level correctly', function () {
        $user = User::factory()->create();

        ContentItem::factory()->count(30)->create([
            'user_id' => $user->id,
        ]);

        $levels = $user->fresh()->cinema_levels;

        $current = collect($levels)->firstWhere('current', true);

        expect($current)->not->toBeNull();
    });

});
