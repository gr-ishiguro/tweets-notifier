<?php
/**
 * Created by PhpStorm.
 * User: usr1600304
 * Date: 2016/11/05
 * Time: 16:55
 */

namespace App\Mailer;

use Cake\Mailer\Mailer;
use App\Model\Entity\NotifyInformation;
use Cake\Chronos\Chronos;

// http://qiita.com/kozo/items/f6511802fb55cbf0efac

class UserMailer extends Mailer
{
    /**
     * @param NotifyInformation $notifyInformation
     * @param \stdClass         $tweet
     */
    public function tweetNotify($notifyInformation, $tweet)
    {
        $content = $tweet->user->name . ' ';
        $content .= '@' . $tweet->user->screen_name . "\n";
        $content .= date('Y-m-d H:i:s', strtotime($tweet->created_at)) . "\n";
        $content .= $tweet->text;

        $this->profile('default')
            ->to($notifyInformation->callback)
            ->from('mizuki.ishiguro@notify-information.local')
            ->subject('新着ツイート通知(' . $notifyInformation->search_key . ')')
            ->template('default')
            ->viewVars(['content' => $content]);
    }
}
