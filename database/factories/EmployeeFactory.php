<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
{
    return [
        'employee_name' => $this->faker->name(),
        'employee_hours' => $this->faker->numberBetween(4, 12),
        'employee_rate' => $this->faker->numberBetween(100000, 500000),
        'extra_cost' => $this->faker->numberBetween(0, 50000),
        'task_description' => $this->faker->randomElement([
            'Menyiapkan laporan keuangan bulanan',
            'Melakukan input data pegawai',
            'Mengecek stok barang di gudang',
            'Membuat presentasi proyek klien',
            'Menyusun jadwal kerja mingguan',
            'Melakukan update sistem inventaris',
            'Menghubungi klien untuk follow-up',
            'Melakukan pengecekan kualitas produk',
            'Membuat dokumen kontrak kerja',
            'Melakukan pelatihan staf baru',
        ]),
    ];
}
}
