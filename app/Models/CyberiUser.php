<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string username
 * @property string twitter_user_id
 */
class CyberiUser extends Model
{
    use HasFactory;

    protected $fillable = [
        "username", "twitter_user_id"
    ];
}
