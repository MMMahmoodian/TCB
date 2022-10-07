<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string username
 * @property string twitter_user_id
 * @property integer last_blocked_id
 */
class TwitterUser extends Model
{
    use HasFactory;

    protected $fillable = [
        "username", "twitter_user_id", "last_blocked_id"
    ];
}
