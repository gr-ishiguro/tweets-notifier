<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterApiComponent extends Component
{
    /**
     * @var TwitterOAuth
     */
    protected $connection;

    /**
     * @param TwitterOAuth $twitterOAuth
     */
    public function setTwitterOAuth($twitterOAuth)
    {
        $this->connection = $twitterOAuth;
    }

    /**
     * ツイートを検索
     * @param string $searchKey
     * @param string $lastAcquired
     * @return array|object
     */
    public function search($searchKey, $lastAcquired = '')
    {
        $option = ["q" => $searchKey];
        if (!empty($lastAcquired)) {
            $option['since_id'] = $lastAcquired;
        }
        return $this->connection->get("search/tweets", $option);
    }
}
