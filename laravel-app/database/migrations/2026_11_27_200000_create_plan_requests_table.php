<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->date('start_date');
            $table->unsignedTinyInteger('duration_days');
            $table->string('safari_type');
            $table->unsignedTinyInteger('adults');
            $table->unsignedTinyInteger('children');
            $table->json('child_ages');
            $table->unsignedInteger('budget');
            $table->string('accommodation');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('country_code');
            $table->string('phone');
            $table->string('contact_method');
            $table->string('status')->default('requested');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_requests');
    }
};
