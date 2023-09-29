<?php

namespace App\Providers;

use App\Enums\SearchMatchType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $whereLike = function ($column, $value, $matchType = SearchMatchType::BOTH) {

            $escapedValue = str_replace(['%', '_', '\\'], ['\%', '\_', '\\\\'], $value);

            $searchValue = match ($matchType) {
                SearchMatchType::PREFIX => "%$escapedValue",
                SearchMatchType::SUFFIX => "$escapedValue%",
                SearchMatchType::BOTH => "%$escapedValue%"
            };

            /** @var Builder $this */
            return $this->where($column, 'LIKE', $searchValue);
        };

        Builder::macro('whereLike', $whereLike);

        // Normally this would be elsewhere in a controller, but for simplicity, just use it here.
        User::whereLike('name', 'foo')->get();
    }
}
