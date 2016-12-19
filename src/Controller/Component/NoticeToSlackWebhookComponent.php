<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class NoticeToSlackWebhookComponent extends Component
{
    /**
     * Slack通知
     * @param string $callback [Webhook URL]欄に表示されているURL
     * @param string $title
     * @param string $text
     */
    public function notice($callback, $title, $text)
    {
        // Slackに投稿するメッセージ
        $msg = ['username' => $title, 'text' => $text];
        $msg = json_encode($msg);
        $msg = 'payload=' . urlencode($msg);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $callback);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $msg);
        curl_exec($ch);
        curl_close($ch);
    }
}
