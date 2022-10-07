<?php

namespace App\Jobs;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\CyberiUser;
use App\Models\TwitterUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BulkBlock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var TwitterUser
     */
    private $twitterUser;
    /**
     * @var TwitterOAuth
     */
    private $twitterConnection;

    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @param TwitterOAuth $connection
     * @param TwitterUser $twitterUser
     */
    public function __construct(TwitterOAuth $connection, TwitterUser $twitterUser)
    {
        $this->twitterConnection = $connection;
        $this->twitterUser = $twitterUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lastBlock = $this->twitterUser->last_blocked_id;
        $userId = $this->twitterUser->id;
        Log::info("Bulk Block\tuser_id:$userId\toffest:$lastBlock");
        $cyberiUsers = CyberiUser::query()->offset($lastBlock)->limit(50)->orderBy("id")->get();
        try {
            foreach ($cyberiUsers as $cyberiUser){
                $update = false;
                Log::info("Blocking $cyberiUser->id");
                if (isset($cyberiUser->twitter_user_id)) {
                    $params = ["user_id" => $cyberiUser->twitter_user_id];
                }else{
                    $params = ["screen_name" => $cyberiUser->username];
                    $update = true;
                }
                $result = $this->twitterConnection->post("/blocks/create", $params);
                Log::info("Blocked $cyberiUser->id");
                $lastBlock = $cyberiUser->id;
                if ($update){
                    $cyberiUser->update([
                        "twitter_user_id" => $result->id_str ?? null
                    ]);
                }
            }
            if ($cyberiUsers->count() > 0){
                BulkBlock::dispatch($this->twitterConnection, $this->twitterUser);
            }
        } finally {
            $this->twitterUser->update([
                "last_blocked_id" => $lastBlock
            ]);
        }
    }
}
