<?php

namespace App\Observers;

use App\Models\Rental;
use Carbon\Carbon;

class RentalObserver
{
    /**
     * Handle the Rental "created" event.
     */
    public function created(Rental $rental): void
    {
        // isi
    }

    /**
     * Handle the Rental "updated" event.
     */
    public function updated(Rental $rental): void
    {
        if ($rental->isDirty('status') && $rental->status === 'ongoing') {

            $today = Carbon::today();
            $rentalDate = Carbon::parse($rental->rental_date)->startOfDay();

            if ($rentalDate->equalTo($today)) {

                $vehicle = $rental->vehicle;

                if ($vehicle) {
                    $vehicle->update([
                        'status' => 'rented'
                    ]);
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
