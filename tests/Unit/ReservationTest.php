<?php

namespace Tests\Unit;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    public function test_a_reservation_belonge_to_lesson()
    {
        $reservation = new Reservation();
        $relationship = $reservation->lesson();
        $this->assertInstanceOf(BelongsTo::class, $relationship);
    }
}
