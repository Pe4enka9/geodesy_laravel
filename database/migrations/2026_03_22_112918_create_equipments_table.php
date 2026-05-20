<?php

use App\Models\EquipmentModel;
use App\Models\Equipments\Enums\EquipmentStatusEnum;
use App\Models\EquipmentType;
use App\Models\Users\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EquipmentType::class, 'type_id')->constrained();
            $table->string('inventory_number')->unique();
            $table->string('serial_number')->nullable();
            $table->foreignIdFor(EquipmentModel::class, 'model_id')->nullable()->constrained();
            $table->string('status')->default(EquipmentStatusEnum::ACTIVE);
            $table->foreignIdFor(User::class, 'current_holder_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('inventory_number');
            $table->index('status');
            $table->index('current_holder_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
