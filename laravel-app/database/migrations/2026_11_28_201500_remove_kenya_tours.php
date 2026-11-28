<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $ids = DB::table('tours')->whereIn('slug', ['mara-classic', 'amboseli-tsavo'])->pluck('id');
        if ($ids->isEmpty()) {
            return;
        }

        DB::table('bookings')->whereIn('tour_id', $ids)->delete();
        DB::table('diary_entries')->whereIn('tour_id', $ids)->delete();
        DB::table('tours')->whereIn('id', $ids)->delete();
    }

    public function down(): void
    {
        //
    }
};
