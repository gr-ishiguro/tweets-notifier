<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Mailer\MailerAwareTrait;

class NoticeToEmailComponent extends Component
{
    use MailerAwareTrait;

    /**
     * EMail通知
     * @param string $callback あて先
     * @param string $title
     * @param string $text
     */
    public function notice($callback, $title, $text)
    {
        $this->getMailer('User')->send('tweetNotify', [$callback, $title, $text]);
    }
}
