<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use App\Repositories\ComAreaRepository;
use App\Interfaces\ComAreaInterface;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bindInterfaces();
    }


    private function bindInterfaces(): void
    {
        //$this->app->bind(ControllerInterface::class, BaseController::class);

        $repositoriesDir = app_path('Repositories');
        $interfaceDir = app_path('Interfaces');
        $repositoryFiles = File::files($repositoriesDir);
        foreach ($repositoryFiles as $file) {
            $repositoryFileName = pathinfo($file, PATHINFO_FILENAME);
            $interfaceName = str_replace('Repository', '', $repositoryFileName) . 'Interface';
            $interfacePath = $interfaceDir . DIRECTORY_SEPARATOR . $interfaceName . '.php';

            if (File::exists($interfacePath)) {
                $interface = 'App\Interfaces\\' . $interfaceName;
                $repository = 'App\Repositories\\' . $repositoryFileName;
                $this->app->bind($interface, $repository);
            }
        }

        //$this->app->bind('App\Interfaces\TranslationInterface', 'App\Repositories\TranslationRepository');

        //$this->app->bind(ComAreaInterface::class, ComAreaRepository::class);
        //$this->app->bind('App\Interfaces\ComAreaInterface', 'App\Repositories\ComAreaRepository');
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
