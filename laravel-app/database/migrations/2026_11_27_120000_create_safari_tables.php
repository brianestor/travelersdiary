<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('region');
            $table->string('country');
            $table->unsignedTinyInteger('duration_days');
            $table->text('summary');
            $table->text('field_note');
            $table->timestamps();
        });

        Schema::create('itinerary_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day');
            $table->string('title');
            $table->text('body');
        });

        Schema::create('tour_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->string('kind');
            $table->unsignedSmallInteger('sort');
            $table->string('body');
        });

        Schema::create('departures', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('tour_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedTinyInteger('capacity');
            $table->unsignedTinyInteger('seats_taken')->default(0);
            $table->unsignedInteger('price_per_person');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('tour_id')->constrained();
            $table->string('departure_id');
            $table->foreign('departure_id')->references('id')->on('departures');
            $table->unsignedTinyInteger('adults');
            $table->unsignedTinyInteger('children');
            $table->string('lead_name');
            $table->string('email');
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->string('status')->default('requested');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('place');
            $table->date('entry_date');
            $table->foreignId('tour_id')->constrained();
            $table->json('paragraphs');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diary_entries');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('departures');
        Schema::dropIfExists('tour_lines');
        Schema::dropIfExists('itinerary_days');
        Schema::dropIfExists('tours');
    }
};
