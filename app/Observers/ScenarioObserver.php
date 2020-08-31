<?php

namespace App\Observers;

use App\Scenario;

class ScenarioObserver
{
    /**
     * Handle the scenario "created" event.
     *
     * @param  \App\Scenario  $scenario
     * @return void
     */
    public function created(Scenario $scenario)
    {
        $scenario->recordActivity('scenario_created');
    }

    /**
     * Handle the scenario "updated" event.
     *
     * @param  \App\Scenario  $scenario
     * @return void
     */
    public function updated(Scenario $scenario)
    {
        $scenario->recordActivity('scenario_updated');
    }

    /**
     * Handle the scenario "deleted" event.
     *
     * @param  \App\Scenario  $scenario
     * @return void
     */
    public function deleted(Scenario $scenario)
    {
        $scenario->recordActivity('scenario_deleted');
    }

    /**
     * Handle the scenario "restored" event.
     *
     * @param  \App\Scenario  $scenario
     * @return void
     */
    public function restored(Scenario $scenario)
    {
        //
    }

    /**
     * Handle the scenario "force deleted" event.
     *
     * @param  \App\Scenario  $scenario
     * @return void
     */
    public function forceDeleted(Scenario $scenario)
    {
        //
    }
}
