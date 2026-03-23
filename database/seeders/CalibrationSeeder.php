<?php

namespace Database\Seeders;

use App\Models\Calibration;
use App\Models\Equipment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CalibrationSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = Equipment::all();
        $admin = User::where('role', 'admin')->first();

        foreach ($equipments as $equipment) {
            // Создаем историю: 1 старая (просроченная) и 1 текущая
            $this->createCalibration($equipment, $admin, -2, -1); // Просрочена год назад

            // Текущая поверка
            // 30% инструментов сделаем с истекающим сроком (через 10 дней), остальные на год вперед
            $daysValid = rand(1, 100) < 30 ? 10 : 365;
            $this->createCalibration($equipment, $admin, 0, $daysValid, true);
        }
    }

    private function createCalibration($equipment, $user, int $startOffsetDays, int $durationDays, bool $isActive = false): void
    {
        $issuedAt = Carbon::today()->addDays($startOffsetDays);
        $expiresAt = $issuedAt->copy()->addDays($durationDays);

        // Если дата истечения в прошлом, статус expired
        $status = $expiresAt->isPast() ? 'expired' : 'active';
        if (!$isActive && $status === 'active') $status = 'voided'; // Для старой истории

        Calibration::create([
            'equipment_id' => $equipment->id,
            'certificate_number' => 'CERT-' . rand(1000, 9999) . '/' . $issuedAt->year,
            'verification_url' => 'https://fgis.gost.ru/fundmetrology/registry/4/items/' . rand(100000, 999999),
            'issued_at' => $issuedAt,
            'expires_at' => $expiresAt,
            'status' => $status,
            'created_by' => $user->id,
        ]);
    }
}
