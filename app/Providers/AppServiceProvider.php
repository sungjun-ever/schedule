<?php

namespace App\Providers;

use App\Repository\ScheduleComment\ScheduleCommentRepositoryInterface;
use App\Repository\ScheduleComment\ScheduleCommentRepository;
use App\Repository\Schedule\ScheduleRepository;
use App\Repository\Schedule\ScheduleRepositoryInterface;
use App\Repository\ScheduleParticipant\ScheduleParticipantRepository;
use App\Repository\ScheduleParticipant\ScheduleParticipantRepositoryInterface;
use App\Repository\ScheduleStatus\ScheduleScheduleStatusRepository;
use App\Repository\ScheduleStatus\ScheduleScheduleStatusRepositoryInterface;
use App\Repository\Team\TeamRepository;
use App\Repository\Team\TeamRepositoryInterface;
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
        $this->app->bind(ScheduleParticipantRepositoryInterface::class, ScheduleParticipantRepository::class);
        $this->app->bind(ScheduleCommentRepositoryInterface::class, ScheduleCommentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
