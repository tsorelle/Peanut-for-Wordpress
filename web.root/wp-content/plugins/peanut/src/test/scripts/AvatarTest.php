<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 10/1/2017
 * Time: 7:57 AM
 */

namespace PeanutTest\scripts;
use \Tops\sys\TUser;
use \Tops\sys\TImage;


class AvatarTest extends TestScript
{

    public function execute()
    {
        $user = TUser::getCurrent();
        // $i = get_avatar('terry.sorelle@outlook.com',512,'','',array('class' => 'img-responsive'));
        $i = $user->getUserPicture(TImage::sizeResponsive);
        print $i;
        $this->assert($i, 'avatar');
    }
}