<?php
/**
 * Created by PhpStorm.
 * User: AS-LS
 * Date: 26.05.14
 * Time: 16:22
 */
namespace AdvancedStore\AccessFilter\Facades;
use Illuminate\Support\Facades\Facade;

class AccessFilterFacade extends Facade {

    protected static function getFacadeAccessor() { return 'accessFilter'; }

}