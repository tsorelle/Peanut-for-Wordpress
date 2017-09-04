<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/4/2017
 * Time: 9:59 AM
 */

namespace Peanut\testing;

use Tops\sys\TIniSettings;
use Tops\wordpress\TWordPressMailer;
use PHPUnit\Framework\TestCase;

class TWordPressMailerTest extends TestCase
{
    private $enabled;


    private function checkTestsDisabled() {
        if (!isset($this->enabled)) {
            $this->enabled = @mail('test@foo.com', 'Testing server availability', 'Ok');
            if (!$this->enabled) {
                print 'Warning: Test mail server is not running. Tests disabled. Need to run a dummy smtp server (such as smtp4dev) for these tests. ' . "\n";
                $this->assertTrue(true);
            }
        }
        return (!$this->enabled);
    }


    public function testMailer() {
        if ($this->checkTestsDisabled()) {
            return;
        }
        $msg = new \Tops\mail\TEMailMessage();
        $msg->addRecipient('tls@2quakers.net','Terry SoRelle');
        $msg->setSubject('Test message');
        $msg->setMessageBody('Hello world');
        $msg->setFromAddress('admin@foo.com','Administrator');

        $mailer = new TWordPressMailer();
        $result = $mailer->send($msg);
        $this->assertTrue($result);

    }


}
