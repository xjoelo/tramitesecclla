<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Peru\Jne\DniFactory;
use App\Models\Persona;
class ConsultaApiController extends Controller
{
	public function consultar( Request $request)
	{
		$persona = Persona::where('nroDocumento',$request->documento)->first();
		if($persona){
			return $persona;
		}
		if($request->tipo == 'dni'){
			$datos = $this->consultaDNI($request->documento);
		}
		else{
			$datos = $this->consultaRUC($request->documento);
		}
		return $datos;
	    
	}

	private function consultaDNI($dni){

		$dni = $dni;

		$typeDocument = 1; //1 DNI , 6 RUC
        $documentNumber = $dni;
        $labelDocument = ['1' => 'dni','6' => 'ruc'][$typeDocument];
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL => "https://api.softicslab.com/consulta/{$labelDocument}?{$labelDocument}={$documentNumber}&_token=_boOeQrIPxwTN3jBvaafV9bt7k51qHFG06G_",
            CURLOPT_RETURNTRANSFER => true,
           CURLOPT_CUSTOMREQUEST => "GET",
           CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($curl);
        $person = json_decode($response,true);
        $error = curl_error($curl);

        // return $person['apellidoPaterno'];

		// $factory = new DniFactory();
		// $cs = $factory->create();
		// $person = $cs->get($dni);
		// if (!$person) {
		//     echo 'Not found';
		//     return;
		// }
		// // echo json_encode($person);
		$persona = new Persona;

		$persona->tipoDocumento = "DNI";
		$persona->nroDocumento = $dni;
		$persona->apellidoPaterno =$person['apellidoPaterno'];
		$persona->apellidoMaterno =$person['apellidoMaterno'];
		$persona->nombres = $person['nombres'];
		$persona->fullName = $person['nombres'] ." ".$person['apellidoPaterno']." ".$person['apellidoMaterno'];


		$persona->save();


		return $persona;
	}
	private function consultaRUC($ruc){
		$curl = curl_init();
    	curl_setopt_array($curl, array(
	        CURLOPT_URL => "http://api.softicslab.com/ruc/{$ruc}",
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_CUSTOMREQUEST => "GET",
	        CURLOPT_SSL_VERIFYPEER => false
	    ));
	    $response = curl_exec($curl);
	    // return $response;
	    $datos =json_decode($response,true);

	    $err = curl_error($curl);
	    curl_close($curl);
	    if ($err) {
	        // return "cURL Error #:" . $err;
	        return 'error';
	    } else {
	    	
	    	$persona = new Persona;

			$persona->tipoDocumento = 'RUC';
			$persona->nroDocumento = $ruc;
			$persona->fullName = $datos['nombre_razon_social'];
			$persona->direccion= $datos['direccion_completa'];
			if ($persona->ubigeoDatos) {
				$persona->departamento = $datos['ubigeoDatos']['departamento'];
				$persona->provincia = $datos['ubigeoDatos']['provincia'];
				$persona->distrito = $datos['ubigeoDatos']['distrito'];
			 } 
			 else{
			 	$persona->departamento = "-";
				$persona->provincia = "-";
				$persona->distrito = "-";

			 }
				
	
			$persona->save();
			return $persona;
	    }

	}
}
