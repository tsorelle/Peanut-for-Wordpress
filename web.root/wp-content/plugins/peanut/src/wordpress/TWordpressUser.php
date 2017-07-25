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
use WP_User;

/**
 * Class TConcrete5User
 * @package Tops\sys
 *
 */
class TWordpressUser extends TAbstractUser
{
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
        $user = $this->getUser();
        if ($user !== false && $user->has_prop($key)) {
            return $user->get($key);
        }
        return false;
    }

    // overrides base method
    public function setProfileValue($key,$value) {
        $user = $this->getUser();
        if ($user !== false && $user->has_prop($key)) {
            // todo: implemtent profile update
            throw new \Exception("Method 'TWordPressuser:setProfileValue' not implemanted");
        }
    }


    public function setUser(WP_User $user) {
        if (!empty($user) && $user->exists()) {
            $this->user = $user;
        }
        else {
            $this->user = null;
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
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->isMemberOf('administrator');
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
        return (in_array('administrator', $user->roles) || $this->user->has_cap($value));
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
        // not used in Wordpress implementaton.
        throw new \Exception("Method 'TWordpressUser::loadProfile' not implemented");
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
}