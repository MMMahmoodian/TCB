<?php


namespace App\Http\Helpers;


class TwitterV2AuthHelper
{
    public function generateAuthorizeUrl()
    {
        $baseUrl = config("twitter.urls.oauth.v2.authorize");
        $scope = ["block.read", "block.write"];
        $params = http_build_query([
            "response_type" => "code",
            "client_id" => env("TWITTER_CLIENT_ID"),
            "redirect_uri" => route('v2-oauth-callback'),
            "scope" => implode($scope, " "),
            "state" => "state",
            "code_challenge" => "challenge",
            "code_challenge_method" => "plain",
        ]);
        return "$baseUrl?$params";
    }
}
