<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\MD5Hasher;

class MD5HashServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('hash', function(){
            return new MD5Hasher;
        });
    }

    public function provides(){
        return ['hash'];
    }
}
