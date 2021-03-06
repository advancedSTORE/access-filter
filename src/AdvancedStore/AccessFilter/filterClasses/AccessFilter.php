<?php
/**
 * Created by PhpStorm.
 * User: AS-LS
 * Date: 26.05.14
 * Time: 16:04
 */
namespace AdvancedStore\AccessFilter\filterClasses;
use App\Models\User;
class AccessFilter
{
    private $permissionsSet = null;
    private $userPermissions = null;

    private static $PERMISSION_LIST = null;

    public function __construct( $userPermissions = [] ){
        $this->loadPermissions();
        if ($userPermissions === null) {
            $this->userPermissions = self::$PERMISSION_LIST;
        } else {
            $this->userPermissions = array_unique(array_merge(self::$PERMISSION_LIST, $userPermissions));
        }
    }

    public function filter( ){

        $this->permissionsSet = self::$PERMISSION_LIST[( \Route::getCurrentRoute()->getName() )];
        if( $this->performAccessCheck() === false ){

            return \Redirect::back()->with(\SystemMessage::getMessageBladeKey(),
                \SystemMessage::danger(\Config::get("accessFilterConfig.errorMessage")));
        }

    }

    /**
     * @param $routeName simple route name which is used to access the config array.
     * Loads the pre defined permission set which is required to access this route/action.
     */
    private function loadPermissions(){
        if(self::$PERMISSION_LIST === null){
            self::$PERMISSION_LIST = \ApiClient::getUserPermissions();
        }
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
                $permissionArray[] = $appPermission['app_permission_name'];
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
            if( $this->arePermissionsEqual($userPermission, $appPermission) )
                return true;
        }

        return false;
    }

    private function arePermissionsEqual($userPermission, $appPermission){


        $userPermissionArray = explode( '.', $userPermission );
        $appPermissionArray = explode( '.', $appPermission );

        if( count($appPermissionArray) == count($userPermissionArray) ){
            do{

                if( implode('.',$appPermissionArray) == implode('.',$userPermissionArray) )
                    return true;

                array_pop( $appPermissionArray );
                array_pop( $userPermissionArray );

            }while( count($appPermissionArray) >= 4 );
        }

        return false;
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