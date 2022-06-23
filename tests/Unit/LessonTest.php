<?php

namespace Tests\Unit;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class LessonTest extends TestCase
{
    public function test_a_lesson_belonge_to_schedule()
    {
        $lesson = new Lesson();
        $relationship = $lesson->schedule();
        $this->assertInstanceOf(BelongsTo::class, $relationship);
    }

    public function test_a_lesson_has_many_reservations()
    {
        $lesson = new Lesson();
        $relationship = $lesson->reservations;
        $this->assertInstanceOf(Collection::class, $relationship);
    }
}
