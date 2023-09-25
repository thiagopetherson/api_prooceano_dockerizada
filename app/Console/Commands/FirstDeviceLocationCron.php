<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\Device;
use App\Helpers\DeviceLocationHelper; // Chamando o helper
use App\Events\RefreshFirstDeviceLocation; // Importando o evento
use App\Models\DeviceLocation;

class FirstDeviceLocationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firstDeviceLocation:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pegando Coordenadas do Equipamento Atlas';

    public function __construct()
    {
        parent::__construct();        
    }   

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {       
        // Pegando o device daquele respectivo ID
        $device = Device::find(1); 
        
        // Pegando coordenadas aleatórias
        $atlasCoords = DeviceLocationHelper::generateValidCordinatesAtlas();

        // Criando as coordenadas
        $deviceLocations = $device->deviceLocations()->create([            
            'latitude' => $atlasCoords[0],
            'longitude' => $atlasCoords[1],
            'temperature' => rand(10, 30),
            'salinity' => '',
        ]);        

        // Pegando as últimas 5 coordenadas desse equipamento
        $locations = DeviceLocation::where('device_id', 1)->orderBy('created_at','desc')->take(5)->get();
        
        // Disparando
        RefreshFirstDeviceLocation::dispatch($locations);

        return Command::SUCCESS;
    }
}
