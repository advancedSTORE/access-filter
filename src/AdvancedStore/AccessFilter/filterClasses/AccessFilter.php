<?php
/**
 * Created by PhpStorm.
 * User: AS-LS
 * Date: 26.05.14
 * Time: 16:04
 */
namespace AdvancedStore\AccessFilter\filterClasses;
use ad4mat\administration\User;
class AccessFilter
{
    private $permissionsSet = null;
    private $userPermissions = null;


    public function __construct( $userPermissions = [] ){
        $this->userPermissions = $userPermissions;
    }

    public function filter( ){

        $this->permissionsSet = $this->loadPermissionSet( \Route::getCurrentRoute()->getName() );
        if( $this->performAccessCheck() === false ){

            return \Redirect::back()    ->with('errorMessage', \Config::get("access-filter::accessFilterConfig.errorMessage"))
                ->with('errorType', 'danger');
        }

    }

    /**
     * @param $routeName simple route name which is used to access the config array.
     * Loads the pre defined permission set which is required to access this route/action.
     */
    private function loadPermissionSet( $routeName ){
        return \Config::get("access-filter::permissionList.{$routeName}");
    }

    /**
     * @param $user
     * @return array
     * Extract and merge all user permissions from user roles(groups) and partner roles
     * into a single array with unique values.
     */
    private function extractUserPermissions( $user ){
        $groupPermissions = $this->getAppPermissions( $user->groups );
        $partnerPermissions = $this->getAppPermissions( $user->partnerRoles );

        $userPermissions = array_merge( $groupPermissions, $partnerPermissions );

        return array_unique( $userPermissions );
    }

    private function getAppPermissions( $userRoles ){

        $permissionArray = [];

        foreach( $userRoles as $role ){
            foreach( $role->appPermissions->toArray() as $appPermission ){
                $permissionArray[] = $appPermission['appPermissionName'];
            }
        }

        return $permissionArray;
    }

    public function hasPermission( $appPermission ){
        // check exact permission for current user
        // check if user has higher permission
        // if first or second applies return true

        if( $this->checkArray( $appPermission ))
            return true;

        if( $this->checkString( $appPermission ))
            return true;

        if( $this->checkPlaceHolder( $appPermission ) )
            return true;

        return false;
    }

    private function checkPlaceHolder( $appPermission ){
        /**
         * todo : wenn die länge gleich ist, reduziere beide arrays, vergleiche die strings
         */

        foreach( $this->userPermissions as $userPermission ){
            if( $this->arePermissionEqual($userPermission, $appPermission) )
                return true;
        }

        return false;
    }

    private function arePermissionEqual($userPermission, $appPermission){

        $userPermissionArray = explode( '.', $userPermission );
        $appPermissionArray = explode( '.', $appPermission );

        if( count($appPermissionArray) == count($userPermissionArray) ){
            do{
                array_pop( $appPermissionArray );
                array_pop( $userPermissionArray );

                if( implode('.',$appPermissionArray) == implode('.',$userPermissionArray) )
                    return true;
            }while( count($appPermissionArray) >= 3 );

        }else{
            return false;
        }
    }


    private function checkArray( $appPermission ){

        if( in_array( $appPermission, $this->userPermissions ) )
            return true;

        return false;
    }

    private function checkString( $appPermission ){

        $appPermissionArray = explode('.',$appPermission );

        do{
            array_pop( $appPermissionArray  );
            if( in_array( implode('.', $appPermissionArray), $this->userPermissions ) )
                return true;
        }while( count( $appPermissionArray ) >= 2 );

        return false;
    }

    /**
     * permissionsSet must not be empty!
     * For a given route and / or action at least one permission must be defined
     * in the accessFilter/permissionList.php.
     */

    protected function performAccessCheck(){

        if( !is_array( $this->permissionsSet ) )
            $this->permissionsSet = [];

        foreach( $this->permissionsSet as $appPermission ){
            if( $this->hasPermission( $appPermission ) )
                return true;
        }

        return false;
    }
}