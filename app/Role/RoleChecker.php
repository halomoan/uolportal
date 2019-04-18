<?php
/**
 * Created by PhpStorm.
 * User: Halomoan
 * Date: 7/4/2019
 * Time: 10:33 PM
 */

namespace App\Role;
use App\User;

class RoleChecker
{
    /**
     * @param User $user
     * @param string $role
     * @return bool
     */
    public static function check($user, $role)
    {

        if (! $user instanceOf User) {
            return false;
        }
        // Admin has everything
        if ($user->hasRole(UserRole::ROLE_ADMIN)) {
            return true;
        }
        else if($user->hasRole(UserRole::ROLE_MANAGEMENT)) {
            $managementRoles = UserRole::getAllowedRoles(UserRole::ROLE_MANAGEMENT);

            if (in_array($role, $managementRoles)) {
                return true;
            }
        }


        return $user->hasRole($role);
    }
}