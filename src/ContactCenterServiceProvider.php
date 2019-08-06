<?php

namespace Eduzz\ContactCenter;

use Eduzz\ContactCenter\ContactCenter;
use Illuminate\Support\ServiceProvider;

class ContactCenterServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/Config/contactcenter.php' => $this->getConfigPath('contactcenter.php'),
            ], 'config'
        );
    }

    public function register()
    {
        $this->app->bind('Eduzz\ContactCenter\ContactCenter', function ($app) {
            $contactCenter = new ContactCenter($this->getConfiguration());
            return $contactCenter;
        }
        );
    }

    /**
     * Get the configuration file path.
     *
     * @param string $path
     * @return string
     */
    private function getConfigPath($path = '')
    {
        return $this->app->basePath() . '/config' . ($path ? '/' . $path : $path);
    }

    /**
     * Get the default clientHttp (default: Guzzle)
     *
     * @return void
     */
    private function getConfiguration()
    {
        return config('contactcenter');
    }

    public function provides()
    {
        return [ContactCenter::class];
    }
}
