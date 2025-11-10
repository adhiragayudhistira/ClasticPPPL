protected function schedule(Schedule $schedule)
{
    $schedule->command('clastic:report-pickups')->daily();
    $schedule->command('clastic:award-mission-points')->dailyAt('02:00');
    $schedule->command('clastic:cleanup-views --days=90')->weekly();
}