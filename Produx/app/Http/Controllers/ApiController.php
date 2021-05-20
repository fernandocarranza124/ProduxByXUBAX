<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Device;
use App\Models\Accion;
use App\Models\Pin;
use App\Models\Demografico;
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
    public function checkIfPersonIsRegistered($request)
    {
        $demografico = Demografico::where('categoria_id','=',$request->categoria)
                                        ->where('persona_id','=',$request->id)
                                        ->orderBy('created_at','DESC')->first();
        if($demografico == null){
            return false;
        }else{
            return $demografico;
        }
    }
    public function storeNewPersonDetected($request){
        $edadId = $this->getEdadId($request->age);
            $emocionId = $this->getEmocionId($request->emotion);
            $generoId = $this->getGeneroId($request->gender);
            $atento = $this->IsAttentive($request->attentive);
            
            $demograficos = new Demografico;
                $demograficos->emocion_id=$emocionId;
                $demograficos->edad_id=$edadId;
                $demograficos->genero_id=$generoId;
                $demograficos->duracion=$request->duration;
                $demograficos->atencion=$atento;
                $demograficos->categoria_id=$request->categoria;
                $demograficos->persona_id=$request->id;
            $demograficos->save();
            return "newPerson";
    }   
    public function updateRecordOfPersonDetected($request, $registro)
    {
        $atento = $this->IsAttentive($request->attentive);        
        $registro->duracion = $request->duration;
        $registro->atencion = $atento;
        $registro->save();
        return "update";
    }

    public function storeDataFromAnalitix($id, Request $request)
    {   
        $fechaActual = (Carbon::now()->toDateString());
        dd ($fechaActual);
        if($request->All()){

            $existePersonaRegistrada= $this->checkIfPersonIsRegistered($request);
            if( $existePersonaRegistrada == false){
                $this->storeNewPersonDetected($request);
            }else{
                $this->updateRecordOfPersonDetected($request, $existePersonaRegistrada);
            }
            return "ok";
        }else{
            return "no";
        }
        
    }
    public function IsAttentive($atento){
        switch ($atento) {
            case true:
                return 1;
                break;
            case false:
                return 0;
                break;
            
            default:
                return 0;
                break;
        }
    }
    public function getEmocionId($emocion){
        switch ($emocion) {
            case 'neutral':
                return 2;
                break;
            case 'angry':
                return 1;
                break;            
            case 'happy':
                return 3;
                break;
            case 'surprised':
                return 4;
                break;
            case 'undefined':
                return 2;
                break;
            default:
                return 2;
                break;
        }
    }
    public function getGeneroId($genero){
        switch ($genero) {
            case 'male':
                return 1;
                break;
            case 'female':
                return 0;
                break;            
            default:
                return 2;
                break;
        }
    }
    public function getEdadId($edad){
        switch ($edad) {
            case 'old':
                return 4;
                break;
            case 'adult':
                return 3;
                break;
            case 'kid':
                return 1;
                break;
            case 'undefinied':
                return 3;
                break;
            case 'young':
                return 2;
                break;
            default:
                return 2;
                break;
        }
    }
    public function showToken() {
        echo csrf_token(); 
  
      }
}
