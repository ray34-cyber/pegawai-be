<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        $taskNames = [
            'Laporan Mingguan',
            'Rapat Koordinasi',
            'Presentasi Proyek',
            'Review Kinerja',
            'Pemeliharaan Sistem',
            'Perencanaan Anggaran',
            'Audit Internal',
            'Update Dokumentasi',
            'Pengujian Aplikasi',
            'Meeting Klien',
        ];


        return [
            'task_name' => fake()->randomElement($taskNames),
            'task_date' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'total_remuneration' => 0, // akan dihitung setelah relasi di seeder
        ];
    }
}
