<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 7/4/2019
 * Time: 10:27 PM
 */

namespace App\Role;


class UserRole
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MANAGEMENT = 'ROLE_MANAGEMENT';
    const ROLE_FINANCE = 'ROLE_FINANCE';
    const ROLE_HRD = 'ROLE_HRD';
    const ROLE_SAPCC = 'ROLE_SAPCC';
    const ROLE_PUBLIC = 'ROLE_PUBLIC';

    protected static $roleHierarchy = [
        self::ROLE_ADMIN => ['*'],
        self::ROLE_MANAGEMENT => [
            self::ROLE_HRD,
            self::ROLE_FINANCE,
            self::ROLE_PUBLIC,
        ],
        self::ROLE_HRD => [
            self::ROLE_PUBLIC
        ],
        self::ROLE_FINANCE => [
            self::ROLE_PUBLIC
        ],
        self::ROLE_SAPCC => [
            self::ROLE_PUBLIC
        ],
        self::ROLE_PUBLIC => []
    ];

    /**
     * @param string $role
     * @return array
     */
    public static function getAllowedRoles($role)
    {
        if (isset(self::$roleHierarchy[$role])) {
            return self::$roleHierarchy[$role];
        }

        return [];
    }

    /***
     * @return array
     */
    public static function getRoleList()
    {
        return [
            static::ROLE_ADMIN =>'Admin',
            static::ROLE_MANAGEMENT => 'Management',
            static::ROLE_HRD => 'HRD',
            static::ROLE_FINANCE => 'Finance',
            static::ROLE_SAPCC => 'SAPCC',
            static::ROLE_PUBLIC => 'Public',
        ];
    }

}