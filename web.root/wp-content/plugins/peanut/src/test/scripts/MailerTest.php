<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/8/2017
 * Time: 7:21 AM
 */

namespace PeanutTest\scripts;



use Tops\wordpress\TWordPressMailer;

class MailerTest extends TestScript
{
    public function execute()
    {
        $msg = new \Tops\mail\TEMailMessage();
        $this->assertNotNull($msg, 'no message class');
        $msg->addRecipient('tls@2quakers.net', 'Terry SoRelle');
        $msg->setSubject('Test message');
        $msg->setMessageBody('Hello world');
        $msg->setFromAddress('admin@foo.com', 'Administrator');
        $msg->setReturnAddress('bounce@foo.com');
        $msg->addAttachment('testfile');

        $mailer = new TWordPressMailer();

        $result = $mailer->send($msg);
        $this->assert($result,'Mail send failed.');

    }
}