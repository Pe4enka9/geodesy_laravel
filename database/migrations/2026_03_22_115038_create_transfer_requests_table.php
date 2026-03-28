<?php

use App\Models\Equipments\Equipment;
use App\Models\TransferRequests\Enums\TransferRequestStatusEnum;
use App\Models\Users\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Equipment::class)->constrained();

            $table->foreignIdFor(User::class, 'sender_id')->constrained();
            $table->foreignIdFor(User::class, 'receiver_id')->constrained();

            $table->string('status')->default(TransferRequestStatusEnum::PENDING);

            $table->text('comment')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['receiver_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
