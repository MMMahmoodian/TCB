<?php


namespace App\Http\Helpers;


use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterV1AuthHelper
{
    public function generateAuthorizeUrl()
    {
        $consumerKey = config('twitter.consumer.key');
        $consumerSecret = config('twitter.consumer.secret');
        $connection = new TwitterOAuth($consumerKey, $consumerSecret);
        $tempCredentials = $connection->oauth('oauth/request_token', array("oauth_callback" => route("v1-oauth-callback")));
        if ($tempCredentials["oauth_callback_confirmed"]){
//            session(["oauth_token" => $tempCredentials["oauth_token"]]);
//            session(["oauth_token_secret" => $tempCredentials["oauth_token_secret"]]);
            return $connection->url("oauth/authorize", array("oauth_token" => $tempCredentials['oauth_token']));
        }
        throw new \Exception("Cannot request oauth token from twitter");
    }
}
