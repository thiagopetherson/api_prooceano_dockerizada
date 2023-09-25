<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Device;
use App\Models\DeviceLocation;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        // Isso é feito porque os id's dos devices devem ser 1 e 2. Então precisamos truncar a tabela
        Schema::disableForeignKeyConstraints();
        DeviceLocation::truncate();
        Device::truncate();
        Schema::enableForeignKeyConstraints();

        Device::insert([
            [
                'name' => 'Equipamento Atlas',
                'description' => 'Medidor de temperatura da água',                
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Equipamento Baleia',
                'description' => 'Medidor de salinidade da água',                
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
