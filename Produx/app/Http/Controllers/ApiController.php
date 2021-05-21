<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Accion;
use App\Models\Pin;
use GuzzleHttp\Client;





class ApiController extends Controller
{
    public function getIdDevicesByCategoria($idCategoria){
        $dispositivos = Device::select('devices.id')
                        ->where('devices.categoria_id','=',$idCategoria)
                        ->join('pins','devices.pin_id','=','pins.id')
                        ->get();
                        // ->get('devices.id','pins.pin');
        // return ($dispositivos->toJson(JSON_PRETTY_PRINT));
        $dispositivos = json_encode($dispositivos);

        return ($dispositivos);
    }
    public function getPinsByIdDevices($idDevice){
        $dispositivos = Device::select('devices.id','pins.pin')
                        ->where('devices.id','=',$idDevice)
                        ->join('pins','devices.pin_id','=','pins.id')
                        ->get();
                        // ->get('devices.id','pins.pin');
        // return ($dispositivos->toJson(JSON_PRETTY_PRINT));
        $dispositivos = json_encode($dispositivos);

        return ($dispositivos);
    }
    public function insertActionByDevice($idDevice,$tipo){
        $accion = new Accion;
            $accion->device_id=$idDevice;
            $accion->tipo = $tipo;
            $accion->save();
            return "ok";
    }
    public function insertActionByPin($tipo, $pin)
    {
        $idPin = Pin::where('pin','=',$pin)->first();
        $idDevice = Device::where('pin_id','=',$idPin->id)->first();

        
        switch($tipo){
            case 'UP':
                $tipo = 1;
                break;
            case 'DW':
                $tipo = 0;
                break;
            default:
                $tipo = 0;
        }
        $accion = new Accion;
            $accion->device_id=$idDevice->id;
            $accion->tipo = $tipo;
            $accion->save();
        return $idDevice->nombre;
    }
    public function getDatasetByCategoria($idCategoria){
        $dispositivos = Device::where('categoria_id','=',$idCategoria)->get();
        $dispositivos = json_encode($dispositivos);

        return ($dispositivos);
    }
    public function getActionByDevice($idDevice){
        $accion = Accion::select('devices.id','devices.nombre','acciones.tipo')
                            ->join('devices','acciones.device_id','=','devices.id')
                            ->where('device_id','=',$idDevice)->orderByDesc('acciones.created_at')->first();
        
        $accion = json_encode($accion);
        return ($accion);

    }
    public function Seemetrix()
    {
        $client = new Client();
        $url = "https://analytics.3divi.ru/api/v2/statistics/user/2409/devices/dates/?key=807cd9496b9f46ecaa08d7cf3f4451b6&tzo=0&b=2021/05/01%2000:00:00&e=2021/05/21%2000:00:00&d=8006";
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
            dd($responseBody);
    }
}
