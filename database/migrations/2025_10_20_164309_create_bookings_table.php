<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id');
            $table->foreignId('client_id');
            $table->datetime('start_datetime');
            $table->datetime('end_datetime');
            $table->boolean('is_recurring')->default(false);
            $table->string('rrule')->nullable();//freq, interval, byweekday, bymonthday, bysetpos and until
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
