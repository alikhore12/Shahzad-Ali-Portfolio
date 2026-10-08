<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $owner = DB::table('users')->where('email', 'alikhore12@gmail.com')->first();

        if ($owner) {
            DB::table('users')->where('id', $owner->id)->update(['is_admin' => true]);
        } elseif (! DB::table('users')->where('is_admin', true)->exists()) {
            DB::table('users')->orderBy('id')->limit(1)->update(['is_admin' => true]);
        }
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'alikhore12@gmail.com')->update(['is_admin' => false]);
    }
};
