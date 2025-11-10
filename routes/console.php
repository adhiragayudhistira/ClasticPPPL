<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\PickupOrder;
use App\Models\PlasticClassification;
use App\Models\UserMission;
use App\Models\Transaction;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 1. Generate daily pickup report
Artisan::command('clastic:report-pickups', function () {
    $today = now()->format('Y-m-d');
    $count = PickupOrder::whereDate('scheduled_at', $today)->count();
    $weight = PickupOrder::whereDate('scheduled_at', $today)->sum('weight_kg');

    $this->info("Pickup Report for {$today}");
    $this->table(
        ['Orders', 'Total Weight (kg)'],
        [[$count, $weight]]
    );
})->purpose('Show today\'s pickup orders and total plastic collected');

// 2. Sync plastic classification rules (e.g., from CSV or API)
Artisan::command('clastic:sync-plastics', function () {
    $this->info('Syncing plastic classification rules...');

    // Example: Load from JSON file in storage
    $path = storage_path('app/plastics.json');
    if (!file_exists($path)) {
        $this->error('File not found: storage/app/plastics.json');
        return;
    }

    $data = json_decode(file_get_contents($path), true);
    foreach ($data as $item) {
        PlasticClassification::updateOrCreate(
            ['code' => $item['code']],
            [
                'name' => $item['name'],
                'recyclable' => $item['recyclable'],
                'points_per_kg' => $item['points_per_kg'],
            ]
        );
    }

    $this->info('Plastic classifications synced successfully!');
})->purpose('Sync plastic types and point values from JSON');

// 3. Award points for completed missions
Artisan::command('clastic:award-mission-points', function () {
    $completed = UserMission::where('status', 'completed')
        ->where('points_awarded', false)
        ->with('mission')
        ->get();

    foreach ($completed as $userMission) {
        $user = $userMission->user;
        $points = $userMission->mission->reward_points;

        $user->increment('points', $points);

        // Record transaction
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'mission_reward',
            'points' => $points,
            'description' => "Mission: {$userMission->mission->title}",
        ]);

        $userMission->update(['points_awarded' => true]);
    }

    $this->info("Awarded points to {$completed->count()} users.");
})->purpose('Give points to users who completed missions');

// 4. Clean up old article views (analytics retention)
Artisan::command('clastic:cleanup-views {--days=30}', function ($days) {
    $cutoff = now()->subDays($days);
    $deleted = \App\Models\UserArticleView::where('created_at', '<', $cutoff)->delete();

    $this->info("Deleted {$deleted} article views older than {$days} days.");
})->purpose('Remove old article view analytics');

// 5. Reset demo data (for testing)
Artisan::command('clastic:reset-demo', function () {
    if (app()->environment() !== 'local') {
        $this->error('This command can only run in local environment!');
        return;
    }

    $this->call('migrate:fresh', ['--seed' => true]);
    $this->info('Demo data reset complete!');
})->purpose('Reset database with demo data (local only)');