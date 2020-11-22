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
            // Data available on all subscription events.
            $data = [
                'paddle_user_id' => $payload->user_id,
                'paddle_plan_id' => $payload->subscription_plan_id,
                'paddle_checkout_id' => $payload->checkout_id,
                'status' => $payload->status,
            ];

            // The `cancellation_effective_date` is only available on the `subscription_cancelled` event.
            if (isset($payload->cancellation_effective_date)) {
                $data['cancelled_at'] = $payload->cancellation_effective_date;
            }

            // Create or update based on the paddle subscription_id.
            $user->subscriptions()->updateOrCreate(
                ['paddle_subscription_id' => $payload->subscription_id], $data
            );
        });
    }
}
