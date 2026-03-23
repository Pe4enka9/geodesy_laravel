<?php

use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Equipment::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->foreignIdFor(User::class, 'from_user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(User::class, 'to_user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('occurred_at');
            $table->text('comment')->nullable();
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->timestamps();

            $table->index(['equipment_id', 'occurred_at']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
