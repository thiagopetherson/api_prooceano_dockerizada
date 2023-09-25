<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use App\Models\Device;
use App\Helpers\DeviceLocationHelper; // Chamando o helper
use App\Events\RefreshSecondDeviceLocation; // Importando o evento
use App\Models\DeviceLocation;

class SecondDeviceLocationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secondDeviceLocation:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pegando Coordenadas do Equipamento Baleia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Pegando o device daquele respectivo ID
        $device = Device::find(2); 
        
        // Pegando coordenadas aleatórias
        $baleiaCoords = DeviceLocationHelper::generateValidCordinatesBaleia();

        $deviceLocations = $device->deviceLocations()->create([        
            'latitude' => $baleiaCoords[0],
            'longitude' => $baleiaCoords[1],
            'temperature' => '',
            'salinity' => rand(30, 38),
        ]);

        // Pegando as últimas 5 coordenadas desse equipamento
        $locations = DeviceLocation::where('device_id', 2)->orderBy('created_at','desc')->take(5)->get();

        // Disparando
        RefreshSecondDeviceLocation::dispatch($locations);

        return Command::SUCCESS;
    }
}
