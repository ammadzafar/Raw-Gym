<?php

namespace App\Observers;

use App\Models\Fee;

class FeeObserver
{
    /**
     * Handle the fee "created" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function created(Fee $fee)
    {
        $fee->collected_by = auth()->id();
        $fee->save();
    }

    /**
     * Handle the fee "updated" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function updated(Fee $fee)
    {
        //
    }

    /**
     * Handle the fee "deleted" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function deleted(Fee $fee)
    {
        //
    }

    /**
     * Handle the fee "restored" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function restored(Fee $fee)
    {
        //
    }

    /**
     * Handle the fee "force deleted" event.
     *
     * @param  \App\Models\Fee  $fee
     * @return void
     */
    public function forceDeleted(Fee $fee)
    {
        //
    }
}
