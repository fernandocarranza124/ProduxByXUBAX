<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Accion;
use App\Models\Pin;
use App\Models\Demograficos;
use App\Model\Emocion;
use App\Models\Edad;




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



    // ////////////// SCRIPTS ANALITIX //////////////
    public function storeDataFromAnalitix($id, Request $request)
    {

        if($request->All()){
            $edadId = $this->getEdadId($request);
            $demograficos = new Demograficos;
                
        }else{
            return "no";
        }
        
    }
    public function getEdadId($edad){
        switch ($edad) {
            case 'old':
                $return 4;
                break;
            case 'adult':
                $return 3;
                break;
            case 'kid':
                $return 1;
                break;
            case 'undefinied':
                $return 3;
                break;
            case 'young':
                $return 2;
                break;
            default:
                $return 2;
                break;
        }
    }
    public function showToken() {
        echo csrf_token(); 
  
      }
}
