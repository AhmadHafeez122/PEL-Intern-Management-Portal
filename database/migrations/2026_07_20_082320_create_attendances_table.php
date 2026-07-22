<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->enum('status', ['Present', 'Absent', 'Leave'])->default('Present');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('attendances');
    }
};
