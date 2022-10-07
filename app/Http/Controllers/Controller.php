<?php

namespace App\Http\Controllers;

use App\Http\Helpers\TwitterV1AuthHelper;
use App\Http\Helpers\TwitterV2AuthHelper;
use App\Jobs\BulkBlock;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $twitterV1AuthHelper;
    private $twitterV2AuthHelper;

    /**
     * Controller constructor.
     * @param $twitterV1AuthHelper
     * @param $twitterV2AuthHelper
     */
    public function __construct(TwitterV1AuthHelper $twitterV1AuthHelper, TwitterV2AuthHelper $twitterV2AuthHelper)
    {
        $this->twitterV1AuthHelper = $twitterV1AuthHelper;
        $this->twitterV2AuthHelper = $twitterV2AuthHelper;
    }


    public function index()
    {
        return view("index", [
            "url" => $this->twitterV1AuthHelper->generateAuthorizeUrl()
        ]);
    }

    public function bulkBlock()
    {
        BulkBlock::dispatch(session("connection"), session("twitter-user"));
        return "Blocking...";
    }
}
