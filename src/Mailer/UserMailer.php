<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class UserMailer extends Mailer
{
    /**
     * @param string $to
     * @param string $title
     * @param string $text
     */
    public function tweetNotify($to, $title, $text)
    {
        $this->profile('default')
            ->to($to)
            ->from('mizuki.ishiguro@notify-information.local')
            ->subject($title)
            ->template('default')
            ->viewVars(['content' => $text]);
    }
}
