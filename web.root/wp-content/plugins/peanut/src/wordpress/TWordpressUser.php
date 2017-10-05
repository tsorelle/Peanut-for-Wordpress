<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/30/2017
 * Time: 7:17 AM
 */

namespace Tops\wordpress;

use Tops\sys\TAbstractUser;
use Tops\sys\TImage;
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
    const WordpressGuestRole = 'guest';

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
        $key = $this->formatProfileKey($key);
        if ($result !== false) {
            $user = $this->getUser();
            if ($user !== false) {
                $wpKey = TStrings::convertNameFormat($key,TStrings::keyFormat);
                if ($user->has_prop($wpKey)) {
                    return $user->get($wpKey);
                }
            }
        }
        return empty($result) ? '' : $result;

    }

    public function setUser(WP_User $user) {
        unset($this->profile);
        if (!empty($user) && $user->exists()) {
            $this->user = $user;
            $this->userName = $user->user_login;
            $this->id = $user->ID;
        }
        else {
            unset($this->user);
        }
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
        $roles = $this->getRoles();
        return (in_array(self::WordpressAdminRole,$roles));
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
        if ($roleName )
        $roleName = TStrings::convertNameFormat($roleName,TStrings::keyFormat);
        $roles = $this->getRoles();
        if (in_array($roleName,$roles)) {
            return true;
        };
        return (in_array(self::WordpressAdminRole,$roles));
    }

     /**
     * @param string $value
     * @return bool
     */
    public function isAuthorized($value = '')
    {
        $authorized = parent::isAuthorized($value);
        if (!$authorized) {
            $user = $this->getUser();
            if ($user === false) {
                $guestRole = wp_roles()->get_role(self::WordpressGuestRole);
                if ($guestRole !== null) {
                    return $guestRole->has_cap($value);
                }
                return false;
            }
            $value = TStrings::convertNameFormat($value, TStrings::keyFormat);
            $authorized = $this->user->has_cap($value);
        }
        return $authorized;
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
        $user = $this->getUser();
        if (!empty($user)) {
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

    function getUserPicture($size = 0, array $classes = [], array $attributes = [])
    {
        if (!$this->isAuthenticated()) {
            return '';
        }
        switch ($size) {
            case 0 :
                $size = 512;
                break;
            case TImage::sizeResponsive :
                $classes[] = 'image-responsive';
                $size = 512;
                break;
            default :
                if ($size > 512) {
                    $size = 512; // maximum size
                }
        }
        $args = [];

        if (!empty($classes)) {
            $args['class'] = join(' ',$classes);
        }

        $i = get_avatar($this->getId(),$size,$this->getUserShortName(),'',$args);
        return $i;

    }
}