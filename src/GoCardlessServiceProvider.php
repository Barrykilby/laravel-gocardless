<?php
namespace Breaktag\GoCardless;

use Illuminate\Support\ServiceProvider;

class GoCardlessServiceProvider extends ServiceProvider
{

	private $config = 'gocardless.php';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		$this->publishes([
			__DIR__ . '/../config.php' => config_path($this->config),
		]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		// Use the published configuration file if it exists.
		if(file_exists(config_path($this->config))) {
			$configPath = config_path($this->config);
			$config = include $configPath;
		} else {
			// Use the default package configuration as a fallback.
			$config = include __DIR__ . '/../config.php';
		}

		$this->app->bind('GoCardlessClient', function () use ($config) {
		    return new \GoCardlessPro\Client($config);
		});
    }
}
