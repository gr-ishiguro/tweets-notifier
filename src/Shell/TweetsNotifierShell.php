<?php
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
class TweetsNotifierShell extends Shell {

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();
        $this->loadModel('NotifyInformation');
    }

    public function main() {
        // 通知情報を全て取得
        $query = $this->NotifyInformation->find('all');

        foreach ($query as $row) {
            /** @var NotifyInformation $row */

            // ツイートを検索
            $connection = $this->getTwitterOAuth();
            $tweets = $connection->get("search/tweets", ["q" => $row->search_key, 'since_id' => $row->last_acquired]);

            foreach (array_reverse($tweets->statuses) as $tweet) {
                // Callbackへ通知
                $this->notice($row, $tweet);

                // 最終取得IDを更新して保存
                $row->last_acquired = $tweet->id;
                $this->NotifyInformation->save($row);
            }
        }
    }

    /**
     * Callbackへ通知
     * @param NotifyInformation $notifyInformation
     * @param \stdClass         $tweet
     */
    public function notice($notifyInformation, $tweet) {
        $title = '新着ツイート通知(' . $notifyInformation->search_key . ')';
        $text = $tweet->user->name . ' '
            . '@' . $tweet->user->screen_name . "\n"
            . date('Y-m-d H:i:s', strtotime($tweet->created_at)) . "\n"
            . $tweet->text;

        $this->log($notifyInformation->callback, LogLevel::INFO);
        $this->log($title, LogLevel::INFO);
        $this->log($text, LogLevel::INFO);

        if (preg_match('/^email@/', $notifyInformation->callback)) {
            // メール通知
            $to = preg_replace('/^email@/', '', $notifyInformation->callback);
            $this->getMailer('User')->send('tweetNotify', [$to, $title, $text]);
        } else if (preg_match('/^slack@/', $notifyInformation->callback)) {
            // Slack通知
            $url = preg_replace('/^slack@/', '', $notifyInformation->callback);
            $this->noticeToSlack($url, $title, $text);
        }
    }

    /**
     * Slack通知
     * @param string $url [Webhook URL]欄に表示されているURL
     * @param string $title
     * @param string $text
     */
    public function noticeToSlack($url, $title, $text) {
        // Slackに投稿するメッセージ
        $msg = ['username' => $title, 'text' => $text];
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
        $access_token = '2896602344-sSIsBFsAAmlwzpHTRgGChf82d8GX4aqJcnKoy9g';
        $access_token_secret = 'nv9P5DPByzYo1qsAdHAMyXZEOVk947KH9dB22WPDqXyav';

        return new TwitterOAuth(getenv('CONSUMER_KEY'), getenv('CONSUMER_SECRET'), $access_token, $access_token_secret);
    }
}