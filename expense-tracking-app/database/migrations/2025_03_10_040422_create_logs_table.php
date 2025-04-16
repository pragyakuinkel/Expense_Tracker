<?php

use App\Enum\Action;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',17,4);
            $table->morphs('logable');
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            $table->enum('action', [Action::Add->value, Action::Delete->value, Action::Update->value]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statements');
    }
};
