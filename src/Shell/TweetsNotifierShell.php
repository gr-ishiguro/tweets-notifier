<?php
namespace App\Shell;

use App\Controller\Component\NoticeToEmailComponent;
use App\Controller\Component\NoticeToSlackWebhookComponent;
use App\Controller\Component\TwitterApiComponent;
use Cake\Controller\ComponentRegistry;
use App\Model\Table\NotifyInformationTable;
use App\Model\Entity\NotifyInformation;
use Cake\Console\Shell;
use Psr\Log\LogLevel;
use Abraham\TwitterOAuth\TwitterOAuth;

/**
 * Class TweetsNotiferShell
 * @property NotifyInformationTable        NotifyInformation
 * @property NoticeToEmailComponent        NoticeToEmail
 * @property TwitterApiComponent           TwitterApi
 * @property NoticeToSlackWebhookComponent NoticeToSlackWebhook
 * @package App\Shell
 */
class TweetsNotifierShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('NotifyInformation');

        $this->NoticeToEmail = new NoticeToEmailComponent(new ComponentRegistry());
        $this->NoticeToSlackWebhook = new NoticeToSlackWebhookComponent(new ComponentRegistry());
        $this->TwitterApi = new TwitterApiComponent(new ComponentRegistry());
    }

    public function main()
    {
        $this->TwitterApi->setTwitterOAuth($this->getTwitterOAuth());

        // 通知情報を全て取得
        $query = $this->NotifyInformation->find('all');

        foreach ($query as $row) {
            /** @var NotifyInformation $row */

            // ツイートを検索
            $tweets = $this->TwitterApi->search($row->search_key, $row->last_acquired);

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
    public function notice($notifyInformation, $tweet)
    {
        $title = '新着ツイート通知(' . $notifyInformation->search_key . ')';
        $text = "https://twitter.com/{$tweet->user->screen_name}/status/{$tweet->id}\n"
            . "{$tweet->user->name} @{$tweet->user->screen_name}\n"
            . date('Y-m-d H:i:s', strtotime($tweet->created_at)) . "\n"
            . $tweet->text;

        $this->log('callback:' . $notifyInformation->callback, LogLevel::INFO);
        $this->log('title   :' . $title, LogLevel::INFO);
        $this->log('text    :' . $text, LogLevel::INFO);

        $component = $notifyInformation->component;
        $callback = $notifyInformation->callback;

        // 通知
        $this->$component->notice($callback, $title, $text);
    }

    /**
     * @return TwitterOAuth
     */
    protected function getTwitterOAuth()
    {
        // TODO Twitter OAuthキー
        $access_token = '2896602344-sSIsBFsAAmlwzpHTRgGChf82d8GX4aqJcnKoy9g';
        $access_token_secret = 'nv9P5DPByzYo1qsAdHAMyXZEOVk947KH9dB22WPDqXyav';

        return new TwitterOAuth(getenv('CONSUMER_KEY'), getenv('CONSUMER_SECRET'), $access_token, $access_token_secret);
    }
}
