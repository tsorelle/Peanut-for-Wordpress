<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/30/2017
 * Time: 7:17 AM
 */

namespace Tops\wordpress;

use Tops\cache\ITopsCache;
use Tops\cache\TSessionCache;
use Tops\sys\IUser;
use Tops\sys\TAbstractUser;
use Tops\sys\TStrings;
use Tops\sys\TUser;
use WP_User;

/**
 * Class TConcrete5User
 * @package Tops\sys
 *
 */
class TWordpressUser extends TAbstractUser
{
    const WordpressAdminRole = 'administrator';
    private $profileCache = array();

    /**
     * @var $user WP_User
     */
    private $user;


    public function getUser() {
        if (isset($this->user) && $this->user !== null) {
            return $this->user->exists() ? $this->user : false;
        }
        return false;
    }

    // overrides base method
    public function getProfileValue($key)
    {
        $result = parent::getProfileValue($key);
        if ($result !== false) {
            $user = $this->getUser();
            if ($user !== false) {
                if ($user->has_prop($key)) {
                    return $user->get($key);
                }
            }
        }
        return empty($result) ? '' : $result;

    }

    public function setUser(WP_User $user) {
        $this->profile = [];
        if (!empty($user) && $user->exists()) {
            $this->user = $user;
            $this->userName = $user->user_login;
        }
        else {
            unset($this->user);
        }
    }

    protected function test()
    {
        return 'wordpress';
    }

    /**
     * @param $id
     * @return mixed
     */
    public function loadById($id)
    {
        $user = get_userdata($id);
        $this->setUser($user);
    }

    /**
     * @param $userName
     * @return mixed
     */
    public function loadByUserName($userName)
    {
         $user = get_user_by('login',$userName);
         $this->setUser($user);
    }



    /**
     * @return mixed
     */
    public function loadCurrentUser()
    {
        $user = wp_get_current_user();
        $this->setUser($user);
        $this->isCurrentUser = true;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isMemberOf(self::WordpressAdminRole);
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        $user = $this->getUser();
        if ($user === false) {
            return array();
        }
        else {
            return $user->roles;
        }
    }

    /**
     * @param $roleName
     * @return bool
     */
    public function isMemberOf($roleName)
    {
        $roleName = TStrings::convertNameFormat($roleName,TStrings::keyFormat);
        $roles = $this->getRoles();
        return in_array($roleName,$roles);
    }

     /**
     * @param string $value
     * @return bool
     */
    public function isAuthorized($value = '')
    {
        $user = $this->getUser();
        if ($user === false) {
            return false;
        }
        $value = TStrings::convertNameFormat($value,TStrings::keyFormat);
        return ($this->isAdmin() || $this->user->has_cap($value));
    }

    /**
     * @return bool
     */
    public function isAuthenticated()
    {
        $user = $this->getUser();
        return ($user !== false);
    }

    protected function loadProfile()
    {
        $this->profile = [];
        $user = $this->getUser();
        if (!empty($user)) {
            $this->profile[TUser::profileKeyFirstName] = $user->user_firstname;
            $this->profile[TUser::profileKeyLastName] = $user->user_lastname;
            $this->profile[TUser::profileKeyFullName] = $user->display_name;
            $this->profile[TUser::profileKeyShortName] = $user->user_nicename;
            $this->profile[TUser::profileKeyEmail] = $user->user_email;
        }
    }

    /**
     * @param $email
     * @return mixed
     */
    public function loadByEmail($email)
    {
        $user = get_user_by('email',$email);
        $this->setUser($user);
    }

    public function isCurrent()
    {
        if (isset($this->isCurrentUser)) {
            return parent::isCurrent();
        }
        if (isset($this->user)) {
            $current_user = wp_get_current_user();
            if ($current_user instanceof WP_User) {
                return $current_user->user_login == $this->user->user_login;
            }
        }
        return false;
    }
}