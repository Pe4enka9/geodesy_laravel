<?php

use App\Models\Calibrations\Enums\CalibrationStatusEnum;
use App\Models\Equipments\Equipment;
use App\Models\Users\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Equipment::class)->constrained()->cascadeOnDelete();
            $table->string('certificate_number');
            $table->string('verification_url');
            $table->date('issued_at');
            $table->date('expires_at');
            $table->string('status')->default(CalibrationStatusEnum::ACTIVE);
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index(['equipment_id', 'expires_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calibrations');
    }
};
