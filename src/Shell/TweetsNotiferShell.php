<?php
/**
 * Created by PhpStorm.
 * User: usr1600304
 * Date: 2016/11/05
 * Time: 15:03
 */
namespace App\Shell;

use App\Model\Table\NotifyInformationTable;
use App\Model\Entity\NotifyInformation;
use Cake\Console\Shell;
use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Mailer\MailerAwareTrait;
use Psr\Log\LogLevel;


/**
 * Class TweetsNotiferShell
 * @property NotifyInformationTable NotifyInformation
 * @package App\Shell
 */
class TweetsNotiferShell extends Shell {

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();
        $this->loadModel('NotifyInformation');
    }

    public function main() {
        /**
         * 通知情報を全て取得
         * @var NotifyInformation[] $notifyInformationArray
         */
        $notifyInformationArray = $this->NotifyInformation->find('all');

        echo count($notifyInformationArray);

        foreach ($notifyInformationArray as $notifyInformation) {
            var_dump($notifyInformation);

            // ツイートを検索
            $connection = $this->getTwitterOAuth();
            $tweets = $connection->get("search/tweets", ["q" => $notifyInformation->search_key, 'count' => 1]);

            foreach (array_reverse($tweets->statuses) as $tweet) {
                // 最終取得日時より新たなツイートを通知する
                var_dump($tweet);
                if ($notifyInformation->last_acquired < $tweet->id) {
                    $this->notice($notifyInformation, $tweet);

                    // 最終取得日時を更新して保存
                    $notifyInformation->last_acquired = $tweet->id;
                    $this->NotifyInformation->save($notifyInformation);
                }
            }
        }
    }

    /**
     * Callbackへ通知
     * @param NotifyInformation $notifyInformation
     * @param \stdClass         $tweet
     */
    public function notice($notifyInformation, $tweet) {
        $this->out('callbackに通知します:' . $notifyInformation->callback);
        $this->log($notifyInformation->search_key, LogLevel::INFO);
        $this->log($notifyInformation->callback, LogLevel::INFO);
        $this->log($tweet->user->name . ' @' . $tweet->user->screen_name, LogLevel::INFO);
        $this->log(date('Y-m-d H:i:s', strtotime($tweet->created_at)), LogLevel::INFO);
        $this->log($tweet->text, LogLevel::INFO);

        // メール通知
        if (filter_var($notifyInformation->callback, FILTER_VALIDATE_EMAIL)) {
            $this->noticeToEMail($notifyInformation, $tweet);
        } else if (preg_match('/^slack:/', $notifyInformation->callback)) {
            $this->noticeToSlack($notifyInformation, $tweet);
        }
    }

    /**
     * メール通知
     * @param NotifyInformation $notifyInformation
     * @param \stdClass         $tweet
     */
    public function noticeToEMail($notifyInformation, $tweet) {
        $this->getMailer('User')->send('tweetNotify', [$notifyInformation, $tweet]);
    }

    public function noticeToSlack($notifyInformation, $tweet) {
        // [Webhook URL]欄に表示されているURL
        $url = preg_replace('/^slack:/', '', $notifyInformation->callback);
        var_dump($url);

        // Slackに投稿するメッセージ
        $msg = array(
            'username' => '新着ツイート通知(' . $notifyInformation->search_key . ')',
            'text' => $tweet->user->name . ' '
                . '@' . $tweet->user->screen_name . "\n"
                . date('Y-m-d H:i:s', strtotime($tweet->created_at)) . "\n"
                . $tweet->text
        );
        $msg = json_encode($msg);
        $msg = 'payload=' . urlencode($msg);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * @return TwitterOAuth
     */
    protected function getTwitterOAuth() {
        // TODO Twitter OAuthキー
        $consumer_key = 'fFnB5weylKYLzbO5cg3iHBP2I';
        $consumer_secret = 'lmuQRX1w8sGrdMVB4OyswuDhH3F7MsDp7ArU9mUiUyqTJTYAvH';
        $access_token = '2896602344-sSIsBFsAAmlwzpHTRgGChf82d8GX4aqJcnKoy9g';
        $access_token_secret = 'nv9P5DPByzYo1qsAdHAMyXZEOVk947KH9dB22WPDqXyav';

        return new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    }
}