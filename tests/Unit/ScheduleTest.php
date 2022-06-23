<?php

namespace Tests\Unit;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    public function test_a_schedule_has_many_lessons()
    {
        $schedule = new Schedule();
        $this->assertInstanceOf(Collection::class, $schedule->lessons);
    }
}
