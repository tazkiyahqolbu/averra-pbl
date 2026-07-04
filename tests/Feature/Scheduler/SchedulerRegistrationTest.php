<?php

namespace Tests\Feature\Scheduler;

use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

class SchedulerRegistrationTest extends TestCase
{
    public function test_commands_are_registered_in_schedule()
    {
        $schedule = $this->app->make(Schedule::class);
        $events = collect($schedule->events());
        
        $autoCancel = $events->contains(fn($event) => str_contains($event->command, 'pemesanan:auto-cancel'));
        $updateStatus = $events->contains(fn($event) => str_contains($event->command, 'sewa:update-status'));
        $reminder = $events->contains(fn($event) => str_contains($event->command, 'reminder:pengembalian'));

        $this->assertTrue($autoCancel, 'pemesanan:auto-cancel is not registered');
        $this->assertTrue($updateStatus, 'sewa:update-status is not registered');
        $this->assertTrue($reminder, 'reminder:pengembalian is not registered');
    }
}
