<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/7/2017
 * Time: 4:39 AM
 */

namespace PeanutTest\scripts;


use Tops\db\model\repository\MailboxesRepository;
use Tops\mail\TMailbox;
use Tops\mail\TPostOffice;

class MailboxTest extends TestScript
{

    public function execute()
    {

/*        $repo = new MailboxesRepository();
        $this->assertNotNull($repo,'mailboxes repository');
        $all = $repo->getAll();
        $this->assertNotEmpty($all,'all');
        print_r($all);
        $mailboxCode = 'two-quakers-support';
        $mailbox = TPostOffice::GetMailboxAddress($mailboxCode);
        print "GetMailboxAddress\n";
        $this->assertNotEmpty($mailbox,'mailbox');*/

/*        $result = TPostOffice::SendMessageToUs('Mister Peanut <terry.sorelle@outlook.com>','Test Message 31','This is a test using formatted address','two-quakers-support');
        $this->assert($result !== false,'Message 1 not sent.');
        print "Tested sendmessageToUs\n";*/

        $result = TPostOffice::SendMessage('terry.sorelle@outlook.com','tsorelle@outlook.com','Testing SendMessage from outlook','test message');
        print "Tested sendmessage\n";
/*
        $result = TPostOffice::SendMessageToUs('Mister Peanut <terry.sorelle@outlook.com>','Test Message 31','This is a test using formatted address','two-quakers-support');
        $this->assert($result !== false,'Message 1 not sent.');
        $result = TPostOffice::SendMessageToUs('terry.sorelle@outlook.com','Test Message 32','This is a test using plain addesss','two-quakers-support');
        $this->assert($result !== false,'Message 2 not sent.');
        $result = TPostOffice::SendMessageFromUs('tls@2quakers.net','Test Message 33','This is a test useing send message from us.','two-quakers-support');
        $this->assert($result !== false,'Message 3 not sent.');
        $result = TPostOffice::SendMessageToUs('tls@2quakers.net','Test Message 34','This is a test using formatted address','two-quakers-support');
        $this->assert($result !== false,'Message 5 not sent.');
        print "Sent 4 messages \n";
        */
    }
}