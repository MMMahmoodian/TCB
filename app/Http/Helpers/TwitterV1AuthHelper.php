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
        echo route("v1-oauth-callback");
        $tempCredentials = $connection->oauth('oauth/request_token', array("oauth_callback" => route("v1-oauth-callback")));
        if ($tempCredentials["oauth_callback_confirmed"]){
            return $connection->url("oauth/authorize", array("oauth_token" => $tempCredentials['oauth_token']));
        }
        throw new \Exception("Cannot request oauth token from twitter");
    }
}
