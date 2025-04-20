<?php

namespace App\Providers;

use App\Repository\Schedule\ScheduleRepository;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Repository\Schedule\ScheduleScheduleStatusRepository;
use App\Repository\Schedule\ScheduleScheduleStatusRepositoryInterface;
use App\Repository\Team\TeamRepository;
use App\Repository\Team\TeamRepositoryInterface;
use App\Repository\Test\TestRepository;
use App\Repository\Test\TestRepositoryInterface;
use App\Repository\User\UserRepository;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(ScheduleRepositoryInterface::class, ScheduleRepository::class);
        $this->app->bind(ScheduleScheduleStatusRepositoryInterface::class, ScheduleScheduleStatusRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
