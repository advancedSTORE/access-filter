<?php
/**
 * Created by PhpStorm.
 * User: AS-LS
 * Date: 26.05.14
 * Time: 18:45
 *
 * At least one appPermission is needed to access the given route
 * which is the key in the first dimension of the array.
 * The certain check for what data the user get presented will be
 * decided inside of the controller.
 */


return [
    // TEST ROUTE just as example
    'test'              =>  [
        'ad4mat.test',
    ],
    'admin.dashboard'   => [
        'ad4mat.admin.dashboard',
    ],
    // ROLES / GROUPS
    'admin.groups.index' =>  [
        'ad4mat.admin.roles.read',
        'ad4mat.admin.roles.self',
        'ad4mat.admin.roles.ownRoles',
    ],
    'admin.groups.edit' =>  [
        'ad4mat.admin.roles.edit',
        'ad4mat.admin.roles.self',
        'ad4mat.admin.roles.ownRoles',
    ],
    'admin.groups.create' =>  [
        'ad4mat.admin.roles.create',
    ],
    'admin.groups.update' =>  [
        'ad4mat.admin.roles.update',
    ],
    // USERS
    'admin.users.index' =>  [
        'ad4mat.admin.users.read',
        'ad4mat.admin.users.self',
    ],
    'admin.users.edit' =>  [
        'ad4mat.admin.users.edit',
        'ad4mat.admin.users.edit.self',
        'ad4mat.admin.users.edit.ownUsers',
    ],
    'admin.users.create' =>  [
        'ad4mat.admin.users.create',
    ],
    'admin.users.update' =>  [
        'ad4mat.admin.users.update',
    ],
    // PARTNERS
    'admin.partners.index' =>  [
        'ad4mat.admin.partners.read',
        'ad4mat.admin.partners.self',
        'ad4mat.admin.partners.ownPartners',
    ],
    'admin.partners.edit' =>  [
        'ad4mat.admin.partners.edit',
        'ad4mat.admin.partners.edit.self',
        'ad4mat.admin.partners.edit.ownPartners',
    ],
    'admin.partners.create' =>  [
        'ad4mat.admin.partners.create',
    ],
    'admin.partners.update' =>  [
        'ad4mat.admin.partners.update',
    ],
    // PARTNERROLES
    'admin.partnerRoles.index' =>  [
        'ad4mat.admin.partnerRoles.read',
        'ad4mat.admin.partnerRoles.self',
        'ad4mat.admin.partnerRoles.ownPartnerRoles',
    ],
    [
        'admin.partnerRoles.edit'   =>  [
            'ad4mat.admin.partnerRoles.edit',
        ],
    ],
    [
        'admin.partnerRoles.create'   =>  [
            'ad4mat.admin.partnerRoles.create',
        ],
    ],
    [
        'admin.partnerRoles.update'   =>  [
            'ad4mat.admin.partnerRoles.update',
        ],
    ],
    // APPS
    'admin.apps.index' =>  [
        'ad4mat.admin.apps.read',
        'ad4mat.admin.apps.self',
        'ad4mat.admin.apps.ownApps',
    ],
    'admin.apps.edit' =>  [
        'ad4mat.admin.apps.edit',
    ],
    'admin.apps.create' =>  [
        'ad4mat.admin.apps.create',
    ],
    'admin.apps.update' =>  [
        'ad4mat.admin.apps.update',
    ],
    // APPPERMISSIONS
    'admin.appPermissions.index' =>  [
        'ad4mat.admin.appPermissions.read',
    ],
    'admin.appPermissions.edit' =>  [
        'ad4mat.admin.appPermissions.edit',
    ],
    'admin.appPermissions.create' =>  [
        'ad4mat.admin.appPermissions.create',
    ],
    'admin.appPermissions.update' =>  [
        'ad4mat.admin.appPermissions.update',
    ],
    // OAUTH
    'admin.oauthScopes.index' =>  [
        'ad4mat.admin.oauthScopes.read',
    ],
    'admin.oauthScopes.edit' =>  [
        'ad4mat.admin.oauthScopes.edit',
    ],
    'admin.oauthScopes.create' =>  [
        'ad4mat.admin.oauthScopes.create',
    ],
    'admin.oauthScopes.update' =>  [
        'ad4mat.admin.oauthScopes.update',
    ],

];