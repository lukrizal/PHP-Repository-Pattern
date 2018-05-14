<?php
namespace App\Providers;
use App\Business\Order\Repositories\RepositoryInterface;
use App\Business\Order\Repositories\FromApi;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            RepositoryInterface::class,
            function () {
                // automatically identify the provider that need to be use based on the current env configuration
                $apiUri = env('ORDER_REPOSITORY_URL', false);
                if (!empty($apiUri)) {
                    return new FromApi($apiUri);
                }
                // TODO: Implement from database provider here
                throw new \Exception('No provider defined.');
            }
        );
    }
}