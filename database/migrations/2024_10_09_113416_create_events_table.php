<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');

            $table->string('venue');
            // $table->string('images');
            $table->date('date');
            $table->string('time');
            $table->boolean('open_comment')->default(true);
            $table->text('description');
            $table->string('type');


            // $table->enum('category', ['culture', 'music', 'sports'])->default('culture');
            $table->boolean('active')->default(true);
            // $table->foreignIdFor(ActivityAttendee::class, 'attendees');
            $table->foreignIdFor(City::class, 'city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
