<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $appends = ['full_documento','full_nro_registro','urgencia_texto'];

    public function operaciones()
    {
        return $this->hasMany(Operacion::class,'idDocumento');
    }
    public function docAtendido()
    {
        return $this->belongsTo(Documento::class,'idDocumentoAtendido');
    }
    public function docReferencia()
    {
        return $this->belongsTo(Documento::class,'idDocumentoReferencia');
    }



    public function getFullDocumentoAttribute()
    {
        if(is_numeric($this->nroDocumentoTipo)){
            $fullNroDocumentoTipo = str_pad($this->nroDocumentoTipo, 4, '0', STR_PAD_LEFT);
        }
        else{
            $fullNroDocumentoTipo = $this->nroDocumentoTipo;
        }
        return "{$this->tipoDocumento->nombre} N° {$fullNroDocumentoTipo}-{$this->siglas}";
    }

    public function getFullNroRegistroAttribute()
    {
        $nroRegistro = ($this->origenDocumento == 0 ? 'I':'E') . str_pad($this->nroDocumento, 8, '0', STR_PAD_LEFT);
        return  $nroRegistro;
    }
    public function getUrgenciaTextoAttribute()
    {
        $tipoUrgencia = [1 => "NORMAL",2 => "URGENTE" ,3 => "MUY URGENTE"];
        
        return  $tipoUrgencia[$this->urgencia];
    }
    
    
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class,'idTipoDocumento');
    }

    public function dependenciaREL()
    {
        return $this->belongsTo(TipoDocumento::class,'idDependencia');
    }
    
    protected $dates = [
    	'fechaRegistro' ,
    	'fechaDocumento'
    ];
 //    protected $casts = [
 //    	'fechaRegistro'  => 'date:Y-m-d',
 //    	'fechaDocumento'  => 'date:Y-m-d',

	// ];
    
}
