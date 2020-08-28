<?php

namespace App\Providers;

use App\Observers\ProjectObserver;
use App\Observers\ScenarioObserver;
use App\Project;
use App\Scenario;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Project' => 'App\Policies\ProjectPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Project::observe(ProjectObserver::class);
        Scenario::observe(ScenarioObserver::class);
    }
}
