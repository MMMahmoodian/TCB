<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\TwitterUser;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function v2OauthCallback(Request $request)
    {
        $code = $request->get("code");
        $url = config("twitter.urls.oauth.v2.token");
        $clientId = config("twitter.client.id");
        $clientSecret = config("twitter.client.secret");
        try {
            $client = new Client();
            $res = $client->post($url, [
                "headers"       => [
                    "Authorization" => "Basic " . base64_encode("$clientId:$clientSecret")
                ],
                "form_params"   => [
                    "code"          => $code,
                    "grant_type"    => "authorization_code",
                    "client_id"     => $clientId,
                    "redirect_uri"  => route("v2-oauth-callback"),
                    "code_verifier" => "challenge"
                ]
            ]);
            dd($res->getBody()->getContents());
        }catch (\Exception $e){
            dd($e->getMessage());
        }

    }

    public function v1OauthCallback(Request $request)
    {
        $session = $request->session();

        $consumerKey = config('twitter.consumer.key');
        $consumerSecret = config('twitter.consumer.secret');

        $connection = new TwitterOAuth($consumerKey, $consumerSecret);

        $params = [
            "oauth_verifier" => $request->get("oauth_verifier"),
            "oauth_token" => $request->get("oauth_token"),
        ];
        $accessToken = $connection->oauth("oauth/access_token", $params);
        $twitterUser = TwitterUser::updateOrCreate(
            ["twitter_user_id" => $accessToken["user_id"]],
            [
                "twitter_user_id" => $accessToken["user_id"],
                "username" => $accessToken["screen_name"]
            ]
        );
        $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
        $session->put("connection", $connection);
        $session->put("twitter-user", $twitterUser);
        return redirect(route("bulk-block"));
    }
}
