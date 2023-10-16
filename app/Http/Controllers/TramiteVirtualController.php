<?php
namespace App\Http\Controllers;

use App\Http\Requests\TramiteVirtualStore;
use App\Mail\TramiteVirtualRegister;
use App\Models\Documento;
use App\Models\User;
use App\Models\NumeracionNumeroDocumento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use URL;

use App\Http\Controllers\OperacionController;
use Auth;
use Endroid\QrCode\QrCode;

class TramiteVirtualController extends Controller
{
    public function handleNumeracionNumeroDocumento($origen)
    {
        $numeracion = NumeracionNumeroDocumento::where('origen', $origen)->first();
        // NumeracionNumeroDocumento::whereId($numeracion->id)
        //     ->increment('numero');
        return $numeracion->numero;
    }

    public function insert(TramiteVirtualStore $request)
    {
        $numeracion = NumeracionNumeroDocumento::where('origen', 1)->first();

        $tramite = new Documento;
        $tramite->nroDocumento = $numeracion->numero; // table numeracion numero documentos[numero] | 0 => interno / 1 => externo
        $tramite->tipoPersona = $request->tipoPersona;
        $tramite->tipoDocumentoPersona = $request->tipoDocumentoPersona;
        $tramite->nroDocumentoPersona = $request->nroDocumentoPersona;
        $tramite->firma = strtoupper($request->firma);
        $tramite->cargoFirma = strtoupper($request->cargoFirma);
        $tramite->dependencia = strtoupper($request->dependencia);
        $tramite->idTipoDocumento = $request->idTipoDocumento;
        // numero documento | file documento
        // interno codigo generate[numero]
        // externo codigo form
        $tramite->nroDocumentoTipo = $request->nroDocumentoTipo;
        $tramite->siglas = strtoupper(ltrim(ltrim($request->siglas, ' ') , '-')); // sigla)s
        $tramite->formaDocumento = 3; // DIGITAL
        $tramite->origenDocumento = true;
        $tramite->urgencia = 1;
        $tramite->folios = $request->folios;
        $tramite->asunto = strtoupper($request->asunto);
        $tramite->adjuntos = strtoupper($request->adjuntos);
        $tramite->fechaDocumento = $request->fechaDocumento;
        $tramite->fechaRegistro = new \Datetime();
        $tramite->emailOrigen = $request->emailOrigen;
        $tramite->celularOrigen = strtoupper($request->celularOrigen);
        $tramite->direccionOrigen = strtoupper($request->direccionOrigen);

        $tramite->idUser = 1;

        $usuario = User::findOrFail($tramite->idUser);
        $tramite->idDependenciaUser = $usuario->idDependencia;
        if ($request->file('archivo'))
        {
            $tramite->archivo = $this->saveFile($request->file('archivo'));
        }
        $tramite->save();
        $operacion = OperacionController::newDocumentRegister($tramite);
        OperacionController::derivadoVirtual($operacion);

        if ($tramite->emailOrigen)
        {
            try
            {
                Mail::to($tramite->emailOrigen)->send(new TramiteVirtualRegister($tramite));
                Mail::to('joelchavez.py@gmail.com')->send(new TramiteVirtualRegister($tramite));
            }
            catch(Exception $e)
            {
                echo "hola";
            }

        }
        NumeracionNumeroDocumento::whereId($numeracion->id)
            ->increment('numero');
        // Mail::to(config('mail.administrator.address'))->send(new TramiteVirtualRegister);
        return $tramite;
    }

    public function saveFile($file)
    {
        $fileName = Carbon::now()->format('dmYHis');
        $extensionFile = $file->getClientOriginalExtension();
        $fullNameFile = $fileName . '.' . $extensionFile;
        $file->storeAs('public/tramite_virtual', $fullNameFile);
        return $fullNameFile;
    }
    public function successInsert(Request $request)
    {

        // $datos = explode('-',$request->datos);
        $documento = Documento::where('id', $request->id)
            ->where('nroDocumentoPersona', $request->documento)
            ->first();
        if ($documento)
        {
            $url = URL::to('/') . "/seguimiento-externo/{$documento->id}/{$documento->nroDocumentoPersona}";
            // $qrCode = base64_encode(\QrCode::format('png')->size(200)->generate($url));
            $qrCode = new QrCode($url);
            $qrCode->setSize(180);
            $image = $qrCode->writeString();
            $imageQR = base64_encode($image);

            return view('tramite_virtual.register', compact('documento', 'imageQR', 'url'));
        }
        else
        {
            return redirect()->route('tramite.virtual');
        }
    }
    public function seguimientoExterno(Request $request)
    {
        $documento = Documento::where('id', $request->id)
            ->with('operaciones','docReferencia','docAtendido')
            ->first();

        if ($documento)
        {
            $url = URL::to('/') . "/seguimiento-externo/{$documento->id}/{$documento->nroDocumentoPersona}";
            // $qrCode = base64_encode(\QrCode::format('png')->size(200)->generate($url));
            $qrCode = new QrCode($url);
            $qrCode->setSize(180);
            $image = $qrCode->writeString();
            $imageQR = base64_encode($image);
            if (Auth::id())
            {
                return view('tramite_virtual.tramite', compact('documento','imageQR'));
            }
            else
            {
                if ($documento->nroDocumentoPersona == $request->documento)
                {
                    return view('tramite_virtual.tramite', compact('documento','imageQR'));
                }
                else
                {
                    return redirect()
                        ->route('tramite.virtual');
                }
            }
        }
        else
        {
            return redirect()
                ->route('tramite.virtual');
        }
    }
    public function buscarBasico(Request $request)
    {
        $documento = Documento::where('origenDocumento',1)->where('nroDocumento',$request->nroDocumento)->first();
        if ($documento) {
            $url = URL::to('/') . "/seguimiento-externo/{$documento->id}/{$documento->nroDocumentoPersona}";
            // $qrCode = base64_encode(\QrCode::format('png')->size(200)->generate($url));
            $qrCode = new QrCode($url);
            $qrCode->setSize(180);
            $image = $qrCode->writeString();
            $imageQR = base64_encode($image);
            return view('tramite_virtual.tramite', compact('documento','imageQR'));
        }
        else{
            return redirect()->back()->withErrors(['documento'=>$request->nroDocumento]);
        }
    }

    public function buscarPersonalizado(Request $request)
    {
        $documentos = Documento::where('origenDocumento',1);
        if ($request->desde && $request->hasta){
            $from    = Carbon::parse($request->desde)
                             ->startOfDay()        // 2018-09-29 00:00:00.000000
                             ->toDateTimeString(); // 2018-09-29 00:00:00

            $to      = Carbon::parse($request->hasta)
                             ->endOfDay()          // 2018-09-29 23:59:59.000000
                             ->toDateTimeString(); // 2018-09-29 23:59:59
            $documentos = $documentos->whereBetween('created_at', [$from, $to]);

        }
        if($request->dependencia){
            $documentos = $documentos->where('dependencia','LIKE',"%$request->dependencia%");
        }
        if($request->firma){
            $documentos = $documentos->where('firma','LIKE',"%$request->firma%");
        }
        if($request->tipoDocumento){
            $documentos = $documentos->where('idTipoDocumento',$request->tipoDocumento);
        }
        if($request->nroDocumento){
            $documentos = $documentos->where('nroDocumentoTipo',$request->nroDocumento);
        }
        if($request->firma){
            $documentos = $documentos->where('asunto','LIKE',"%$request->asunto%");
        }
        $documentos = $documentos->get();

        if($documentos){
            return view("tramite_virtual.resultadoBuscar", compact('documentos'));
        }else{
            return redirect()->back()->withErrors(['personalizado'=>true])->withInput();
        }
       
    }
    
}


