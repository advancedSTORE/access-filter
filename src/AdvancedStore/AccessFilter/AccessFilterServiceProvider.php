<?php
namespace AdvancedStore\AccessFilter;

use Illuminate\Support\ServiceProvider;
use AdvancedStore\AccessFilter\filterClasses\AccessFilter;

class AccessFilterServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('advanced-store/access-filter');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
        $this->registerAccessFilter();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

    private function registerAccessFilter(){
        $this->app['accessFilter'] = $this->app->share(function($app){
            return new AccessFilter();
        });
    }

}
