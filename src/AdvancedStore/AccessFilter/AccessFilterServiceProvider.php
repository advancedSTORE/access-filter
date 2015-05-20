<?php
namespace AdvancedStore\AccessFilter;

use Illuminate\Support\ServiceProvider;
use AdvancedStore\AccessFilter\filterClasses\AccessFilter;

class AccessFilterServiceProvider extends ServiceProvider {

    const PACKAGE_NAME = 'access-filter';
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
        $this->mergeConfigFrom(
            __DIR__.'/../config/accessFilterConfig.php',
            self::PACKAGE_NAME
		);
		$this->publisshes([
			__DIR__.'../AccessFilter/'
		], self::PACKAGE_NAME);
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
            $userPermissions = \Config::get('access-filter::accessFilterConfig.userPermissions');
            return new AccessFilter( $userPermissions );
        });
    }

}
