<?php

namespace App\Observers;

use App\Models\Car;
use App\Models\Rental;

class RentalObserver
{
    /**
     * Handle the Rental "created" event.
     */
    public function created(Rental $rental): void
    {
        $car = Car::find($rental->car_id);
        if ($car) {
            $car->update(['status' => 'rented']);
        }
    }

    /**
     * Handle the Rental "updated" event.
     */
    public function updated(Rental $rental): void
    {
        if ($rental->isDirty('status')) {
            $newStatus = $rental->status;

            if (in_array($newStatus, ['completed', 'cancelled'])) {
                $car = Car::find($rental->car_id);
                if ($car) {
                    $car->update(['status' => 'available']);
                }
            }
        }
    }

    /**
     * Handle the Rental "deleted" event.
     */
    public function deleted(Rental $rental): void
    {
        //
    }

    /**
     * Handle the Rental "restored" event.
     */
    public function restored(Rental $rental): void
    {
        //
    }

    /**
     * Handle the Rental "force deleted" event.
     */
    public function forceDeleted(Rental $rental): void
    {
        //
    }
}
