<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Kanuu\Laravel\Facades\Kanuu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Kanuu::getModelUsing(function ($identifier) {
            return User::findOrFail($identifier);
        });

        Kanuu::on('subscription_*', function ($payload, User $user) {
            $user->subscriptions()->updateOrCreate(
                [
                    'paddle_subscription_id' => $payload->subscription_id,
                ],
                [
                    'paddle_user_id' => $payload->user_id,
                    'paddle_plan_id' => $payload->subscription_plan_id,
                    'paddle_checkout_id' => $payload->checkout_id,
                    'status' => $payload->status,
                    'cancelled_at' => $payload->cancellation_effective_date ?? null,
                ]
            );
        });
    }
}
