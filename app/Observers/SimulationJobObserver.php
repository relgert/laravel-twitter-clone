<?php

namespace App\Observers;

use App\Models\SimulationJob;
use App\Events\JobUpdateEvent;

class SimulationJobObserver
{
    /**
     * Handle the SimulationJob "created" event.
     */
    public function created(SimulationJob $simulationJob): void
    {
        JobUpdateEvent::dispatch($simulationJob);
    }

    /**
     * Handle the SimulationJob "updated" event.
     */
    public function updated(SimulationJob $simulationJob): void
    {
        JobUpdateEvent::dispatch($simulationJob);
    }

    /**
     * Handle the SimulationJob "deleted" event.
     */
    public function deleted(SimulationJob $simulationJob): void
    {
        //
    }

    /**
     * Handle the SimulationJob "restored" event.
     */
    public function restored(SimulationJob $simulationJob): void
    {
        //
    }

    /**
     * Handle the SimulationJob "force deleted" event.
     */
    public function forceDeleted(SimulationJob $simulationJob): void
    {
        //
    }
}
