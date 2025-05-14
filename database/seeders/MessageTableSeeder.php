<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            'receiver' => '0789456123',
            'message' => 'This is a test message',
            'status' => 'sent',
            'response_status' => 'success',
            'response_message' => 'SMS sent successfully',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
