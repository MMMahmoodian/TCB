<?php

return [
    'urls' => [
        "oauth" => [
            'v2' => [
                "authorize" => "https://twitter.com/i/oauth2/authorize",
                "token"     => "https://api.twitter.com/2/oauth2/token",
            ],
            'v1' => [
                "request"   => "https://api.twitter.com/oauth/request_token",
                "authorize" => "https://api.twitter.com/oauth/authorize",
                "token"     => "https://api.twitter.com/oauth/access_token",
            ],
        ]
    ],
    "client" => [
        'id'        => env("TWITTER_CLIENT_ID"),
        'secret'    => env("TWITTER_CLIENT_SECRET"),
    ],
    "consumer" => [
        'key'       => env("TWITTER_API_KEY"),
        'secret'    => env("TWITTER_API_SECRET"),
    ]
];
