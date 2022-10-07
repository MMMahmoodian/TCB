<?php

namespace Database\Seeders;

use App\Models\CyberiUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CyberiUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = Storage::get("cybberi.txt");
        $usernames = preg_split('/\n|\r\n?/', $file);
        foreach ($usernames as $username){
            CyberiUser::updateOrCreate(
                ["username" => $username],
                ["username" => $username]
            );
        }
    }
}
