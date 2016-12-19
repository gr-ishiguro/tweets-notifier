<?php
namespace App\Controller;

use App\Model\Entity\User;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Routing\Router;


class UsersController extends AppController {

    public function twitter_oauth() {
        $connection = new TwitterOAuth(getenv('CONSUMER_KEY'), getenv('CONSUMER_SECRET'));
        $request_token = $connection->oauth("oauth/request_token",
            ["oauth_callback" => Router::url(['controller' => 'user', 'action' => 'twitter_callback'])]
        );

        $this->request->session()->write("User.oauth_token", $request_token['oauth_token']);
        $this->request->session()->write("User.oauth_token_secret", $request_token['oauth_token_secret']);

        // Twitterの認証画面へリダイレクト
        $url = $connection->url("oauth/authorize",
            ["oauth_token" => $request_token['oauth_token']]
        );
        $this->redirect($url);
    }


    public function twitter_callback() {
        $oauth_token = $this->request->session()->read("User.oauth_token");
        $oauth_token_secret = $this->request->session()->read("User.oauth_token_secret");

        $connection = new TwitterOAuth(getenv('CONSUMER_KEY'), getenv('CONSUMER_SECRET'), $oauth_token, $oauth_token_secret);
        $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

        // ※重要※ ここでもう一度アクセストークンを使って接続をし直す

        // OAuthトークンとシークレットも使って TwitterOAuth をインスタンス化
        $connection = new TwitterOAuth(getenv('CONSUMER_KEY'), getenv('CONSUMER_SECRET'), $access_token['oauth_token'], $access_token['oauth_token_secret']);

        // ユーザー情報をGET
        $user = $connection->get("account/verify_credentials");

        pr($user);
    }
}