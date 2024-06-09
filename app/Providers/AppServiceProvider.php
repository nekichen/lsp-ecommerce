<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Events\MigrationsEnded;

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
        Event::listen(MigrationsEnded::class, function () {
            $directory = 'images/products';

            // Check if the directory exists
            if (Storage::disk('public')->exists($directory)) {
                // Clear the directory
                Storage::disk('public')->deleteDirectory($directory);
                // Recreate the directory
                Storage::disk('public')->makeDirectory($directory);

                info('Product images directory cleared successfully.');
            } else {
                // Directory does not exist, so no need to clear it
                info('Product images directory does not exist.');
            }
        });
    }
}
